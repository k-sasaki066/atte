<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeImmutable;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = '2024-09-01';
        $end = '2024-10-15';

        for ($id = 1; $id <= 10; $id++) {
            for ($i = new DateTime($start); $i <= new DateTimeImmutable($end); $i->modify('+1 day')) {
            DB::table('attendances')->insert([
                'user_id' => $id,
                'work_start' => $i->format('Y-m-d,08:30:00'),
                'work_end' => $i->format('Y-m-d,17:30:00'),
                'created_at' => $i->format('Y-m-d, 08:30:00'),
                'updated_at' => $i->format('Y-m-d, 17:30:00'),
            ]);
            }
        }
    }
}
