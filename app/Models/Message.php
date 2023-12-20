<?php

namespace App\Models;

use App\Models\{
    City,
    User,
    Interest
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static get()
 * @method static where(string $string, $id)
 * @property string $url
 * @property integer $user_id
 * @property string $content
 * @property integer $city_id
 * @property integer $intrest_id
 */
class Message extends Model
{
    protected $table = 'msg';


    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id')->select('id','name');
    }

    public function intrest(): BelongsTo
    {
        return $this->belongsTo(Interest::class, 'intrest_id', 'id')->select('id','name');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id','name');
    }
}
