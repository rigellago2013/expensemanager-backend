<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['role'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
     * Role of the user
    */
    public function roles()
    {
        return $this->hasOne(Roles::class);
    }

    /**
     * Format created_at attribute
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y H:m:s');
    }
    /**
     * Get the expense for the blog user.
     */
    public function expense()
    {
        return $this->hasMany(Expense::class);
    }

    public function getRoleAttribute()
    {
        return $this->roles();
    }
}
