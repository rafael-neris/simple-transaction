<?php

namespace App\Observers;

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use App\Services\AuthorizationService;
use App\Services\NotifyService;
use App\Services\WalletService;

class TransactionObserver
{
    /**
     * Handle the transaction "creating" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function creating(Transaction $transaction)
    {
        $authorizationService = resolve(AuthorizationService::class);
        $authorizationService->send();
    }

    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $walletService = resolve(WalletService::class);
        $walletService->updateBalance($transaction->wallet, (int) $transaction->value, $transaction->type);

        if ($transaction->type === TransactionTypesEnum::IN) {
            $notifyService = resolve(NotifyService::class);
            $notifyService->send();
        }
    }
}
