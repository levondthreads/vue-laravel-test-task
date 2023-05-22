<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;



    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birthday' => $this->faker->date(),
            'country' => $this->faker->country,
            'year_of_death' => rand(0, 1) ? $this->faker->date('Y-m-d', '-10 days') : null,
        ];
    }
}
