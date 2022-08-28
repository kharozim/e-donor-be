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

    // $table->integer('user_id');
    // $table->string('blood_type_request');
    // $table->tinyInteger('status');
    // $table->integer('take_by');

}
