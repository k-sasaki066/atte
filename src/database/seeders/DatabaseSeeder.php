<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        $this->call(AttendanceTableSeeder::class);
        $this->call(RestTableSeeder::class);
        // Attendance::factory(80)->create();
        // Rest::factory(80)->create();
    }
}
