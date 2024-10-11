<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1month', '+1month');

        return [
            'attendance_id' => $this->faker->numberBetween(1,80),
            'rest_start' => $date->format('Y-m-d 12:00:00'),
            'rest_end' => $date->format('Y-m-d 13:i:s'),
        ];
    }
}
