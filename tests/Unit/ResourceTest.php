<?php

namespace WirecardSubscription\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WirecardSubscription\Requester;
use WirecardSubscription\Resource;
use WirecardSubscription\Response;

class ResourceTest extends TestCase
{
    protected $requester;
    protected $resource;
    protected $endpoint = 'resource';

    protected function setUp(): void
    {
        $this->requester = $this->createMock(Requester::class);
        $this->resource = $this->getMockForAbstractClass(Resource::class, [$this->requester]);
        $this->resource->method('endpoint')->willReturn($this->endpoint);
    }

    protected function tearDown():void
    {
        $this->resource = null;
    }

    public function test_endpoint_should_be()
    {
        $this->assertSame($this->resource->endpoint(), $this->endpoint);
    }
    
    public function test_all_should_call_send_once_with_get()
    {
        $response = $this->createMock(Response::class);
        $response->method('getList')->willReturn([]);

        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('GET', $this->endpoint)
             ->willReturn($response);

        $this->assertSame([], $this->resource->all());
    }
    
    public function test_get_should_call_send_once_with_get()
    {
        $code = 'code';
        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('GET', $this->endpoint . '/' . $code)
             ->willReturn($this->createMock(Response::class));

        $this->assertSame(null, $this->resource->get($code));
    }

    public function test_create_should_call_send_once_with_post()
    {
        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('POST', $this->endpoint)
             ->willReturn($this->createMock(Response::class));

        $this->assertSame(null, $this->resource->create([]));
    }

    public function test_create_should_call_response_getObject()
    {
        $response = $this->createMock(Response::class);
        $response->method('getObject')->willReturn(null);

        $this->requester
             ->method('send')
             ->willReturn($response);

        $this->assertSame(null, $this->resource->create([]));
    }

    public function test_create_should_retrieve_resource()
    {
        $body = ['code' => 'resourceCode'];

        $this->requester
             ->expects($this->exactly(2))
             ->method('send')
             ->withConsecutive(
                 ['POST', $this->endpoint],
                 ['GET', $this->endpoint . '/' . $body['code']]
             )
             ->willReturn($this->createMock(Response::class));

        $this->assertSame(null, $this->resource->create($body));
    }

    public function test_update_should_accept_only_code()
    {
        $code = 'code';
        $body = ['name' => 'resourceName'];

        $this->requester
             ->expects($this->exactly(3))
             ->method('send')
             ->withConsecutive(
                 ['GET', $this->endpoint . '/' . $code],
                 ['PUT', $this->endpoint . '/' . $code],
                 ['GET', $this->endpoint . '/' . $code]
             )
             ->willReturn($this->createMock(Response::class));

        $this->assertSame(null, $this->resource->update($code, $body));
    }

    public function test_update_should_call_pull_with_json_attribute()
    {
        $code = 'code';
        $body = ['name' => 'resourceName'];

        $this->requester
            ->method('send')
            ->willReturn($this->createMock(Response::class));

        $this->requester
            ->expects($this->at(1)) // second call
            ->method('send')
            ->with('PUT', $this->endpoint . '/' . $code, [
                'json' => $body,
            ]);
            
        $this->assertSame(null, $this->resource->update($code, $body));
    }

    public function test_update_should_use_additional_url()
    {
        $code = 'code';
        $additionalUrl = 'function';
        $exceptedEndpoint = $this->endpoint . '/' . $code . '/' . $additionalUrl;

        $this->requester
            ->method('send')
            ->willReturn($this->createMock(Response::class));

        $this->requester
            ->expects($this->at(1)) // second call
            ->method('send')
            ->with('PUT', $exceptedEndpoint, ['json' => []]);
            
        $this->assertSame(null, $this->resource->update($code, [], $additionalUrl));
    }
}
