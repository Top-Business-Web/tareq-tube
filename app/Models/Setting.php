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
        'token_price'
    ];
}
