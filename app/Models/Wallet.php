<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'currency',
        'balance'
    ];

    const BANK = 'Bank card';
    const CASH = 'Cash';
    const KGS = 'KGS';
    const USD = 'USD';
    const TYPES = [
        self::CASH,
        self::BANK
    ];

    const CURRENCIES = [
        self::KGS,
        self::USD
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    public function transfersFrom(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_wallet_id');
    }

    public function transfersTo(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_wallet_id');
    }
}
