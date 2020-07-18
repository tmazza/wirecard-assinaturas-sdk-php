<?php

namespace WirecardSubscription;

use WirecardSubscription\Resources\Customers;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Resources\Subscriptions;
use WirecardSubscription\Resources\Webhooks;

class WirecardApi
{
    protected $requester;
    protected $resources = [];

    public function __construct($env = null, $token = null, $key = null)
    {
        $this->requester = new Requester($env, $token, $key);
    }

    public function __get(string $attribute)
    {
        $resources = $this->resources();
        if (isset($resources[$attribute])) {
            return $this->resource($attribute, $resources[$attribute]);
        }

        return $this->{$attribute};
    }

    /**
     * Mapeamento entre recursos e classes correspondentes.
     */
    private function resources()
    {
        return [
            'customers' => Customers::class,
            'plans' => Plans::class,
            'subscriptions' => Subscriptions::class,
            'webhooks' => Webhooks::class
        ];
    }

    /**
     * Inicializa recurso ou reutiliza recurso já criado.
     */
    private function resource($name, $class)
    {
        return $this->resources[$name] ?? $this->resources[$name] = new $class($this->requester);
    }

    /**
     * Última requisição realizada.
     */
    public function response()
    {
        return $this->requester->lastResponse();
    }
}
