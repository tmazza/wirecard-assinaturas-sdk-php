<?php

namespace WirecardSubscription;

class Response
{
    private $data = [];

    public function __construct($status, $data)
    {
        $this->status = $status;
        $this->data = $data;
    }

    public function getObject()
    {
        return $this->data;
    }

    public function getList()
    {
        return current($this->data) ?? [];
    }

    public function isOk()
    {
        return $this->status === 200;
    }

    public function isSuccessful()
    {
        return $this->status >= 200 && $this->status < 300;
    }

    public function isNotFound()
    {
        return $this->status === 404;
    }
}
