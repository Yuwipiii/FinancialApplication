<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'is_goal'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function goal(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Goal::class);
    }

}
