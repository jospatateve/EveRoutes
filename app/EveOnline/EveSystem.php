<?php

namespace App\EveOnline;

/*
 * [
 *     "stats" => [
 *         "href" => "https://public-crest.eveonline.com/solarsystems/{id}/stats/"
 *     ],
 *     "name" => "{name}",
 *     "securityStatus" => {security_status},
 *     "securityClass" => "{security_class}",
 *     "href" => "https://public-crest.eveonline.com/solarsystems/{id}/",
 *     "id_str" => "{id}",
 *     "planets" => [
 *         ["href" => "https://public-crest.eveonline.com/planets/{planet_id}/"],
 *         ["href" => "https://public-crest.eveonline.com/planets/{planet_id}/"],
 *         ...
 *     ],
 *     "position" => [
 *         "y" => {y-coordinate},
 *         "x" => {x-coordinate},
 *         "z" => {z-coordinate}
 *     ],
 *     "sovereignty" => [
 *         "id_str" => "{alliance_id}",
 *         "href" => "https://public-crest.eveonline.com/alliances/{alliance_id}/",
 *         "id" => {alliance_id},
 *         "name"=> "{alliance_name}"
 *     ],
 *     "constellation" => [
 *         "href" => "https://public-crest.eveonline.com/constellations/{constellation_id}/",
 *         "id" => {constellation_id},
 *         "id_str" => "{constellation_id}"
 *     ],
 *     "id" => {id}
 * ]
 *
 */

class EveSystem extends EveCRESTResponse
{
	public function getId()
    {
        return $this->get('id');
    }

	public function getName()
    {
        return $this->get('name');
    }

	public function getSecurityStatus()
    {
        return $this->get('securityStatus');
    }

	public function getAlliance()
    {
        return $this->get('sovereignty')['name'];
    }

	public function getAllianceId()
    {
        return $this->get('sovereignty')['id'];
    }

	public function getConstellationId()
    {
        return $this->get('constellation')['id'];
    }

    public function isWH()
    {
        return preg_match('/^(j|J)[0-9]{6}$/', $this->getName()) === 1;
    }
}
