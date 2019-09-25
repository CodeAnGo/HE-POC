<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('logout', function() { Auth::logout(); return redirect('/');});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function (){
    Route::resource('dashboard', 'DashboardController');
    Route::get('/refreshRoadworks', 'RoadworksController@refresh');
    Route::get('/roadwork/{eid}', function($eid){
       return \App\Models\Domain\Roadwork::where('eid', $eid)->first();
    });
});

