<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Get the ID of the super admin role.
         *
         * This function retrieves the ID of the super admin role by querying the database for a role with the specified name
         * (usually configured in the 'userrole.bcsuperadmin' configuration). It then extracts the ID of the first matching
         * role using the 'pluck' method.
         *
         * @return int|null The ID of the super admin role if found, or null if no matching role is found.
         * author @hareom284
         */

        $data = [
            'id' => 1,
            'title' => 'Profiling Survey',
            'description' => "Answer these questions to identify the best educational pathway for the student's unique needs and abilities.",
            'type' => 'PROFILING',
            'user_type' => 'B2C_USER',
            'appear_on' => 'LOG_IN',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'required' => true,
            'repeat' => true,
        ];

        $survey = SurveyEloquentModel::create($data);
    }
}
