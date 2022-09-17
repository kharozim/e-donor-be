<?php

namespace App\Models;

use App\Utils\FormatTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory, FormatTimestamp;

    protected $fillable = [
            'title',
            'description',
            'user_id',
            'date',
            'image'
    ];

}
