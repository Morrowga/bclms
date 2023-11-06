<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Domain\Model\StoryBook;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;
use Src\BlendedConcept\StoryBook\Domain\Resources\StoryBookResource;
use Src\BlendedConcept\StoryBook\Application\Mappers\StoryBookMapper;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\PlaylistEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\TagEloquentModel;

class StoryBookRepository implements StoryBookRepositoryInterface
{
    /**
     * Get a collection of storybooks based on the provided filters.
     *
     * @param  array  $filters The filters to be applied
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * Author @hareom284
     */
    public function getStoryBooks($filters)
    {
        $filterItems = json_decode(request('filterItems'));
        if ($filterItems) {
        } else {
            $filterItems = null;
        }
        // Retrieve storybooks with relationships, order by id in descending order, and paginate the results
        $storyBooks = StoryBookResource::collection(
            StoryBookEloquentModel::filter($filters)
                ->with(['learningneeds', 'themes', 'disability_types', 'devices', 'tags', 'book_versions'])
                ->when($filterItems, function ($query, $filterItems) {
                    $query->when($filterItems->learningneed, function ($query, $learningneed) {
                        $query->whereHas('learningneeds', function ($query) use ($learningneed) {
                            $query->whereIn('id', $learningneed);
                        });
                    });
                    $query->when($filterItems->themes, function ($query, $themes) {
                        $query->whereHas('themes', function ($query) use ($themes) {
                            $query->whereIn('themes.id', $themes);
                        });
                    });
                    $query->when($filterItems->disability_types, function ($query, $disability) {
                        $query->whereHas('disability_types', function ($query) use ($disability) {
                            $query->whereIn('disability_types.id', $disability);
                        });
                    });
                    $query->when($filterItems->devices, function ($query, $devices) {
                        $query->whereHas('devices', function ($query) use ($devices) {
                            $query->whereIn('devices.id', $devices);
                        });
                    });
                })
                ->orderBy('id', 'desc')
                ->paginate($filters['perPage'] ?? 10)
        );

        return $storyBooks;
    }

    public function getStoryBooksForSelect()
    {
        // Retrieve storybooks with relationships, order by id in descending order, and paginate the results
        $storyBooks = StoryBookEloquentModel::select('name', 'id', 'thumbnail_img')->get();

        return $storyBooks;
    }

