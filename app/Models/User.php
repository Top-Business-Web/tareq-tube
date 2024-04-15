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
 * @property mixed|string $invite_token
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * @var mixed|string
     */
    protected $guarded = [];

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

    public function interest()
    {
        return $this->belongsTo(Interest::class,'intrest_id','id')->select('id','name');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id')->select('id','name');
    }
    public function rewardBox()
    {
        return $this->belongsTo(RewardBox::class,'reward_box_id','id');
    }
}
