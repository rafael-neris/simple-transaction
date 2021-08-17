<?php

namespace App\Notifications;

use App\Channels\ExternalNotifyChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TransactionReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via()
    {
        return [ExternalNotifyChannel::class];
    }

    public function toNotify()
    {
        return '';
    }
}
