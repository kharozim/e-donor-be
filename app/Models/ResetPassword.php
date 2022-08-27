<?php

namespace App\Models;

use App\Utils\FormatTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResetPassword extends Model
{
    use HasFactory, FormatTimestamp;

    protected $fillable = [
        'token',
        'user_id',
    ];


    protected $casts = [
        'user_id' => 'integer',
    ];
}
