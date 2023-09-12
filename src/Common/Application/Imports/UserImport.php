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
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
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
                $planEloquent = PlanEloquentModel::find(1);
                $subscriptionData = [
                    'start_date' => now(),
                    'end_date' => now(),
                    'payment_date' => now(),
                    'payment_status' => 'PAID',
                    'stripe_status' => "ACTIVE",
                    'stripe_price' =>  $planEloquent->price,
                ];
                $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
                B2cUserEloquentModel::create([
                    "user_id" => $userEloquenet->id,
                    "current_subscription_id" => $subscriptionOne->id,
                ]);
                B2cSubscriptionEloquentModel::create([
                    "subscription_id" => $subscriptionOne->id,
                    "user_id" => $userEloquenet->id,
                    "plan_id" => $planEloquent->id
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
