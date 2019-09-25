<?php

namespace App\Http\Controllers;

use App\Models\Domain\Roadwork;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RoadworksController extends Controller
{
    public function refresh(Request $request){
        $executionStartTime = microtime(true);

        $gc = new Client();
        $roadworks = json_decode($gc->get('http://www.trafficengland.com/api/events/getToBounds?bbox=-90,-90,180,180&events=ROADWORKS')->getBody()->getContents());

        foreach (Roadwork::all() as $roadwork){
            $roadwork->delete();
        }

        foreach ($roadworks as $roadwork){
            $cause = $roadwork->cause;
            if ($roadwork->cause == ''){
                $cause = $roadwork->gdp;
                if ($roadwork->gdp == ''){
                    $cause = $roadwork->awp;
                }
            }

            Roadwork::create([
                'eid' => $roadwork->id,
                'teEventType' => $roadwork->teEventType,
                'cause' => $cause,
                'long' => $roadwork->longitude,
                'lat' => $roadwork->latitude,
                'roadName' => $roadwork->roadName,
                'overallStartDate' => $roadwork->overallStartDate,
                'overallEndDate' => $roadwork->overallEndDate
            ]);
        }

        $executionEndTime = microtime(true);
        $executionTime = $executionEndTime-$executionStartTime;
        return Response()->json([
            'status' => 'Success',
            'description' => 'Successfully Updated Roadworks Dataset',
            'took' => "$executionTime seconds"]);

    }

}
