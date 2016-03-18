<?php

namespace App\EveOnline;

class EveCRESTResponse
{
    private $raw;

    function __construct($json)
    {
        $this->raw = $json;
    }

    protected function get($key)
    {
        if (!$this->has($key)) {
            throw new \Exception('invalid key');
        }
        return $this->raw[$key];
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->getJSON());
    }

    public function getJSON()
    {
        return $this->raw;
    }
}
