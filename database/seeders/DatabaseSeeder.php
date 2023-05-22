<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(GenreSeeder::class);


        Author::factory(5)
            ->has(
                Book::factory()->count(3)
            )
            ->create();


        $this->call(BookGenreSeeder::class);
    }
}
