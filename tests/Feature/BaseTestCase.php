<?php

namespace WirecardSubscription\Tests\Feature;

use Exception;
use PHPUnit\Framework\TestCase;
use WirecardSubscription\WirecardApi;

class BaseTestCase extends TestCase
{
    protected $api;

    public function setUp(): void
    {
        if (! getenv('WIRECARD_TOKEN')) {
            throw new Exception('WIRECARD_TOKEN não informado. Ajuste no arquivo phpunit.xml.');
        }
        if (! getenv('WIRECARD_KEY')) {
            throw new Exception('WIRECARD_KEY não informado. Ajuste no arquivo phpunit.xml.');
        }

        $this->api = new WirecardApi('sandbox', getenv('WIRECARD_TOKEN'), getenv('WIRECARD_KEY'));
    }
}
