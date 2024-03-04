<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $from_wallet_id
 * @property mixed $to_wallet_id
 */
class Transfer extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'from_wallet_id',
        'to_wallet_id',
        'currency_id',
        'amount',
        'note',
        'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function fromWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }

    public function currnecy(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
