<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tIdentificacion;

class tIdentificacionController extends Controller
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
        $data = tIdentificacion::all();
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data

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
        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); //array

        if(!empty($params) && !empty($params_array)){

            $params_array = array_map('trim', $params_array);

            $validate = \Validator::make($params_array, [

                'Nombre_Iden'      => 'required|unique:t_tipo_identificacion',
                'Descripcion_Iden'  => 'required|unique:t_tipo_identificacion',

            ]);

            if ($validate->fails()) {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'mensaje' => 'Datos erroneos, verificar los datos',
                    'error' => $validate->errors()
                );
            } else {
                $dt = new tIdentificacion();

                $dt ->Nombre_Iden   = $params_array['Nombre_Iden'];
                $dt ->Descripcion_Iden = $params_array['Descripcion_Iden'];
                

                $dt ->save();

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'se ha a creado correctamente el dato',
                    'data' =>  $dt 
                );
            }

        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados son incorrectos.',
            );
        }

        return response()->json($data, $data['code']);
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
