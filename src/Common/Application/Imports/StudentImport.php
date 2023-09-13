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
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class StudentImport implements SkipsOnError, SkipsOnFailure, ToCollection, WithHeadingRow, WithValidation
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
            foreach ($rows as $row) {
                $create_data = [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'contact_number' => $row['contact_number'],
                    'email' => $row['email'],
                    'role_id' => 6,
                ];
                $userEloquent = UserEloquentModel::create($create_data);
                $create_student = [
                    'user_id' => $userEloquent->id,
                    'gender' => $row['gender'],
                    'dob' => $row['dob'],
                    'education_level' => $row['education_level'],
                ];
                $studentEloquent = StudentEloquentModel::create($create_student);
                $studentEloquent->organizations()->sync([$this->request->organization_id]);
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required'],
            'dob' => ['required'],
            'contact_number' => ['required'],
            'education_level' => ['required'],
        ];
    }
}
