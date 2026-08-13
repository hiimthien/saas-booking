<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag; // Đừng quên import Model

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sinh ra 30 Tags
        Tag::factory()->count(30)->create();
    }
}
