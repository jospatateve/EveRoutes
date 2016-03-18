<?php

namespace App\EveOnline;

/*
 * [
 *     json format here
 * ]
 *
 */

class EveUserStats
{
    private $raw;

    function __construct(array $json_user)
    {
        $this->raw = $json_user;
    }

    public function getJSON()
    {
        return $this->raw;
    }
}
