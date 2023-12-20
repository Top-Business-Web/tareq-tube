<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static get()
 */
class ConfigCount extends Model
{
    protected $table = 'config_count';
    
    protected $fillable = [
        'type',
        'count',
        'point'
    ];
}
