<?php

namespace App\Models;

use App\Utils\FormatTimestamp;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, FormatTimestamp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
        'blood_type',
        'role_id',
        'image',
        'age',
        'is_pendonor',
        'image',
        'history_donor_count',
        'token_fcm',
        'nik',
        'reshus'
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
        'age' => 'integer',
        'role_id' => 'integer',
        'is_pendonor' => 'boolean',
        'history_donor_count' => 'integer',
        'nik' => 'integer'
    ];
}
