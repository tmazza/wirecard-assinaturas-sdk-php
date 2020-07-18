<?php

namespace WirecardSubscription\Resources;

use WirecardSubscription\Resource;

class Customers extends Resource
{
    public function endpoint(): string
    {
        return 'customers';
    }

    public function enableNewVault()
    {
        $this->withQuery('new_vault', 'true');

        return $this;
    }

    public function setCard($code, $card)
    {
        return $this->update($code, [
            'credit_card' => $card,
        ], 'billing_infos');
    }
}
