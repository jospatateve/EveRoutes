<?php

namespace App\ZKillboard;

class ZKillMailList extends ZKillAPIResponse
{
    public function isEmpty()
    {
        return empty($this->getJSON());
    }

    public function getCount()
    {
        return count($this->getJSON());
    }

    public function getKill($index)
    {
        return new ZKillMail($this->get($index));
    }
}
