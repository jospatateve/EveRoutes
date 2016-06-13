<?php

namespace App\ZKillboard;

class ZKillMail extends ZKillAPIResponse
{
    public function getID()
    {
        return $this->get('killID');
    }

    public function getUrl()
    {
        return 'https://zkillboard.com/kill/' . $this->getID() . '/';
    }

    public function getTime()
    {
        return $this->get('killTime');
    }

    public function getTimeDiff()
    {
        $then = new \DateTime($this->getTime(), new \DateTimeZone('UTC'));
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        return $now->getTimeStamp() - $then->getTimeStamp();
    }

    public function getTimeDiffFormatted()
    {
        $seconds = $this->getTimeDiff();

        $days = floor($seconds / (60*60*24));
        $hours = gmdate('H', $seconds);
        $minutes = gmdate('i', $seconds);

        return sprintf("%02dd %02dh %02dm", $days, $hours, $minutes);
    }

    public function getVictim()
    {
        return $this->get('victim')['characterName'];
    }

    public function getAttackers()
    {
        return array_map(function($attacker) {
            return $attacker['characterName'];
        }, $this->get('attackers'));
    }

    public function getFinalBlow()
    {
        return array_map(function($attacker) {
            return $attacker['characterName'];
        }, array_filter($this->get('attackers'), function($attacker) {
            return $attacker['finalBlow'] == 1;
        }))[0];
    }
}
