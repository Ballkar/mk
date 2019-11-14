<?php

namespace App\Models;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Constants\Roles;
use App\Models\Blog\Post;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        static::created(function ($model) {
            event(new UserWasRegistered($model));
        });

        parent::boot();
    }

    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'owner_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role_id === Roles::ROLE_ADMIN;
    }

    public function returnNewToken($remember = false)
    {
        $tokenRes = $this->createToken('Personal Access Token');
        $token = $tokenRes->token;

        if ($remember) $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return $tokenRes;
    }
}
