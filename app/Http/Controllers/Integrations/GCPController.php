<?php

namespace App\Http\Controllers\Integrations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GCPController extends Controller
{
    public function store(Request $request){
        dd($request->files);
    }
}
