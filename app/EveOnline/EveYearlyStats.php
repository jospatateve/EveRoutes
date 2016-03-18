<?php

namespace App\EveOnline;

/*
 * [
 *     json format here
 * ]
 *
 */

class EveYearlyStats extends EveCRESTResponse
{
    public function getMinutesPlayed()
    {
        return $this->get('characterMinutes');
    }

    public function getTimesLoggedOn()
    {
        return $this->get('characterSessionsStarted');
    }
}
