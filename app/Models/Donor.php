<?php

namespace App\Models;

use App\Utils\FormatTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory, FormatTimestamp;

    protected $fillable =
    [
        'user_id',
        'nik',
        'ttl',
        'address',
        'city',
        'status',
        'phone',
    ];

    protected $casts =
    [
        'user_id' => 'integer',
        'status' => 'integer',
        'nik' => 'integer'
    ];

    protected $appends =
    [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserAttribute()
    {
        return $this->user()->select(['name', 'blood_type', 'age', 'is_pendonor'])->first();
    }
}
