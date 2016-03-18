<?php

namespace App\EveOnline;

/*
 * [
 *     "solarSystem" => [
 *         "id_str" => "{id}",
 *         "href" => "https://crest-tq.eveonline.com/solarsystems/{id}/",
 *         "id" => {id},
 *         "name" => "{name}"
 *     ]
 * ]
 *
 */

class EveLocation extends EveCRESTResponse
{
    public function isValid()
    {
        return $this->has('solarSystem');
    }

    public function getId()
    {
        return $this->get('solarSystem')['id'];
    }

    public function getName()
    {
        return $this->get('solarSystem')['name'];
    }
}
