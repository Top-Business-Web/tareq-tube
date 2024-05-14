<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

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

    protected $fillable = [
      'type',
      'count',
      'point',
      'app_name',
       'app_image'
    ];

    protected $appends = [
        'vat_point',
    ];

    protected function getVatPointAttribute()
    {
        $vat = Setting::value('vat');
        // point vat calculate
        $point_vat = $this->points - ($this->points * ($vat / 100));

        $point_gain = 0;

        // view point calculate
        if ($this->type == 'view') {
            $point_gain = $point_vat / $this->viewCount->count;
        } elseif($this->type == 'sub') {
            $point_gain = $point_vat / $this->subCount->count;
        }else{
            $point_gain = $point_vat / $this->appCount->count;
        }

        return number_format($point_gain,0);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function subCount(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'sub_count','id')->select('id','type','count','point');
    }

    public function secondCount(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'second_count','id')->select('id','type','count','point');
    }

    public function viewCount(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'view_count','id')->select('id','type','count','point');
    }
    public function appCount(): BelongsTo
    {
        return $this->belongsTo(ConfigCount::class,'app_count','id')->select('id','type','count','point');
    }

}
