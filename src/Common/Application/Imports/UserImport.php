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
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;
    /**
     * @param array $row
     *
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
                    "first_name" => $row['first_name'],
                    "last_name" => $row['last_name'],
                    "email" => $row['work_email'],
                    "contact_number" => $row['contact_number'],
                    "role_id" => 2,
                ];
                $userEloquenet =  UserEloquentModel::create($create_data);

                B2bUserEloquentModel::create([
                    "user_id" => $userEloquenet->id,
                    "organization_id" => $this->request->organization_id,
                    "allocated_storage_limit" => 0,
                    "has_full_library_access" => false
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
