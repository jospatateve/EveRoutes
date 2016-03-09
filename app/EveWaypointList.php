<?php

namespace App;

class EveWaypointList
{
    private $waypoints;

    public static function fromArray(array $waypoints)
    {
        $waypointlist = new EveWaypointList;
        $waypointlist->waypoints = $waypoints;
        return $waypointlist;
    }

    public static function fromString($idstring)
    {
        $waypoints = [];

        $idsraw = explode(';', $idstring);
        $ids = array_filter($idsraw, 'strlen');
        foreach ($ids as $id) {
            $system = EveSystem::where('system_id', '=', $id)->first();
            $waypoints[] = $system->name;
        }

        $waypointlist = new EveWaypointList;
        $waypointlist->waypoints = $waypoints;
        return $waypointlist;
    }

    public function toArray()
    {
        return $this->waypoints;
    }
 
    public function toString()
    {
        $waypointsstring = '';

        foreach ($this->waypoints as $waypoint) {
            $system = EveSystem::where('name', '=', $waypoint)->first();
            if ($system) {
                $waypointsstring .= $system->system_id . ';';
            }
        }

        return $waypointsstring;
    }
}
