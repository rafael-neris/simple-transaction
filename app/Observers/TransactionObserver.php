<?php

namespace App\Observers;

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use App\Services\WalletService;
use Exception;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $walletService = resolve(WalletService::class);
        $walletService->updateBalance($transaction->wallet, (int) $transaction->value, $transaction->type);
    }
}
