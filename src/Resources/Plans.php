<?php

namespace WirecardSubscription\Resources;

use WirecardSubscription\Resource;

class Plans extends Resource
{
    public function endpoint(): string
    {
        return 'plans';
    }

    public function activate($code)
    {
        return $this->update($code, [], 'activate');
    }

    public function inactivate($code)
    {
        return $this->update($code, [], 'inactivate');
    }
}
