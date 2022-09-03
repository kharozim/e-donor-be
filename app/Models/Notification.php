<?php

namespace App\Models;

use App\Utils\FormatTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, FormatTimestamp;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];
}
