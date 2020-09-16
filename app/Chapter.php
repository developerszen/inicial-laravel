<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'capitulos';

    public $timestamps = false;

    protected $fillable = ['fk_book', 'title', 'body'];

    function book() {
        return $this->belongsTo(Book::class, 'fk_book');
    }
}
