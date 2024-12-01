<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // Quan hệ với threads
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    // Quan hệ với posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Quan hệ với ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Quan hệ với follows (theo dõi)
    public function followings()
    {
        return $this->morphedByMany(User::class, 'followable', 'follows');
    }

    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
