<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static get()
 * @method static where(string $string, $id)
 * @property string $type
 * @property integer $points
 * @property string $url
 * @property integer $sub_count
 * @property integer $second_count
 * @property integer $view_count
 * @property integer $target
 * @property integer $status
 */
class Tube extends Model
{
    protected $table = 'tubes';
    protected $guarded = [];

    public function sub_count(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'sub_count','id');
    }

    public function second_count(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'second_count','id');
    }

    public function view_count(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'view_count','id');
    }

}
