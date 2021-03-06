<?php

namespace WirecardSubscription\Tests\Feature;

class PlansTest extends BaseTestCase
{
    public function testCreateShouldSavePlan()
    {
        $code = 'test_plan_' . time();
        
        $this->api->plans->create([
            'code' => $code,
            // sample code from wirecard documentation
            "name" => "Plano Especial",
            "description" => "Descrição do Plano Especial",
            "amount" => 990,
            "setup_fee" => 500,
            "max_qty" => 1,
            "interval" => [
              "length" => 1,
              "unit" => "MONTH"
            ],
            "billing_cycles" => 12,
            "trial" => [
              "days" => 30,
              "enabled" => true,
              "hold_setup_fee" => true
            ],
            "payment_method" => "CREDIT_CARD"
        ]);
        
        $plan = $this->api->plans->get($code);
        
        $this->assertNotNull($plan);
        $this->assertSame($plan->code, $code);
    }
}
