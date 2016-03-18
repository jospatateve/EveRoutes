<?php

namespace App\EveOnline;

/*
 * [
 *     "standings" => [
 *         "href" => "https://crest-tq.eveonline.com/standings/{id}/"
 *     ],
 *     "bloodLine" => [
 *         "href" => "https://crest-tq.eveonline.com/bloodlines/{bloodline_id}/",
 *         "id" => {bloodline_id},
 *         "id_str" => "{bloodline_id}"
 *     ],
 *     "gender_str" => "{0|1}",
 *     "waypoints" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/navigation/waypoints/"
 *     ],
 *     "private" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/private/"
 *     ],
 *     "channels" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/chat/channels/"
 *     ],
 *     "href" => "https://crest-tq.eveonline.com/characters/{id}/",
 *     "accounts" => [
 *         "href" => "https://crest-tq.eveonline.com/accounts/{id}/"
 *     ],
 *     "portrait" => [
 *         "32x32" => [
 *             "href" => "http://imageserver.eveonline.com/Character/{id}_32.jpg"
 *         ],
 *         "64x64" => [
 *             "href" => "http://imageserver.eveonline.com/Character/{id}_64.jpg"
 *         ],
 *         "128x128" => [
 *             "href" => "http://imageserver.eveonline.com/Character/{id}_128.jpg"
 *         ],
 *         "256x256" => [
 *             "href" => "http://imageserver.eveonline.com/Character/{id}_265.jpg"
 *         ]
 *     ],
 *     "id" => {id},
 *     "blocked" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/blocked/"
 *     ],
 *     "fittings" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/fittings/"
 *     ],
 *     "contacts" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/contacts/"
 *     ],
 *     "corporation" => [
 *         "name" => "{corporation_name}",
 *         "isNPC" => {true|false},
 *         "href" => "https://crest-tq.eveonline.com/corporations/{corporation_id}/",
 *         "id_str" => "{corporation_id}",
 *         "logo" => [
 *             "32x32" => [
 *                 "href" => "http://imageserver.eveonline.com/Corporation/{corporation_id}_32.png"
 *             ],
 *             "64x64" => [
 *                 "href" => "http://imageserver.eveonline.com/Corporation/{corporation_id}_64.png"
 *             ],
 *             "128x128" => [
 *                 "href" => "http://imageserver.eveonline.com/Corporation/{corporation_id}_128.png"
 *             ],
 *             "256x256" => [
 *                 "href" => "http://imageserver.eveonline.com/Corporation/{corporation_id}_256.png"
 *             ],
 *         ],
 *         "id" => {corporation_id}
 *     ],
 *     "location" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/location/"
 *     ],
 *     "mail" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/mail/"
 *     ],
 *     "capsuleer" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/capsuleer/"
 *     ],
 *     "vivox" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/vivox/"
 *     ],
 *     "description" => "{description}",
 *     "notifications" => [
 *         "href" => "https://crest-tq.eveonline.com/characters/{id}/notifications/"
 *     ],
 *     "id_str" => "{id}",
 *     "name" => "{name}",
 *     "gender" => {0|1},
 *     "race" => [
 *         "href" => "https://crest-tq.eveonline.com/races/{race_id}/",
 *         "id" => {race_id},
 *         "id_str" => "{race_id}"
 *     ],
 *     "deposit" => [
 *         "href" => "https://crest-tq.eveonline.com/accounts/{id}/10000/"
 *     ]
 * ]
 *
 */

class EveUser extends EveCRESTResponse
{
    public function getId()
    {
        return $this->get('id');
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function getGender()
    {
        return $this->get('gender') ? 'male' : 'female';
    }

    public function getCorporation()
    {
        return $this->get('corporation')['name'];
    }

    public function getCorporationId()
    {
        return $this->get('corporation')['id'];
    }

    public function getPortrait()
    {
        return $this->get('portrait')['128x128']['href'];
    }

    public function getCorporationLogo()
    {
        return $this->get('corporation')['logo']['128x128']['href'];
    }
}
