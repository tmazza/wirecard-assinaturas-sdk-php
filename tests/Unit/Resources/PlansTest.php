<?php

namespace WirecardSubscription\Tests\Unit\Resources;

use WirecardSubscription\Requester;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Response;
use WirecardSubscription\Tests\Unit\ResourceTest;

class PlansTest extends ResourceTest
{
    protected function setUp(): void
    {
        $this->endpoint = 'plans';
        $this->requester = $this->createMock(Requester::class);
        $this->resource = new Plans($this->requester);
    }

    public function test_activate_should_set_status_activate()
    {
        $code = 'code';

        $this->requester
            ->method('send')
            ->willReturn($this->createMock(Response::class));

        $expectedBody = ['json' => []];

        $this->requester
            ->expects($this->exactly(3))
            ->method('send')
            ->withConsecutive(
                ['GET', $this->endpoint . '/' . $code],
                ['PUT', $this->endpoint . '/' . $code . '/activate', $expectedBody],
                ['GET', $this->endpoint . '/' . $code]
            );
        
        $this->resource->activate($code);
    }

    public function test_inactivate_should_set_status_inactivate()
    {
        $code = 'code';

        $this->requester
            ->method('send')
            ->willReturn($this->createMock(Response::class));

        $expectedBody = ['json' => []];
 
        $this->requester
            ->expects($this->atLeastOnce())
            ->method('send')
            ->withConsecutive(
                ['GET', $this->endpoint . '/' . $code],
                ['PUT', $this->endpoint . '/' . $code . '/inactivate', $expectedBody],
                ['GET', $this->endpoint . '/' . $code]
            );
        
        $this->resource->inactivate($code);
    }
}
