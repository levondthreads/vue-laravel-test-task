<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'year_of_death',
        'country',
    ];



    public function books() {
        return $this->hasMany(Book::class, 'id', 'author_id');
    }
}
