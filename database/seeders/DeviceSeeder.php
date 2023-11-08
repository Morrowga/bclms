<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  $devices = [
            [
            'name' => 'Two Button',
            'description' => 'Dual switch',
            'status' => 'active'
            ],
            [
            'name' => 'One Button',
            'description' => 'Single switch',
            'status' => 'active'
            ],
        ];

        foreach ($devices as $device) {
            DeviceEloquentModel::create($device);
        }
    }
    
}