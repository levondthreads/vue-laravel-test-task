<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;



    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $genres = [
            'Fantasy',
            'Adventure',
            'Romance',
            'Contemporary',
            'Dystopian',
            'Mystery',
            'Horror',
        ];


        return [
            'name' => $genres[rand(0, count($genres) - 1)]
        ];
    }
}
