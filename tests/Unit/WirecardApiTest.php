<?php

namespace WirecardSubscription\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WirecardSubscription\Resources\Customers;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Resources\Subscriptions;
use WirecardSubscription\Resources\Webhooks;
use WirecardSubscription\WirecardApi;

class WirecardApiTest extends TestCase
{
    protected $api;

    protected function setUp(): void
    {
        $this->api = new WirecardApi();
    }

    protected function tearDown(): void
    {
        $this->api = null;
    }

    public function testShouldReturnCustomersResource()
    {
        $this->assertInstanceOf(Customers::class, $this->api->customers);
    }

    public function testShouldReuseCustomersObject()
    {
        $this->assertSame($this->api->customers, $this->api->customers);
    }
    
    public function testShouldReturnPlansResource()
    {
        $this->assertInstanceOf(Plans::class, $this->api->plans);
    }

    public function testShouldReusePlansObject()
    {
        $this->assertSame($this->api->plans, $this->api->plans);
    }
    
    public function testShouldReturnSubscriptionsResource()
    {
        $this->assertInstanceOf(Subscriptions::class, $this->api->subscriptions);
    }

    public function testShouldReuseSubscriptionsObject()
    {
        $this->assertSame($this->api->subscriptions, $this->api->subscriptions);
    }
    
    public function testShouldReturnWebhooksResource()
    {
        $this->assertInstanceOf(Webhooks::class, $this->api->webhooks);
    }

    public function testShouldReuseWebhooksObject()
    {
        $this->assertSame($this->api->webhooks, $this->api->webhooks);
    }
}
