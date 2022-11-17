<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\Uuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';
    protected $userRole;

    public function __construct()
    {
        $this->userRole = new UserRole();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'phone',
        'id_number',
        'photo',
        'address',
        'date_of_birth',
        'place_of_birth',
        'gender',
        'kelas'
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

    protected $appends = [
        'initial_name',
        'role_name',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function getInitialNameAttribute()
    {
        $words = explode(" ", $this->name);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= mb_substr($w, 0, 1);
        }

        return $acronym;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getRoleNameAttribute()
    {
        return $this->userRole->alias($this->role);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
