<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'publish_date',
        'page_count',
        'avg_reading_time',
        'author_id',
    ];

    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre', 'book_id', 'genre_id');
    }
}
