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
            foreach ($rows as $row) {
                $create_data = [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['work_email'],
                    'contact_number' => $row['contact_number'],
                    'password' => 'password',
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
            'work_email' => ['required', 'email', 'unique:users,email'],
            'contact_number' => ['required'],
        ];
    }
}
