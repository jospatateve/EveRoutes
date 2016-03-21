<?php

namespace App\EveOnline;

class EveCRESTResponse
{
    private $raw;

    function __construct($json)
    {
        $this->raw = $json;
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \Exception("Invalid index: '$key'");
        }
        return $this->raw[$key];
    }

    public function has($key)
    {
        return array_key_exists($key, $this->getJSON());
    }

    public function getJSON()
    {
        return $this->raw;
    }
}
