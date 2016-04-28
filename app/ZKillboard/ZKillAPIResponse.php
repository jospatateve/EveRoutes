<?php

namespace App\ZKillboard;

class ZKillAPIResponse
{
    private $raw;

    function __construct($json)
    {
        $this->raw = $json;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->getJSON());
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \Exception("Invalid index: '$key'");
        }
        return $this->getJSON()[$key];
    }

    protected function set($key, $value)
    {
        $this->raw[$key] = $value;
    }

    public function getJSON()
    {
        return $this->raw;
    }
}
