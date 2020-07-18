<?php

namespace WirecardSubscription;

abstract class Resource
{
    protected $endpointAdditional;
    protected $requester;

    abstract public function endpoint(): string;

    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

    public function all(): array
    {
        return $this->requester
            ->send('GET', $this->getUrl())
            ->getList();
    }

    public function get($code)
    {
        return $this->requester
            ->send('GET', $this->getUrl($code))
            ->getObject();
    }

    public function create(array $body = [])
    {
        $response = $this->requester
            ->send('POST', $this->getUrl(), ['json' => $body]);

        return isset($body['code'])
            ? $this->get($body['code'])
            : $response->getObject();
    }

    public function update($code, array $body = [], $additionalUrl = false)
    {
        $this->requester
            ->send('PUT', $this->getUrl($code, $additionalUrl), [
                // send all body params even if only some changed
                // wirecard API validations requirements
                'json' => array_merge((array) $this->get($code), $body)
            ]);

        return $this->get($code);
    }

    public function withQuery($key, $value)
    {
        $this->withQuerys([$key => $value]);

        return $this;
    }

    public function withQuerys(array $querys)
    {
        $this->requester->addQuerys($querys);

        return $this;
    }

    protected function getUrl($code = null, $additional = false)
    {
        return implode('/', array_filter([
            $this->endpoint(),
            $code,
            $additional,
        ]));
    }
}
