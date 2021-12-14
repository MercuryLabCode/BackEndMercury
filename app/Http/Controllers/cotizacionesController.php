<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cotizaciones;
use App\Clientes;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class cotizacionesController extends Controller
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
        $data = cotizaciones::all()->load('Cliente_ID');
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
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'Cliente_ID'        => 'required',
                'Op_Venta_ID'           => 'required',



            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {


                
                $dt = new cotizaciones();
                $id = IdGenerator::generate(['table' => 't_cotizaciones','field'=>'Cotizacion_id', 'length' => 9, 'prefix' => "Coti_"]);


                $dt->Cotizacion_id                  = $id;
                $dt->Cliente_ID                     = $params_array['Cliente_ID'];
                $dt->Op_Venta_ID                    = $params_array['Op_Venta_ID'];

                $dt->Unidad                         = $params_array['Unidad'];
                $dt->Valor_Total_Unidad             = $params_array['Valor_Total_Unidad'];
                $dt->Porcentaje_Valor_Descuento     = $params_array['Porcentaje_Valor_Descuento'];
                $dt->Valor_Descuento                = $params_array['Valor_Descuento'];
                $dt->Valor_Unidad_Final             = $params_array['Valor_Unidad_Final'];
                $dt->Valor_Congelacion              = $params_array['Valor_Congelacion'];
                $dt->Fecha_Congelacion              = $params_array['Fecha_Congelacion'];
                $dt->Valor_Cuota_Separacion         = $params_array['Valor_Cuota_Separacion'];
                $dt->Fecha_Cuota_Separacion         = $params_array['Fecha_Cuota_Separacion'];
                $dt->Cuota_Inicial                  = $params_array['Cuota_Inicial'];
                $dt->Valor_Cuota_Inicial_20         = $params_array['Valor_Cuota_Inicial_20'];
                $dt->Numero_Cuotas_20               = $params_array['Numero_Cuotas_20'];
                $dt->Tipo_Cuotas_20                 = $params_array['Tipo_Cuotas_20'];
                $dt->Valor_Cuota_20                 = $params_array['Valor_Cuota_20'];
                $dt->Valor_Cuota_70                 = $params_array['Valor_Cuota_70'];
                $dt->Estado_Cotizacion              = $params_array['Estado_Cotizacion'];
                $dt->Estado_Separacion              = $params_array['Estado_Separacion'];
                $dt->User_ID                        = $params_array['User_ID'];





                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente la cotización',
                    'data'      => $dt

                ];
            }
        } else {
            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'No has enviado ningún dato',


            ];
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
        $data =cotizaciones::where('Cotizacion_id',$id)->get();
        // $client = Clientes::find($data->Cliente_ID)->load('Tipo_Documento_Cli');

        if (is_object($data)) {

            $data = array(

                'code' => 200,
                'status' => 'success',
                'data' => $data
                

            );
        } else {

            $data = array(

                'code' => 400,
                'status' => 'error',
                'mensaje' => 'dato no existente'

            );
        }
        return response()->json($data, $data['code']);
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
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [



               
                'Op_Venta_ID'           => 'required',

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {

                unset($params_array['Client_ID']);
                unset($params_array['User_ID']);
                unset($params_array['Created_Date']);

                $dt = cotizaciones::where('Cotizacion_id', $id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con éxito.',
                    'changes'   => $params_array

                ];
            }
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = cotizaciones::find($id);
        if (!empty($dt)) {

            $dt->delete();

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha eliminado correctamente el dato.',
                'data'      => $dt

            ];
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No existe ese elemento'
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function filtroPago(Request $request)
    {   
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
       
        $dt = DB::select(

            'SELECT *  FROM t_pagos_cotizaciones',
            [$params_array["id"]]
            
        );
        $data = [
            'code' => 200,
            'status' => 'success',
            'data' => $dt
        ];

        return response()->json($data, $data['code']);
    }



}
