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
    public function getTimePlayed()
    {
        $seconds = $this->get('characterMinutes') * 60;
        $dtF = new \DateTime("@0");
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT);
    }

    public function getTimesLoggedOn()
    {
        return $this->get('characterSessionsStarted');
    }

    public function getDamageTaken()
    {
        return $this->get('combatDamageFromNPCsAmount')
            + $this->get('combatDamageFromPlayersBombAmount')
            + $this->get('combatDamageFromPlayersCombatDroneAmount')
            + $this->get('combatDamageFromPlayersEnergyAmount')
            + $this->get('combatDamageFromPlayersFighterBomberAmount')
            + $this->get('combatDamageFromPlayersFighterDroneAmount')
            + $this->get('combatDamageFromPlayersHybridAmount')
            + $this->get('combatDamageFromPlayersMissileAmount')
            + $this->get('combatDamageFromPlayersProjectileAmount')
            + $this->get('combatDamageFromPlayersSmartBombAmount')
            + $this->get('combatDamageFromPlayersSuperAmount')
            + $this->get('combatDamageFromStructuresTotalAmount');
    }

    public function getDamageDealt()
    {
        return $this->get('combatDamageToPlayersBombAmount')
            + $this->get('combatDamageToPlayersCombatDroneAmount')
            + $this->get('combatDamageToPlayersEnergyAmount')
            + $this->get('combatDamageToPlayersFighterBomberAmount')
            + $this->get('combatDamageToPlayersFighterDroneAmount')
            + $this->get('combatDamageToPlayersHybridAmount')
            + $this->get('combatDamageToPlayersMissileAmount')
            + $this->get('combatDamageToPlayersProjectileAmount')
            + $this->get('combatDamageToPlayersSmartBombAmount')
            + $this->get('combatDamageToPlayersSuperAmount')
            + $this->get('combatDamageToStructuresTotalAmount');
    }

    public function getNumberOfLosses()
    {
        return $this->get('combatDeathsHighSec')
            + $this->get('combatDeathsLowSec')
            + $this->get('combatDeathsNullSec')
            + $this->get('combatDeathsWormhole')
            + $this->get('combatDeathsPodHighSec')
            + $this->get('combatDeathsPodLowSec')
            + $this->get('combatDeathsPodNullSec')
            + $this->get('combatDeathsPodWormhole');
    }

    public function getNumberOfKills()
    {
        return $this->get('combatKillsAssists')
            + $this->get('combatKillsHighSec')
            + $this->get('combatKillsLowSec')
            + $this->get('combatKillsNullSec')
            + $this->get('combatKillsWormhole')
            + $this->get('combatKillsPodHighSec')
            + $this->get('combatKillsPodLowSec')
            + $this->get('combatKillsPodNullSec')
            + $this->get('combatKillsPodWormhole');
    }

    public function getNumberOfJumps()
    {
        return $this->get('travelJumpsWormhole')
            + $this->get('travelJumpsStargateHighSec')
            + $this->get('travelJumpsStargateLowSec')
            + $this->get('travelJumpsStargateNullSec');
    }

    public function getNumberOfWarps()
    {
        return $this->get('travelWarpsWormhole')
            + $this->get('travelWarpsHighSec')
            + $this->get('travelWarpsLowSec')
            + $this->get('travelWarpsNullSec')
            + $this->get('travelWarpsToBookmark')
            + $this->get('travelWarpsToCelestial')
            + $this->get('travelWarpsToFleetMember')
            + $this->get('travelWarpsToScanResult');
    }

    public function getDistanceTraveled()
    {
        return $this->get('travelDistanceWarpedWormhole')
            + $this->get('travelDistanceWarpedHighSec')
            + $this->get('travelDistanceWarpedLowSec')
            + $this->get('travelDistanceWarpedNullSec');
    }

    public function getNumberOfCansHacked()
    {
        return $this->get('industryHackingSuccesses');
    }

    public function getNumberOfHackingAttempts()
    {
        return $this->get('moduleActivationsDataMiners');
    }

    public function getHackingSuccessRate()
    {
        $successes = $this->getNumberOfCansHacked();
        $attempts = $this->getNumberOfHackingAttempts();
        $rate = $attempts > 0 ? $successes / $attempts : 1;
        return $rate;
    }

    public function getNumberOfCloakActivations()
    {
        return $this->get('moduleActivationsCloakingDevice');
    }
}
