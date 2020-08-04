<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $hidden = ['pivot'];

    function books() {
        return $this->belongsToMany(Book::class);
    }
}
