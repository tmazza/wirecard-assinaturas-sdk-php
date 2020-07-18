<?php

namespace WirecardSubscription\Resources;

use WirecardSubscription\Resource;

class Webhooks extends Resource
{
    public function endpoint(): string
    {
        return 'users/preferences';
    }

    public function connect($url, $enableMerchant = false, $enableCustomer = false)
    {
        return $this->create([
            'notification' => [
                'webhook' => ['url' => $url],
                'email' => [
                    'merchant' => ['enabled' => $enableMerchant],
                    'customer' => ['enabled' => $enableCustomer],
                ],
            ],
        ]);
    }
}
