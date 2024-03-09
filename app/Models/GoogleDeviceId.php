<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleDeviceId extends Model
{
    protected $table = 'google_device_ids';

    protected $fillable = [
        'device_id',
        'gmail'
    ];
    public function __construct($deviceId = null, $gmail = null)
    {
        if ($deviceId !== null && $gmail !== null) {
            $this->device_id = $deviceId;
            $this->gmail = $gmail;
            $this->save();
        }
    }
}
