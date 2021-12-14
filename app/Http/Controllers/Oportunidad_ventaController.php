<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad_venta;
use App\Clientes;
use App\Inmueble;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

class Oportunidad_ventaController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['mostrarInformacion']]);
    }
    public function index()
    {


        $data = Oportunidad_venta::all()->load('Cliente_ID', 'Unidad_ID');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'  => $data

        ]);
    }

    public function show($id)
    {
        // ->load('cliente_id', 'inmueble_id', 'estado_id')
        $data = Oportunidad_venta::find($id);



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

    public function store(Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);


        if (!empty($params_array)) {


            $validate = \Validator::make($params_array, [

                'Cliente_ID'                =>  'required',
                'Unidad_ID'                 =>  'required',
                'Cantidad_Op_Compra'        =>  'required',
                'Precio_Op_Compra'          =>  'required',
                'Expectativa_Fecha_Compra'  =>  'required',
                'Estado_Op'                 =>  'required',
                'User_ID'                   =>  'required'




            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Se ha presentado un error en los datos.',
                    'error' =>   $validate->errors()

                ];
            } else {

              
                $timestamp = time();
                $ldate = date('d-m-Y');
                $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $fecha = Carbon::parse($date);
                $mfecha = $fecha->month;
                $dfecha = $fecha->day;
                $afecha = $fecha->year;
                $dia=substr($ldate, 0,2);
                $anno=substr($afecha, 2);
                $id = IdGenerator::generate(['table' => 't_oportunidad_venta', 'field' => 'Op_Venta_ID', 'length' => 5, 'prefix' => "0"]);
            
              
                $reference =  $id.'-'.  $dia. $mfecha  . $anno;








                $dt = new Oportunidad_venta();

                $dt->Op_Venta_ID              = $reference;
                $dt->Cliente_ID               = $params_array['Cliente_ID'];
                $dt->Unidad_ID                = $params_array['Unidad_ID'];
                $dt->Cantidad_Op_Compra       = $params_array['Cantidad_Op_Compra'];
                $dt->Precio_Op_Compra         = $params_array['Precio_Op_Compra'];
                $dt->Expectativa_Fecha_Compra = $params_array['Expectativa_Fecha_Compra'];
                $dt->Descr_Op_Venta           = $params_array['Descr_Op_Venta'];
                $dt->Estado_Op                = $params_array['Estado_Op'];
                $dt->User_ID                  = $params_array['User_ID'];
                $dt->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha registrado con Exito la oportunidad de venta',
                    'dato' => $dt

                ];
            }
        } else {

            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Se ha presentado un error con los datos.',
                'data' => $params_array
            );
        }


        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'Cliente_ID'                =>  'required',
                'Proyect_Name'              =>  'required',
                'Cantidad_Op_Compra'        =>  'required',
                'Precio_Op_Compra'          =>  'required',
                'Expectativa_Fecha_Compra'  =>  'required',
                'Estado_Op'                 =>  'required',
                'User_ID'                   =>  'required'


            ]);
            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Se ha presentado un error en los datos.',
                    'post' => $validate->errors()
                ];
                return response()->json($data, $data['code']);
            }
            unset($params_array['Op_Venta_ID']);

            unset($params_array['User_ID']);


            $dt = Oportunidad_Venta::where('Op_Venta_ID', $id);


            if (!empty($dt) && is_object($dt)) {

                $dt->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Se ha realizado con exito la acutalización de los datos',
                    'data' => $dt,
                    'changes' => $params_array
                ];
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'data' => $params_array
                ];
            }
        }
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {
        $dt = Oportunidad_venta::find($id);

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

    public function FiltroDisponibles(Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);


        $data = Inmueble::where('Estado_Unidad', $params_array['peticion'])->get();


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }



    /**
     * Mostrar los datos de una oportunidad de venta
     */

    public function mostrarInformacion(Request $request)
    {
      
     
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
       
        $inmueble = Inmueble::where('id_unidad',  $params_array['Unidad_ID'])->get();
        $cliente = Clientes::where('Cliente_ID',  $params_array['Cliente_ID'])->get();

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'inmueble'  => $inmueble,
            'cliente'   => $cliente,

        ]);
    }
}
