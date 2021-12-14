<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tInmueble;

class tInmuebleController extends Controller
{
public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = tInmueble::all();
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data

        ]);
    }
}
