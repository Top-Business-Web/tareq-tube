<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    use HasFactory;

    protected $table = 'copons_user';

    protected $fillable = [
        'user_id',
        'copon_id',
    ];
}
