<?php

namespace WirecardSubscription\Resources;

use WirecardSubscription\Resource;

class Subscriptions extends Resource
{
    public function endpoint(): string
    {
        return 'subscriptions';
    }

    public function enableNewUser()
    {
        $this->withQuery('new_customer', 'true');

        return $this;
    }
}
