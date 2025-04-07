<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title = [
            'Todo',
            'In Progress',
            'Done',
        ];

        foreach ($title as $data) {
            Status::create(['name' => $data]);
        }
    }
}
