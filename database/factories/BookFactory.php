<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(1),
            'publish_date' => $this->faker->date(),
            'page_count' => rand(100,999),
            'avg_reading_time' => rand(30, 360),
            'author_id' => Author::factory(),
        ];
    }

}
