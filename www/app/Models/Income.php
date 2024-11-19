<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Income extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'wallet_id', 'income_category_id', 'amount', 'date', 'note'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function income_category(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}