    /**
     * Create a new storybook based on the provided StoryBook model.
     *
     * @param  StoryBook  $storyBook The StoryBook model that used for static type on ddd pattern
     * @return void
     * Author @hareom284
     */
    public function createStoryBook(StoryBook $storyBook)
    {
        DB::beginTransaction();

        try {
            // Map the StoryBook model to Eloquent
            $storybookEloquent = StoryBookMapper::toEloquent($storyBook);
            $storybookEloquent->save();
            // Sync related databases
            $storybookEloquent->learningneeds()->sync(request()->sub_learning_needs);
            $storybookEloquent->themes()->sync(request()->themes);
            $storybookEloquent->disability_types()->sync(request()->disability_type);
            $storybookEloquent->devices()->sync(request()->devices);

            // Associate tags
            $storybookEloquent->associateTags(request()->tags);

            $teachers = TeacherEloquentModel::pluck('teacher_id');
            foreach ($teachers as $teacherId) {
                $storybookVersion = (new StoryBookVersionEloquentModel);
                $storybookVersion->teacher_id = $teacherId;
                $storybookVersion->h5p_id = $storyBook->h5p_id;
                $storybookVersion->name = "Original Copy";
                $storybookVersion->description = "Original Copy";
                $storybookVersion->storybook_id = $storybookEloquent->id;
                $storybookVersion->save();
            }

            setcookie("h5p_id", "", time() - 3600, "/");
            // Add media to media library
            if (request()->hasFile('thumbnail_img') && request()->file('thumbnail_img')->isValid()) {
                $storybookEloquent->addMediaFromRequest('thumbnail_img')
                    ->toMediaCollection('thumbnail_img', 'media_storybook');
            }
            if (request()->hasFile('storybook_file') && request()->file('storybook_file')->isValid()) {
                $storybookEloquent->addMediaFromRequest('storybook_file')
                    ->toMediaCollection('storybook_file', 'media_storybook');
            }

            if (request()->hasFile('image')) {
                foreach (request()->file('image') as $file) {
                    if ($file->isValid()) {
                        $uploadFile = $storybookEloquent->addMedia($file)
                            ->toMediaCollection('physical_resource_src', 'media_storybook');
                        // $storybookEloquent->file_src = $uploadFile->getFirstMediaUrl('physical_resource_src'); // Corrected the method to get the media URL
                        // $storybookEloquent->update();
                    }
                }
            }

            $organisations = OrganisationEloquentModel::get();

            foreach ($organisations  as $org) {
                if ($org->org_admin) {
                    $user = $org->org_admin->user;
                    $user->notify(new BcNotification(['message' => 'New storybook “' . $storybookEloquent->name . '” has been added.', 'from' => 'System', 'to' => 'Organisation', 'icon' => 'fa:fa-solid fa-book', 'type' => 'HomeAnnounce']));
                }
            }

            $teachers = TeacherEloquentModel::get();
            foreach ($teachers as $teacher) {
                if ($teacher->user) {
                    $toTeacher = $teacher->user;
                    $toTeacher->notify(new BcNotification(['message' => 'New storybook “' . $storybookEloquent->name . '” has been added.', 'from' => 'System', 'to' => 'Teacher', 'icon' => 'fa:fa-solid fa-book', 'type' => 'HomeAnnounce']));
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

    /**
     * Update an existing storybook based on the provided StoryBookData.
     *
     * @param  StoryBookData  $storyBookData The StoryBookData that used as a Data Tranfer Object on DDD pattern
     * @return void
     */
    public function updateStoryBook(StoryBookData $storyBookData)
    {
        DB::beginTransaction();

        try {
            // Convert StoryBookData to an array
            $storyBookArray = $storyBookData->toArray();
            // Find the storybook by ID and fill with the updated data
            $updateStoryBookEloquent = StoryBookEloquentModel::query()->findOrFail($storyBookData->id);
            $updateStoryBookEloquent->fill($storyBookArray);
            $updateStoryBookEloquent->update();

            if ($storyBookArray['delete_tags']) {
                $tags = TagEloquentModel::whereIn('id', $storyBookArray['delete_tags'])->delete();
                $updateStoryBookEloquent->associateTags(request()->tags);
            }
            if (request()->hasFile('thumbnail_img') && request()->file('thumbnail_img')->isValid()) {

                $old_thumbnail = $updateStoryBookEloquent->getFirstMedia('thumbnail_img');
                if ($old_thumbnail != null) {
                    $old_thumbnail->forceDelete();
                }

                $newBookMedia = $updateStoryBookEloquent->addMediaFromRequest('thumbnail_img')->toMediaCollection('thumbnail_img', 'media_game');

                if ($newBookMedia->getUrl()) {
                    $updateStoryBookEloquent->thumbnail_img = $newBookMedia->getUrl();
                    $updateStoryBookEloquent->update();
                }
            }

            $disabilityCollection = collect(request()->disability_type);
            $deviceCollection = collect(request()->devices);
            $themeCollection = collect(request()->themes);
            $learningNeedsCollection = collect(request()->sub_learning_needs);

            $disabilityLength = $disabilityCollection->count();
            $deviceLength = $deviceCollection->count();
            $themeLength = $themeCollection->count();
            $learningneedsLength = $learningNeedsCollection->count();



            if ($deviceLength > 0) {
                $updateStoryBookEloquent->devices()->detach();

                $updateStoryBookEloquent->devices()->attach(request()->devices);
                // Attach new tags (assuming $request contains the new tag IDs)
            }

            if ($disabilityLength > 0) {
                $updateStoryBookEloquent->disability_types()->detach();

                $updateStoryBookEloquent->disability_types()->attach(request()->disability_type);
                // Attach new tags (assuming $request contains the new tag IDs)
            }

            if ($themeLength > 0) {
                $updateStoryBookEloquent->themes()->detach();

                $updateStoryBookEloquent->themes()->attach(request()->themes);
                // Attach new tags (assuming $request contains the new tag IDs)
            }

            if ($learningneedsLength > 0) {
                $updateStoryBookEloquent->learningneeds()->detach();

                $updateStoryBookEloquent->learningneeds()->attach(request()->learningneeds);
                // Attach new tags (assuming $request contains the new tag IDs)
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function deleteStoryBook(int $storybook_id)
    {
    }

    /**
     * Get all sub learning needs.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLearningNeed()
    {
        // Retrieve all sub learning needs
        $learningNeeds = SubLearningTypeEloquentModel::get(['id', 'name']);

        return $learningNeeds;
    }

    /**
     * Get all themes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getthemes()
    {
        // Retrieve all themes
        $themes = ThemeEloquentModel::get(['id', 'name']);

        return $themes;
    }

    /**
     * Get all disability types.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getdisabilitytype()
    {
        // Retrieve all disability types
        $disabilityTypes = DisabilityTypeEloquentModel::get(['id', 'name']);

        return $disabilityTypes;
    }

    /**
     * Get all devices.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getdevice()
    {
        // Retrieve all devices
        $devices = DeviceEloquentModel::get(['id', 'name']);

        return $devices;
    }

    public function getStudentStorybooks($filters)
    {
        $student_id = auth()->user()->student->student_id;
        // dd($student_id);
        // $books = StoryBookResource::collection();
        $books = StoryBookEloquentModel::whereHas("book_versions", function ($query) use ($student_id) {
            $query->whereHas('storybook_assigments', function ($queryTwo) use ($student_id) {
                $queryTwo->where('storybook_assignments.student_id', $student_id);
            });
        })->with(['book_versions' => function ($query) use ($student_id) {
            $query->whereHas('storybook_assigments', function ($queryTwo) use ($student_id) {
                $queryTwo->where('storybook_assignments.student_id', $student_id);
            });
        }, 'result', 'book_versions.storybook_assigments'])->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10);

        // dd($books[0]);
        return $books;
    }

    public function getStudentPlaylists($filters)
    {
        $student_id = auth()->user()->student->student_id;
        $book_playlists =  PlaylistEloquentModel::where('student_id', $student_id)
            ->with(['storybooks' => function ($query) use ($student_id) {
                $query->with(['book_versions' => function ($query) use ($student_id) {
                    $query->whereHas('storybook_assigments', function ($queryTwo) use ($student_id) {
                        $queryTwo->where('storybook_assignments.student_id', $student_id);
                    });
                }, 'book_versions.storybook_assigments']);
            }])->paginate($filters['perPage'] ?? 10);

        return $book_playlists;
    }

    public function updatePhysicalResource($request, StoryBookEloquentModel $storybookEloquent)
    {
        $delete_items = $request->delete_physical_resources ?? [];
        if (count($delete_items) > 0) {
            MediaEloquentModel::whereIn('id', $delete_items)->delete();
        }

        if ($request->hasFile('physical_resources')) {
            foreach ($request->file('physical_resources') as $file) {
                if ($file->isValid()) {
                    $uploadFile = $storybookEloquent->addMedia($file)
                        ->toMediaCollection('physical_resource_src', 'media_storybook');
                }
            }
        }
    }

    public function deleteBook(StoryBookEloquentModel $storyBook)
    {
        try {
            $storyBook->delete();
        } catch (\Exception $e) {
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($e->getMessage());
        }
    }
}
