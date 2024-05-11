<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Author extends Model
{
    use HasFactory;
 
    public function books(){
        return $this->belongsToMany(Book::class,'author_books')->withpivot(['available']);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    } 
}
