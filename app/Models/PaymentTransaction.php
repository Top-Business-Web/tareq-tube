<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $name = 'payment_transactions';

    protected $fillable = [
        'user_id',
        'payment_id',
        'status',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

}
