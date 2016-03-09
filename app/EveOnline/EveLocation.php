<?php

namespace App\EveOnline;

/*
 * [
 *     "solarSystem" => [
 *         "id_str" => "{id}",
 *         "href" => "https://crest-tq.eveonline.com/solarsystems/{id}/",
 *         "id" => {id},
 *         "name" => {name}
 *     ]
 * ]
 *
 */

class EveLocation
{
    private $raw;

    function __construct(array $json_location = null)
    {
        $this->raw = $json_location;
    }

    public function isValid()
    {
        return isset($this->raw['solarSystem']);
    }

    public function getId()
    {
        return $this->raw['solarSystem']['id'];
    }

    public function getName()
    {
        return $this->raw['solarSystem']['name'];
    }
}
