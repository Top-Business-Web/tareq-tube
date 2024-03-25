<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeKeyEach extends Model
{
    protected $table = 'youtube_keys_each';

    protected $fillable = [
        'key_id',
    ];

    public function __construct(){
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }
}
