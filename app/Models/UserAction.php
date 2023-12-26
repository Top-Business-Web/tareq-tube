<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAction extends Model
{
    use HasFactory;

    protected $table = 'user_actions';

    protected $fillable = [
        'user_id',
        'tube_id',
        'type',
        'status',
        'points',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tube() : BelongsTo
    {
        return $this->belongsTo(Tube::class);
    }
}
