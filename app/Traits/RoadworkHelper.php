<?php


namespace App\Traits;


use App\Models\Domain\Roadwork;

trait RoadworkHelper
{
    public function getAllRoadworksBetween($startTime, $endTime){
        $roadworksBetween = [];
        $currentTime = round(microtime(true) * 1000);
        foreach (Roadwork::all() as $roadwork){
            if ($roadwork->overallStartDate < $currentTime && $roadwork->overallEndDate > $currentTime){
                array_push($roadworksBetween, $roadwork);
            }
        }
        return $roadworksBetween;
    }
}
