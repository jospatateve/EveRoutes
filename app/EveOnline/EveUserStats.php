<?php

namespace App\EveOnline;

/*
 * [
 *     "aggregateYears" => [
 *         {year} => [ {array of statistics key-value pairs} ]
 *     ]
 * ]
 *
 */

class EveUserStats extends EveCRESTResponse
{
    public function getYearlyStats()
    {
        return array_map(function($yearstats) {
            return new EveYearlyStats($yearstats);
        }, $this->get('aggregateYears'));
    }
}
