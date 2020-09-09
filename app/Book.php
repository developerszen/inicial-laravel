<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'category_id', 'title', 'synopsis', 'image'];

    protected $hidden = ['deleted_at'];

    function authors() {
        return $this->belongsToMany(Author::class);
    }

    function category() {
        return $this->belongsTo(Category::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }
}
