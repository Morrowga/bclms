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
            'name' => 'Ablenet Blue2',
            'description' => 'Dual switch',
            'status' => 'active'
            ],
            [
            'name' => 'Ablenet Switch',
            'description' => 'Single switch',
            'status' => 'active'
            ],
        ];

        foreach ($devices as $device) {
            DeviceEloquentModel::create($device);
        }
    }
    
}
