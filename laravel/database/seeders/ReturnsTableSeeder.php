<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnBook;
use Carbon\Carbon;


class ReturnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReturnBook::insert([
            [
                'issue_id' => 1,
                'returned_at' => Carbon::now()->subDays(1),
            ],
        ]);
    }
}
