<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @property int|mixed $status
 */
class InviteToken extends Model
{

    protected $table = 'invite_tokens';
    protected $guarded = [];
}
