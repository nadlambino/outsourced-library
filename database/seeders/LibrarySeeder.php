<?php

namespace Database\Seeders;

use App\Models\Library;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $libraries = [
            ['name' => 'History Library', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Science Library', 'created_at' => $now, 'updated_at' => $now],
        ];

        Library::query()->insert($libraries);
    }
}
