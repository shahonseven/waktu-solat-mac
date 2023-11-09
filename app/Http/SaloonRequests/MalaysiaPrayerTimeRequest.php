<?php

namespace App\Http\SaloonRequests;

use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;

class MalaysiaPrayerTimeRequest extends SoloRequest
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'http://mpt.i906.my/mpt.json';
    }
}
