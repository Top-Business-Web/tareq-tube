<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static get()
 * @method static where(string $string, $id)
 */
class Message extends Model
{
    protected $table = 'msg';
    protected $guarded = [];
}
