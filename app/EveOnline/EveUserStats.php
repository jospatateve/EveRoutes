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
    public function isValid()
    {
        return $this->has('aggregateYears');
    }

    public function getErrorMessage()
    {
        return $this->get('message');
    }

    public function getYearlyStats()
    {
        return array_map(function($yearstats) {
            return new EveYearlyStats($yearstats);
        }, $this->get('aggregateYears'));
    }
}
