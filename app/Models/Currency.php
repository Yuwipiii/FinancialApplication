<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }
    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }
}
