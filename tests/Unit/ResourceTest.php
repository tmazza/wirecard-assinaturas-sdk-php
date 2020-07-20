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

    protected function tearDown(): void
    {
        $this->resource = null;
    }

    public function testEndpointShouldBe()
    {
        $this->assertSame($this->resource->endpoint(), $this->endpoint);
    }
    
    public function testAllShouldCallSendOnceWithGet()
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
    
    public function testGetShouldCallSendOnceWithGet()
    {
        $code = 'code';
        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('GET', $this->endpoint . '/' . $code)
             ->willReturn($this->createMock(Response::class));

        $this->assertSame(null, $this->resource->get($code));
    }

    public function testCreateShouldCallSendOnceWithPost()
    {
        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('POST', $this->endpoint)
             ->willReturn($this->createMock(Response::class));

        $this->assertSame(null, $this->resource->create([]));
    }

    public function testCreateShouldCallResponseGetObject()
    {
        $response = $this->createMock(Response::class);
        $response->method('getObject')->willReturn(null);

        $this->requester
             ->method('send')
             ->willReturn($response);

        $this->assertSame(null, $this->resource->create([]));
    }

    public function testCreateShouldRetrieveResource()
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

    public function testUpdateShouldAcceptOnlyCode()
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

    public function testUpdateShouldCallPullWithJsonAttribute()
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

    public function testUpdateShouldUseAdditionalUrl()
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
