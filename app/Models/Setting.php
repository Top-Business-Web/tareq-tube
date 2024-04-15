<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';

    protected $fillable = [
        'logo',
        'phone',
        'limit_user',
        'point_user',
        'vat',
        'privacy',
        'point_price',
        'limit_balance',
        'token_price',
        'config_box_minute',
        'config_box_min',
        'config_box_max',
        'ad_click_photo',
        'ad_click_video',
        'ad_point',
        'ad_time'
    ];
}
