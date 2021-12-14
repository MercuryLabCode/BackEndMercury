<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fechaPagosCotizacion;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
class fechaPagosCotizacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['validacionPorcentaje','consultaEstados','generateReferencia']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = fechaPagosCotizacion::all();

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

                'Cotizacion_id'    =>  'required'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {

                $dt = new fechaPagosCotizacion();

          


                $dt->Pagos_Cot_id       = $params_array['reference'];
                $dt->Cotizacion_id      = $params_array['Cotizacion_id'];
                $dt->Numero_Cuota       = $params_array['Numero_Cuota'];
                $dt->Porcentaje_Pago    = $params_array['Porcentaje_Pago'];
                $dt->Item_Pago          = $params_array['Item_Pago'];
                $dt->Sub_Item_Pago      = $params_array['Sub_Item_Pago'];
                $dt->Descr_Item_Pago    = $params_array['Descr_Item_Pago'];
                $dt->Numero_Cuota_ID    = $params_array['Numero_Cuota_ID'];
                $dt->Valor_Cuota        = $params_array['Valor_Cuota'];
                $dt->Fecha_Cuota        = $params_array['Fecha_Cuota'];
                $dt->Valor_Pago_Cuota   = $params_array['Valor_Pago_Cuota'];
                
                $dt->Estado_Pagos_Cli   = $params_array['Estado_Pagos_Cli'];
                $dt->User_ID            = $params_array['User_ID'];





                $dt->User_ID        = $params_array['User_ID'];

                $dt->save();

                $data = [

                    'code'    => 200,
                    'status'  => 'success',
                    'mensaje' => 'Se ha guardado el dato!!',
                    'data'    => $params_array

                ];
            }
        } else {

            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados no son los correctos.',
                'data' => $params_array
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
        $data = fechaPagosCotizacion::find($id);
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
        $params_array  = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'Pagos_Cot_id'    =>  'required'

            ]);


            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $validate->errors()
                ];
                return response()->json($data, $data['code']);
            }

            unset($params_array['Pagos_Cot_id']);
            unset($params_array['Cotizacion_id']);

            unset($params_array['created_at']);

            $dt = fechaPagosCotizacion::where('Pagos_Cot_id', $id);

            if (!empty($dt) && is_object($dt)) {

                $dt->update($params_array);

                $data = [

                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualizaci¨®n  Correctamente',
                    'data' => $dt,
                    'changes' => $params_array

                ];
            } else {

                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $params_array
                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = fechaPagosCotizacion::find($id);

        if (!empty($dt)) {

            $dt->delete();
            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha eliminado el dato con exito',
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
    
    public function validacionPorcentaje($text){
        
         $dt = DB::select(
        'SELECT `Porcentaje_Equivalente` 
        FROM `t_catalogo_porcentajes`
        WHERE `Item`=?',
        [$text]);
        
         $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'resultado de la consulta',
                'data'      => $dt

            ];
            
         return response()->json($data, $data['code']);
            
    }
    
    public function consultaEstados(){
        
        $dt = DB::select(
            
            '
                SELECT  * FROM t_estado_pagos
            '        
            );
            
             $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'resultado de la consulta',
                'data'      => $dt

            ];
            
         return response()->json($data, $data['code']);
        
    }
    
    
    public function generateReferencia(){
              $timestamp = time();
                $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $fecha = Carbon::parse($date);
                $mfecha = $fecha->month;
                $dfecha = $fecha->day;
                $afecha = $fecha->year;


                $id = IdGenerator::generate(['table' => 't_pagos_cotizaciones', 'field' => 'Pagos_Cot_id', 'length' => 5, 'prefix' => '0']);

                $ldate = date('d-m-Y');
                $dia = substr($ldate, 0, 2);
                $anno = substr($afecha, 2);

                $reference =  $id . '-' .  $dia . $mfecha  . $anno;
                
                 $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'resultado de la consulta',
                'data'      => $reference 

            ];
            
         return response()->json($data, $data['code']);
    }
    
}
