<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $hidden = ['deleted_at'];

    function book() {
        return $this->hasOne(Book::class);
    }
}
