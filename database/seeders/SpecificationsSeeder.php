<?php

namespace Database\Seeders;

use App\Models\Specification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class  SpecificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specifications')->insert([
            [
                'title' => 'qa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'pm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'developer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
