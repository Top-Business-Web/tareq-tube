<?php

namespace App\Models;

use App\Models\{
    User,
    Package
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageUser extends Model
{
    use HasFactory;

    protected $table = 'package_user';

    protected $fillable = [
        'package_id',
        'user_id',
        'from',
        'to',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function package() : BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
