<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'employee_id', 'name', 'role', 'department', 'phone', 'status',
])]
class Staff extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
