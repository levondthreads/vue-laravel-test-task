<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = Genre::all()
            ->pluck('id');

        foreach (Book::all() as $book) {
            $book->genres()->attach($genres->random(2));
        }
    }
}
