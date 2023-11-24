<?php

namespace Src\Common\Application\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class UserImport implements SkipsOnError, SkipsOnFailure, ToCollection, WithHeadingRow, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection(Collection $rows)
    {
        // dd($rows);
        DB::beginTransaction();

        try {
            $organisation = OrganisationEloquentModel::find($this->request->organisation_id);
            if ($organisation->subscription) {

                $b2b_subscription = $organisation->subscription->b2b_subscription;
                if ($b2b_subscription) {
                    $total_teacher_licenses = $b2b_subscription->num_teacher_license;
                    $current_total_teacher_licenses = 0;
                    if ($organisation->teachers) {
                        $current_total_teacher_licenses = $organisation->teachers()->count();
                    }
                    $avaliable_licenses = $total_teacher_licenses - $current_total_teacher_licenses;
                    $enter_rows = count($rows);
                    // dd($total_teacher_licenses);
                    if ($enter_rows > $avaliable_licenses) {
                        return throw new \Exception("License not enough to create teachers");
                    } else {
                        foreach ($rows as $row) {
                            $create_data = [
                                'first_name' => $row['first_name'],
                                'last_name' => $row['last_name'],
                                'email' => $row['work_email'],
                                'contact_number' => $row['contact_number'],
                                'password' => $row['password'],
                                'role_id' => 4,
                                'email_verification_send_on' => now()
                            ];
                            $userEloquenet = UserEloquentModel::create($create_data);

                            TeacherEloquentModel::create([
                                'user_id' => $userEloquenet->id,
                                'organisation_id' => $this->request->organisation_id,
                                'allocated_storage_limit' => 0,
                            ]);
                        }
                    }
                } else {
                    return throw new \Exception("Organisation doesn't have subscription!");
                }
            } else {
                return throw new \Exception("Organisation doesn't have subscription!");
            }

            DB::commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            DB::rollBack();
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'work_email' => ['required', 'email', 'unique:users,email'],
            'contact_number' => ['required'],
        ];
    }
}
