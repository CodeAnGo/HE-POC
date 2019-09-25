<?php

namespace App\Http\Controllers;

use App\Models\Domain\Roadwork;
use App\Traits\RoadworkHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use RoadworkHelper;
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = [];
        $geoRoadworks = [];

        foreach ($this->getAllRoadworksBetween(microtime(true), microtime(true)+86400000) as $roadwork){
            array_push($features, [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $roadwork->long,
                        $roadwork->lat,
                    ]
                ],
                'properties' => [
                    'id' => $roadwork->eid,
                    'title' => $roadwork->teEventType,
                    'description' => $roadwork->cause,
                    'roadname' => $roadwork->roadName,
                ]
            ]);
            array_push($geoRoadworks, [$roadwork->long, $roadwork->lat, $roadwork->eid]);
        }

        return view('pages.dashboard.index', [
            'features' => json_encode($features),
            'geoRoadworks' => json_encode($geoRoadworks)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
