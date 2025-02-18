<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     const categories = [
        [
            'name' => 'bug report',
            'type' => 'feedback'
        ],
        [
            'name' => 'feature request',
            'type' => 'feedback'
        ],
        [
            'name' => 'improvement',
            'type' => 'feedback'
        ]
        ];

    public function run(): void
    {
        foreach(self::categories as $category)
        {
            Category::create($category);
        }
    }
}
