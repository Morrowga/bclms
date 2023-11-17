<?php

namespace Src\BlendedConcept\Student\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Src\Auth\Application\Mails\EmailVerify;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Student\Domain\Model\Student;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Student\Domain\Resources\StudentResources;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class StudentRepository implements StudentRepositoryInterface
{
    /***
     *  @param $filters
     *
     *  this queries gets students list according to organizaiton_id
     *  with paginated data default is 10
     *  if organisation exits
     */
    public function getStudent($filters)
    {
        // dd('hello');
        $auth = auth()->user()->role->name;
        $paginate_students = StudentResources::collection(
            StudentEloquentModel::with('user', 'organisation', 'disability_types', 'parent', 'teachers')
                ->filter($filters)
                ->when($auth, function ($query, $auth) {

                    if ($auth == 'BC Super Admin') {
                    } elseif ($auth == 'BC Subscriber') {
                        if (auth()->user()->b2bUser == null) {
                            $query->whereHas('parent', function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            });
                        } else {
                            $query->whereHas('teachers', function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            });
                        }
                    } elseif ($auth == 'Teacher') {
                        $classroom_ids = [];
                        $teachers = TeacherEloquentModel::with('classrooms')->where('user_id', auth()->user()->id)->first();
                        foreach ($teachers->classrooms as $classroom) {
                            array_push($classroom_ids, $classroom->id);
                        }
                        $query->whereHas('classrooms', function ($query) use ($classroom_ids) {
                            $query->whereIn('id', $classroom_ids);
                        });
                    } else {
                        $query->where('organisation_id', auth()->user()->organisation_id);
                    }
                })
                ->orderBy('student_id', 'desc')
                // ->where('organisation_id', auth()->user()->organisation_id)
                ->paginate($filters['perPage'] ?? 10)
        );
        $default_students = StudentEloquentModel::latest()->take(5)->get();

        return [
            'paginate_students' => $paginate_students,
            'default_students' => $default_students,
        ];
    }

    public function createStudent(Student $student)
    {

        DB::beginTransaction();

        try {

            $createStudentEloquent = StudentMapper::toEloquent($student);
            $createStudentEloquent->save();
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $createStudentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
            }
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }

        DB::commit();
    }

    public function updateStudent(StudentData $studentData)
    {
        DB::beginTransaction();
        try {
            $studentDataArray = $studentData->toArray();
            $updateStudentEloquent = StudentEloquentModel::findOrFail($studentData->student_id);
            $org_id = $updateStudentEloquent->organisation_id;
            $updateStudentEloquent->fill($studentDataArray);
            $updateStudentEloquent->organisation_id = $org_id;
            $updateStudentEloquent->update();

            //  delete image if reupload or insert if does not exit
            if (request()->hasFile('image') && request()->file('image')->isValid()) {

                $old_image = $updateStudentEloquent->getFirstMedia('image');
                if ($old_image != null) {
                    $old_image->delete();

                    $updateStudentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
                } else {

                    $updateStudentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
                }
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function getStudentsByPagination($filters)
    {
        // if ($auth->name == 'B2C Parent' || $auth->name == 'Both Parent') {
        //     $user_id = auth()->user()->parents->parent_id;
        //     return StudentEloquentModel::filter($filters)->whereHas('parent', function ($query) use ($user_id) {
        //         $query->where('parent_id', $user_id);
        //     })->with('parent', 'user', 'disability_types')->paginate($filters['perPage'] ?? 10);
        // } else

        $auth = auth()->user()->role;
        if ($auth->name == "BC Subscriber") {
            if (auth()->user()->b2bUser == null) {
                $user_id = auth()->user()->parents->parent_id;
                return StudentEloquentModel::filter($filters)->whereHas('parent', function ($query) use ($user_id) {
                    $query->where('parent_id', $user_id);
                })->with('parent', 'user', 'disability_types')->paginate($filters['perPage'] ?? 10);
            } else {
                $user_id = auth()->user()->b2bUser->teacher_id;
                return StudentEloquentModel::filter($filters)->whereHas('teachers', function ($query) use ($user_id) {
                    $query->where('teachers.teacher_id', $user_id);
                })->with('parent', 'user', 'disability_types')->paginate($filters['perPage'] ?? 10);
            }
        } else if ($auth->name == "Teacher") {
            $classRoom_ids = auth()->user()->b2bUser->classrooms()->pluck('id');
            return StudentEloquentModel::filter($filters)
                ->whereHas('classrooms', function ($query) use ($classRoom_ids) {
                    $query->whereIn('id', $classRoom_ids);
                })
                ->with('user', 'disability_types', 'parent')->paginate($filters['perPage'] ?? 10);
            // return StudentEloquentModel::filter($filters)->whereHas('teachers', function ($query) use ($user_id) {
            //     $query->where('teacher_id', $user_id);
            // })->with('parent', 'user', 'disability_types')->paginate($filters['perPage'] ?? 10);
        } else {
            $organisation_id = auth()->user()->organisation_id;

            return StudentEloquentModel::filter($filters)->where('organisation_id', $organisation_id)->with('parent', 'user', 'disability_types')->paginate($filters['perPage'] ?? 10);
        }
    }

    public function showStudent($id)
    {

        $student = new StudentResources(StudentEloquentModel::where('student_id', $id)
            ->with(['user', 'learningneeds', 'disability_types', 'playlists.storybooks', 'parent', 'book_versions.storybook', 'device', 'gameAssignments.game.devices'])
            ->orderBy('student_id', 'desc')
            ->first());
        return $student;
    }

    public function getStudentsByOrgTeacher($filters)
    {
        $teachers = TeacherEloquentModel::with('classrooms')->where('user_id', auth()->user()->id)->first();

        $classroom_ids = [];
        foreach ($teachers->classrooms as $classroom) {
            array_push($classroom_ids, $classroom->id);
        }

        return StudentEloquentModel::filter($filters)->where('organisation_id', auth()->user()->organisation_id)
            ->whereHas('classrooms', function ($query) use ($classroom_ids) {
                $query->whereIn('id', $classroom_ids);
            })

            ->with('user', 'disability_types')->paginate($filters['perPage'] ?? 10);
    }

    public function getDisabilityTypesForStudent()
    {
        $disabilitys = DisabilityTypeEloquentModel::get();
        return $disabilitys;
    }

    public function getLearningNeedsForStudent()
    {
        $learning_types = SubLearningTypeEloquentModel::get();
        return $learning_types;
    }

    public function storeTeacherStudent(Student $student)
    {
        DB::beginTransaction();
        $auth = auth()->user()->role;
        try {
            // if ($auth->name == 'Both Parent' || $auth->name == 'B2C Parent') {
            //     $subscription = auth()->user()->parents->subscription;
            //     $num_student_profiles = $subscription->b2c_subscription->plan->num_student_profiles;
            //     $current_student_count = StudentEloquentModel::where('parent_id', auth()->user()->parents->parent_id)->count();

            //     $coming_student_count = $current_student_count + 1;
            //     if ($coming_student_count > $num_student_profiles) {
            //         return throw new \Exception("License not enough to create student");
            //     }
            // } else

            if ($auth->name == 'BC Subscriber') {
                if (auth()->user()->b2bUser == null) {
                    $subscription = auth()->user()->parents->subscription;
                    $num_student_profiles = $subscription->b2c_subscription->plan->num_student_profiles;
                    $current_student_count = StudentEloquentModel::where('parent_id', auth()->user()->parents->parent_id)->count();
                } else {
                    $teacher_id = auth()->user()->b2bUser->teacher_id;
                    $subscription = auth()->user()->b2bUser->subscription;
                    $num_student_profiles = $subscription->b2c_subscription->plan->num_student_profiles;
                    $current_student_count = StudentEloquentModel::whereHas('teachers', function ($query) use ($teacher_id) {
                        $query->where('teachers.teacher_id', $teacher_id);
                    })->count();
                }

                $coming_student_count = $current_student_count + 1;
                if ($coming_student_count > $num_student_profiles) {
                    return throw new \Exception("License not enough to create student");
                }
            }
            $create_user_data = [
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'role_id' => 6,
                'password' => 'password'
            ];
            $userEloquent = UserEloquentModel::create($create_user_data);

            if ($auth->name == 'BC Subscriber') {
                if (auth()->user()->b2bUser == null) {
                    $parent_id = auth()->user()->parents->parent_id;
                } else {
                    $teacher_id = auth()->user()->b2bUser->teacher_id;
                    $create_parent_data = [
                        'first_name' => $student->parent_first_name,
                        'last_name' => $student->parent_last_name,
                        'contact_number' => $student->contact_number,
                        'email' => $student->email,
                        'role_id' => 7,
                        'password' => 'password'
                    ];

                    $userParentEloquent = UserEloquentModel::create($create_parent_data);

                    $parentEloquent = ParentUserEloquentModel::create([
                        "user_id" => $userParentEloquent->id,
                        "curr_subscription_id" => null,
                        "organisation_id" => null,
                        "type" => "B2B"
                    ]);
                    $bcstaff = UserEloquentModel::where('role_id', 3)->first();

                    \Mail::to($userParentEloquent->email)->send(new EmailVerify($userParentEloquent->full_name, env('APP_URL') . '/verification?auth=' . Crypt::encrypt($userParentEloquent->email), $bcstaff->email, $bcstaff->contact_number));

                    $parent_id = $parentEloquent->parent_id;
                }
            }

            $createStudentEloquent = StudentMapper::toEloquent($student);
            $createStudentEloquent->user_id = $userEloquent->id;
            $createStudentEloquent->student_code = generateUniqueCode();
            $createStudentEloquent->parent_id = $parent_id;
            $createStudentEloquent->num_gold_coins = 0;
            $createStudentEloquent->num_silver_coins = 0;
            $createStudentEloquent->save();

            if ($auth->name != 'B2C Parent' && $auth->name != 'Both Parent') {
                $createStudentEloquent->teachers()->sync([$teacher_id]);
            }

            $createStudentEloquent->disability_types()->sync($student->disability_types);
            $createStudentEloquent->learningneeds()->sync($student->learning_needs);

            // media library save images
            if (request()->hasFile('profile_pics') && request()->file('profile_pics')->isValid()) {
                $createStudentEloquent->addMediaFromRequest('profile_pics')->toMediaCollection('profile_pics', 'media_organisation');
                $userEloquent->profile_pic = $createStudentEloquent->getFirstMediaUrl('profile_pics');
                $userEloquent->update();
            }

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $createStudentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function updateTeacherStudent(StudentData $studentData)
    {
        DB::beginTransaction();
        try {
            $studentDataArrary = $studentData->toArray();

            $studentEloquentModel = StudentEloquentModel::query()->findOrFail($studentData->student_id);
            $user_id = $studentEloquentModel->user_id;
            $parent_id = $studentEloquentModel->parent_id;
            $org_id = $studentEloquentModel->organisation_id;
            $studentEloquentModel->fill($studentDataArrary);
            $studentEloquentModel->organisation_id = $org_id;
            $studentEloquentModel->update();
            $studentEloquentModel->disability_types()->sync($studentData->disability_types);
            $studentEloquentModel->learningneeds()->sync($studentData->learning_needs);

            $userEloquentModel = UserEloquentModel::find($user_id);
            $userEloquentModel->update([
                'first_name' => $studentData->first_name,
                'last_name' => $studentData->last_name,
            ]);
            $parentEloquentModel = ParentEloquentModel::find($parent_id);

            $parentUserEloquemtModel = UserEloquentModel::find($parentEloquentModel->user_id);
            $parentUserEloquemtModel->update([
                'first_name' => $studentData->parent_first_name,
                'last_name' => $studentData->parent_last_name,
                'email' => $studentData->email,
                'contact_number' => $studentData->contact_number,

            ]);
            //for media file upload

            if (request()->hasFile('profile_pics') && request()->file('profile_pics')->isValid()) {
                $old_image = $studentEloquentModel->getFirstMedia('profile_pics');
                if ($old_image !== null) {
                    $old_image->delete();
                }

                $newMediaItem = $studentEloquentModel->addMediaFromRequest('profile_pics')->toMediaCollection('profile_pics', 'media_organisation');

                if ($newMediaItem->getUrl()) {
                    $userEloquentModel = UserEloquentModel::find($studentData->user_id);
                    $userEloquentModel->profile_pic = $newMediaItem->getUrl();
                    $userEloquentModel->update();
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }
}
