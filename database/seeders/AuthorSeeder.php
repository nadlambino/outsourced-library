<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Library;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $authors = [
            ['name' => 'Doris Kearns Goodwin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Neil deGrasse Tyson', 'created_at' => $now, 'updated_at' => $now],
        ];

        Author::query()->insert($authors);
    }
}
