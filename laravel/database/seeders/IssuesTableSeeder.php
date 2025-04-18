<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Issue;

class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Issue::insert([
            [
                'book_id' => 1,
                'reader_id' => 1,
                'issued_at' => Carbon::now()->subDays(10),
            ],
            [
                'book_id' => 2,
                'reader_id' => 2,
                'issued_at' => Carbon::now()->subDays(5),
            ],
        ]);
    }
}
