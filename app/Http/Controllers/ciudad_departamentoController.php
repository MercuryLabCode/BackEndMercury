<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ciudad_departamento;
use App\ciudades;
use Illuminate\Support\Facades\DB;

class ciudad_departamentoController extends Controller
{


    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['filtroCiudad']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data =ciudad_departamento::orderBy('nombre','ASC')->get();

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

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


    public function filtroDepartamento()
    {
        $data = DB::select(

        ' SELECT DISTINCT t_ciudades_colombia.Departamento, t_ciudades_colombia.Codigo_DANE_Departamento FROM t_ciudades_colombia'

        );

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
       
    }


    public function filtroMunicipio($codigo)
    {

                $data = DB::select(

        ' SELECT DISTINCT t_ciudades_colombia.Municipio, t_ciudades_colombia.Codigo_Dane_Ciudad FROM t_ciudades_colombia 
         WHERE Codigo_DANE_Departamento = ? ',
        [$codigo]

        );

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
       
    }


    public function filtroCiudad($id){

        $data = ciudades::where('departamento_id',$id)->orderBy('nombre','ASC')->get();


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);


    }




}
