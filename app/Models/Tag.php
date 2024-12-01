<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

     // Quan hệ đa hình với threads và posts
     public function threads()
     {
         return $this->morphedByMany(Thread::class, 'taggable');
     }
 
     public function posts()
     {
         return $this->morphedByMany(Post::class, 'taggable');
     }
}
