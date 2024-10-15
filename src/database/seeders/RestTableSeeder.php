<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeImmutable;

class RestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = '2024-09-01';
        $end = '2024-10-14';
        $id = 1;

        for ($j = 1; $j <= 10; $j++) {
            for ($i = new DateTime($start); $i <= new DateTimeImmutable($end); $i->modify('+1 day')) {
            DB::table('rests')->insert([
                'attendance_id' => $id,
                'rest_start' => $i->format('Y-m-d,12:30:00'),
                'rest_end' => $i->format('Y-m-d,13:30:00'),
                'created_at' => $i->format('Y-m-d, 12:00:00'),
                'updated_at' => $i->format('Y-m-d, 13:30:00'),
            ]);
            $id++;
            }
        }
    }
}
