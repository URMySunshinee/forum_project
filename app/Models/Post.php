<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags; 

class Post extends Model
{
    use HasFactory;
    use HasTags;

    // Quan hệ với thread
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Phương thức tính điểm đánh giá trung bình
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

}
