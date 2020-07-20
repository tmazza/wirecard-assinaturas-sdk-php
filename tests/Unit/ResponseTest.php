<?php

namespace WirecardSubscription\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WirecardSubscription\Response;

class ResponseTest extends TestCase
{
    public function testGetObjectShouldReturnObject()
    {
        $data = ['resource' => ['resourceContent']];
        $response = new Response(200, $data);
        
        $this->assertSame($data, $response->getObject());
    }
    
    public function testGetListShouldReturnResourceCollection()
    {
        $data = ['resource' => ['resourceContent']];
        $response = new Response(200, $data);

        $this->assertSame($data['resource'], $response->getList());
    }

    public function testGetListShouldReturnEmptyList()
    {
        $data = ['wrongFormatNoParentToResource' => []];
        $response = new Response(200, $data);

        $this->assertSame([], $response->getList());
    }
    
    public function testIsOkShouldReturnTrue()
    {
        $response = new Response(200, []);
        $this->assertTrue($response->isOk());
    }
    
    public function testIsOkShouldReturnFalse()
    {
        $statusList = [100, 201, 300, 400, 401, 403, 404, 500];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertFalse($response->isOk());
        }
    }
    
    public function testIsSuccessfulShouldReturnTrue()
    {
        $statusList = [200, 201, 202, 203, 250, 299];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertTrue($response->isSuccessful());
        }
    }
    
    public function testIsSuccessfulShouldReturnFalse()
    {
        $statusList = [100, 199, 300, 400, 401, 403, 404, 500];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertFalse($response->isSuccessful());
        }
    }
    
    public function testIsNotFoundShouldReturnTrue()
    {
        $response = new Response(404, []);
        $this->assertTrue($response->isNotFound());
    }

    public function testIsNotFoundShouldReturnFalse()
    {
        $statusList = [100, 200, 201, 300, 400, 401, 403, 500];
        foreach ($statusList as $status) {
            $response = new Response($status, []);
            $this->assertFalse($response->isNotFound());
        }
    }
}
