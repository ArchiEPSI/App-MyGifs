<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CallUserAPI
 */
class CallUserAPI
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
}