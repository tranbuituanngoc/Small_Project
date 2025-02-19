<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar',
        'first_name',
        'last_name',
        'last_login_at',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the URL of the user's avatar.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return isset($this->avatar) ? asset('images/' . $this->avatar) : asset('images/default_avatar.png');
    }

    /**
     * Get the image URL for the user.
     *
     * @return string
     */
    public function adminlte_image()
    {
        return isset($this->avatar) ? asset('images/' . $this->avatar) : asset('images/default_avatar.png');
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the hotels for the user.
     */
    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}
