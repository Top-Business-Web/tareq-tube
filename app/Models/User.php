<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @property string $gmail
 * @property mixed|null $google_id
 * @property mixed $intrest_id
 * @property integer points
 * @property integer limit
 * @property integer msg_limit
 * @property mixed youtube_link
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'gmail',
        'password',
        'google_id',
        'city_id',
        'is_admin',
        'intrest_id',
        'points',
        'limit',
        'msg_limit',
        'youtube_link',

    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function device(): hasone
    {
        return $this->hasOne(DeviceToken::class,'user_id','id');
    }
}
