<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    function authors() {
        return $this->belongsToMany(Author::class);
    }
}
