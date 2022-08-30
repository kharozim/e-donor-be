<?php

namespace App\Models;

use App\Utils\FormatTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory, FormatTimestamp;

    protected $fillable =
    [
        'user_id',
        'blood_type_request',
        'address',
        'status',
        'take_by',
    ];

    protected $casts =
    [
        'user_id' => 'integer',
        'status' => 'integer',
        'take_by' => 'integer'
    ];

    protected $appends =
    [
        'user',
        'pendonor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pendonor()
    {
        return $this->belongsTo(User::class, 'take_by');
    }

    public function getUserAttribute()
    {
        return $this->user()->select(['name', 'age'])->first();
    }

    public function getPendonorAttribute()
    {
        return $this->pendonor()->select(['name', 'blood_type', 'age'])->first();
    }

}
