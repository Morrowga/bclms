<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class StorybookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storybooks = [
            [
                'name' => 'Toy Story 1',
                'description' => 'nice book',
                'thumbnail_img' => 'images/image2.png',
                'num_gold_coins' => 1,
                'num_silver_coins' => 10,
                'is_free' => true,
            ],
            [
                'name' => 'Toy Story 2',
                'description' => 'nice book 2',
                'thumbnail_img' => 'images/image2.png',
                'num_gold_coins' => 1,
                'num_silver_coins' => 10,
                'is_free' => true,
            ],
            [
                'name' => 'Toy Story 3',
                'description' => 'nice book 3',
                'thumbnail_img' => 'images/image2.png',
                'num_gold_coins' => 1,
                'num_silver_coins' => 10,
                'is_free' => true,
            ],
            [
                'name' => 'Toy Story 4',
                'description' => 'nice book 4',
                'thumbnail_img' => 'images/image2.png',
                'num_gold_coins' => 1,
                'num_silver_coins' => 10,
                'is_free' => true,
            ],
            [
                'name' => 'The Boy',
                'description' => 'nice and action book',
                'thumbnail_img' => 'images/image2.png',
                'num_gold_coins' => 1,
                'num_silver_coins' => 10,
                'is_free' => true,
            ],
        ];

        foreach ($storybooks as $storybook) {
            $storybookCreate = StoryBookEloquentModel::create($storybook);
        }
    }
}
