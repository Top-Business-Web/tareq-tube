<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeKey extends Model
{
    protected $table = 'youtube_keys';

    protected $fillable = [
        'key',
        'limit',
    ];
}
