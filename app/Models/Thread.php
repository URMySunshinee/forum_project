<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags; 

class Thread extends Model
{
    use HasFactory;
    use HasTags;

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Quan hệ với tags
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Quan hệ với follows
    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
