@extends('layouts.scaffold')

@section('page_actions_left')

@endsection

@section('page_actions_right')

@endsection

@section('title')
Route Planner
@endsection

@section('description')
Check your route for delays or diversions.
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body" style='width: 1400px; height: 600px;' id="map">
                                <script>
                                    function distance(geo1, geo2) {
                                        let lon1 = geo1[0];
                                        let lat1 = geo1[1];
                                        let lon2 = geo2[0];
                                        let lat2 = geo2[1];
                                        var p = 0.017453292519943295;    // Math.PI / 180
                                        var c = Math.cos;
                                        var a = 0.5 - c((lat2 - lat1) * p)/2 +
                                            c(lat1 * p) * c(lat2 * p) *
                                            (1 - c((lon2 - lon1) * p))/2;

                                        return 12742 * Math.asin(Math.sqrt(a)); // 2 * R; R = 6371 km
                                    }
                                </script>
                                <script>
                                    let geoRoadworks = {!! $geoRoadworks !!};
                                    mapboxgl.accessToken = 'pk.eyJ1IjoibHVrZXIxMDIiLCJhIjoiY2pzdWk1bzIyMTFlcTQ5cXprNTRpdXhxOCJ9.EXQoJrpCWj3uzKKF8_qtmA';
                                    var map = new mapboxgl.Map({
                                        container: 'map',
                                        style: 'mapbox://styles/mapbox/streets-v9'
                                    });

                                    map.addControl(new MapboxDirections({
                                        accessToken: mapboxgl.accessToken,
                                        profile: 'mapbox/driving',
                                        alternatives: false,
                                        interactive: false,
                                        controls: {
                                            profileSwitcher: false
                                        }
                                    }), 'top-right');


                                    map.on('load', function () {
                                        map.addLayer({
                                            'id': 'map',
                                            'type': 'circle',
                                            'source': {
                                                type: 'geojson',
                                                data: {
                                                    "type": "FeatureCollection",
                                                    "features": {!! $features !!}
                                                }
                                            },
                                            'paint': {
                                                'circle-radius': {
                                                    'base': 1.75,
                                                    'stops': [[12, 5], [22, 180]]
                                                },
                                                'circle-color': '#FF0000',
                                                'circle-opacity': 0.5
                                            }
                                        });

                                        map.on('click', 'map', function (e) {
                                            let coordinates = e.features[0].geometry.coordinates.slice();
                                            let description = e.features[0].properties.description;
                                            let title = e.features[0].properties.title;
                                            let id = e.features[0].properties.id;

                                            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                                            }

                                            new mapboxgl.Popup()
                                                .setLngLat(coordinates)
                                                .setHTML('<b>' + title + '</b><br>' + description + '<br><i> ' + coordinates + '</i><br><a href="http://www.trafficengland.com/api/events/getEventById?evtId='+ id +'">Debug</a>')
                                                .addTo(map);
                                        });

                                        map.on('mouseenter', 'map', function () {
                                            map.getCanvas().style.cursor = 'pointer';
                                        });

                                        map.on('mouseleave', 'map', function () {
                                            map.getCanvas().style.cursor = '';
                                        });

                                        map._controls[2].on('route', async function(plannedRouteGeom) {
                                            $('#roadworksTimeline').empty();
                                            let geom = plannedRouteGeom['route'][0].geometry;
                                            let geoArray = polyline.decode(geom);
                                            let roadworksOnJourney = [];
                                            geoArray.forEach(function(routingGeoPoint) {
                                                geoRoadworks.forEach(function (roadworkGeoPoint){
                                                    let distanceBetweenTwoPoints = distance(routingGeoPoint, [roadworkGeoPoint[1], roadworkGeoPoint[0]]);
                                                        if (distanceBetweenTwoPoints < 0.025){ // 1 Kilometer from Point
                                                            roadworksOnJourney.push(roadworkGeoPoint[2])
                                                        }
                                                    });
                                                });
                                            let uniqueRoadworks = (Array.from(new Set(roadworksOnJourney)));
                                            if (uniqueRoadworks.length === 0){
                                                $('#roadworksTimeline').append('<div class="kt-timeline-v2__item">' +
                                                    '<div class="text-muted text-center">No Roadworks on Selected Journey</div>' +
                                                    '</div>'
                                                )
                                            } else {
                                                uniqueRoadworks.forEach(roadwork => {
                                                    $.get('http://127.0.0.1:8000/roadwork/' + roadwork).then(response => {
                                                        $('#roadworksTimeline').append(
                                                            '<div class="kt-timeline-v2__item">' +
                                                            '                                                        <span class="kt-timeline-v2__item-time">' + response.roadName + '</span>' +
                                                            '                                                        <div class="kt-timeline-v2__item-cricle">' +
                                                            '                                                            <i class="fa fa-genderless kt-font-brand"></i>' +
                                                            '                                                        </div>' +
                                                            '                                                        <div class="kt-timeline-v2__item-text kt-padding-top-5">' + response.cause + '<br><a href="http://www.trafficengland.com/api/events/getEventById?evtId='+ response.eid +'">More Info.</a>' +
                                                            '                                                        </div>' +
                                                            '                                                    </div>'
                                                        )
                                                    });
                                                })
                                            }

                                            // let longLatsOfAllRoadworksOnJourney = [];
                                            //
                                            // map.getSource('map').setData({
                                            //     'features': [],
                                            //     'type': 'FeatureCollection'
                                            // })
                                            //
                                            // uniqueRoadworks.forEach(roadwork => {
                                            //     $.get('http://127.0.0.1:8000/roadwork/' + roadwork).then(roadwork => {
                                            //         longLatsOfAllRoadworksOnJourney.push({
                                            //             'type': 'Feature',
                                            //             'geometry': {
                                            //                 'type': 'Point',
                                            //                 'coordinates': [
                                            //                     roadwork.long,
                                            //                     roadwork.lat
                                            //                 ]
                                            //             },
                                            //             'properties': {
                                            //                 'id': roadwork.eid,
                                            //                 'title': roadwork.teEventType,
                                            //                 'description': roadwork.cause,
                                            //                 'roadname': roadwork.roadname
                                            //             }
                                            //         });
                                            //     })
                                            // });
                                            //
                                            // map.getSource('map').setData({
                                            //     type: 'geojson',
                                            //     data: {
                                            //         "type": "FeatureCollection",
                                            //         "features": longLatsOfAllRoadworksOnJourney
                                            //     }});

                                            $('#roadworksPortlet').show();
                                            $([document.documentElement, document.body]).animate({
                                                scrollTop: $("#roadworksTimeline").offset().top
                                            }, 2000);
                                        });
                                    })
                                </script>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <!--Begin::Portlet-->
                                <div class="kt-portlet kt-portlet--height-fluid" id="roadworksPortlet" >
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                Roadworks on Planned Route
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="380" data-mobile-height="300" style="height: 380px; overflow: hidden;">
                                            <!--Begin::Timeline 3 -->
                                            <div class="kt-timeline-v2">
                                                <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30" id="roadworksTimeline">

                                               </div>
                                            </div>
                                            <!--End::Timeline 3 -->
                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 380px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 300px;"></div></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#roadworksPortlet').hide();
    </script>
@endsection

