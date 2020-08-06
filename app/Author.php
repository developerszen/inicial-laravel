<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $hidden = ['deleted_at', 'pivot'];

    function books() {
        return $this->belongsToMany(Book::class);
    }
}
