<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

class NotifyService extends HttpClientService
{
    protected $baseUrl = 'http://o4d9z.mocklab.io/';

    public function send()
    {
        $response = $this->request('GET', 'notify');

        if ($response->message !== 'Success') {
            throw new Exception('erro ao enviar notificação');
        }
    }
}
