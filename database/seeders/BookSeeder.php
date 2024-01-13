<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $doris = Author::query()->firstWhere('name', 'Doris Kearns Goodwin');
        $neil = Author::query()->firstWhere('name', 'Neil deGrasse Tyson');

        $history = Library::query()->firstWhere('name', 'History Library');
        $science = Library::query()->firstWhere('name', 'Science Library');

        $books = [
            [
                'title' => 'Team of Rivals: The Political Genius of Abraham Lincoln',
                'author_id' => $doris->id,
                'library_id' => $history->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'No Ordinary Time: Franklin and Eleanor Roosevelt: The Home Front in World War II',
                'author_id' => $doris->id,
                'library_id' => $history->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'The Bully Pulpit: Theodore Roosevelt, William Howard Taft, and the Golden Age of Journalism',
                'author_id' => $doris->id,
                'library_id' => $history->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Lyndon Johnson and the American Dream',
                'author_id' => $doris->id,
                'library_id' => $history->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Wait Till Next Year: A Memoir',
                'author_id' => $doris->id,
                'library_id' => $history->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Astrophysics for People in a Hurry',
                'author_id' => $neil->id,
                'library_id' => $science->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Death by Black Hole and Other Cosmic Quandaries',
                'author_id' => $neil->id,
                'library_id' => $science->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'The Pluto Files: The Rise and Fall of America\'s Favorite Planet',
                'author_id' => $neil->id,
                'library_id' => $science->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Space Chronicles: Facing the Ultimate Frontier',
                'author_id' => $neil->id,
                'library_id' => $science->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Cosmic Queries: StarTalk\'s Guide to Who We Are, How We Got Here, and Where We\'re Going',
                'author_id' => $neil->id,
                'library_id' => $science->id,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        Book::query()->insert($books);
    }
}
