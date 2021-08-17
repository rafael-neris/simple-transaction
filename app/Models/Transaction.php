<?php

namespace App\Models;

use App\Enums\TransactionTypesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'transactions';
    protected $guarded = ['id'];
    protected $fillable = [
        'wallet_id',
        'type',
        'value',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function scopeIn($query)
    {
        return $query->where('type', TransactionTypesEnum::IN);
    }

    public function scopeOut($query)
    {
        return $query->where('type', TransactionTypesEnum::OUT);
    }
}
