<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-3day', '+3day');

        return [
            'user_id' => $this->faker->numberBetween(1,10),
            'work_start' => $date->format('Y-m-d 08:00:00'),
            'work_end' => $date->format('Y-m-d 17:i:s'),
        ];
    }
}
