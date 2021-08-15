<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\External\AuthorizationException;

class AuthorizationService extends HttpClientService
{
    protected $baseUrl = 'https://run.mocky.io/v3/';

    public function send()
    {
        $response = $this->request('GET', '8fafdd68-a090-496f-8c9a-3442cf30dae6');

        if ($response->message !== 'Autorizado') {
            throw new AuthorizationException();
        }
    }
}
