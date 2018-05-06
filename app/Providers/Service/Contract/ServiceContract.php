<?php
namespace App\Providers\Service\Contract;

use App\Providers\Service\Contract\Service;

interface ServiceContract
{
    public function getService(string $serviceKey) : Service;
}
