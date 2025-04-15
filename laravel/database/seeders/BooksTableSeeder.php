<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            [
                'title' => '1984',
                'author_id' => 1,
                'published_year' => 1949,
            ],
            [
                'title' => 'Pride and Prejudice',
                'author_id' => 2,
                'published_year' => 1813,
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author_id' => 3,
                'published_year' => 1997,
            ],
        ]);
    }
}
