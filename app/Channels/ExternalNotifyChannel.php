<?php

namespace App\Channels;

use App\Exceptions\External\NotifyException;
use App\Services\NotifyService;
use Exception;
use Illuminate\Support\Facades\Log;

class ExternalNotifyChannel
{
    private $notifyService;

    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    public function send($notifiable)
    {
        try {
            $this->notifyService->send();

            Log::info('Notificação enviada', [
                'transaction' => [
                    'id' => $notifiable->id,
                    'wallet_id' => $notifiable->wallet_id,
                    'type' => $notifiable->type,
                    'value' => $notifiable->value
                ]
            ]);
        } catch (NotifyException $exception) {
            $this->logException($exception);
        } catch (Exception $exception) {
            $this->logException($exception);
        }
    }

    private function logException(Exception $exception)
    {
        $exceptionMessage = $exception->getMessage();
        $exceptionCode = $exception->getCode();

        Log::error($exceptionMessage, [
            'code' => $exceptionCode,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }
}
