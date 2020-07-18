<?php

namespace WirecardSubscription\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WirecardSubscription\Requester;
use WirecardSubscription\Resource;
use WirecardSubscription\Response;

class ResponseTest extends TestCase
{
    protected function setUp(): void
    {
    }

    protected function tearDown():void
    {
    }

    
    public function test_getObject_should_return_object()
    {
        $data = ['resource' => ['resourceContent']];
        $response = new Response(200, $data);
        
        $this->assertSame($data, $response->getObject());
    }
    
    public function test_getList_should_return_resource_collection()
    {
        $data = ['resource' => ['resourceContent']];
        $response = new Response(200, $data);

        $this->assertSame($data['resource'], $response->getList());
    }

    public function test_getList_should_return_empty_list()
    {
        $data = ['wrongFormatNoParentToResource' => []];
        $response = new Response(200, $data);

        $this->assertSame([], $response->getList());
    }
    
    public function test_isOk_should_return_true()
    {
        $response = new Response(200, []);
        $this->assertTrue($response->isOk());
    }
    
    public function test_isOk_should_return_false()
    {
        $statusList = [100, 201, 300, 400, 401, 403, 404, 500];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertFalse($response->isOk());
        }
    }
    
    public function test_isSuccessful_should_return_true()
    {
        $statusList = [200, 201, 202, 203, 250, 299];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertTrue($response->isSuccessful());
        }
    }
    
    public function test_isSuccessful_should_return_false()
    {
        $statusList = [100, 199, 300, 400, 401, 403, 404, 500];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertFalse($response->isSuccessful());
        }
    }
    
    public function test_isNotFound_should_return_true()
    {
        $response = new Response(404, []);
        $this->assertTrue($response->isNotFound());
    }

    public function test_isNotFound_should_return_false()
    {
        $statusList = [100, 200, 201, 300, 400, 401, 403, 500];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertFalse($response->isNotFound());
        }
    }
}
