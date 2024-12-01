<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description'];

    // Quan hệ với threads
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
