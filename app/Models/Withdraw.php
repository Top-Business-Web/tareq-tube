<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|int|mixed
     */
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
