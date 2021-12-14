<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use Validator;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['']]);
    }



    public function index()
    {
        $data = Clientes::get()->load('Tipo_Documento_Cli');
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data
        ]);
    }


    public function show($id)
    {
        $data = Clientes::find($id)->load('Tipo_Documento_Cli');
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

                'Client_Name'            => 'required',
                'Tipo_Documento_Cli'     => 'required',
                'No_Documento_Cli'       => 'required',
                'Fecha_Nacimiento_Cli'   => 'required',
                'Nivel_Estudios'         => 'required',
                'Celular_Cli'            => 'required',
                'Telefono_Cli'           => 'required',
                'Email_Cli'              => 'required',
               
                'User_ID'               =>  'required',


            ]);
            if ($validate->fails()) {

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'No se ha podido guardar el nuevo cliente',
                    'error'     => $validate->errors()

                ];

                return response()->json($data, $data['code']);
            } else {

                $dt = new  Clientes();
               
           
               
                $timestamp = time();
                $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $fecha = Carbon::parse($date);
                $mfecha = $fecha->month;
                $dfecha = $fecha->day;
                $afecha = $fecha->year;


            $id = IdGenerator::generate(['table' => 't_clientes','field'=>'Cliente_ID', 'length' => 5,'prefix' =>'0']);
               
                $ldate = date('d-m-Y');
              $dia=substr($ldate, 0,2);
            $anno=substr($afecha, 2);
            
              $reference =  $id.'-'.  $dia. $mfecha  . $anno;
            
                   
               
     
              
              
                $dt->Cliente_ID             =$reference;
                $dt->Client_Name            = $params_array['Client_Name'];
                $dt->Tipo_Documento_Cli     = $params_array['Tipo_Documento_Cli'];
                $dt->No_Documento_Cli       = $params_array['No_Documento_Cli'];
                $dt->Fecha_Nacimiento_Cli   = $params_array['Fecha_Nacimiento_Cli'];
                $dt->Nivel_Estudios         = $params_array['Nivel_Estudios'];
                $dt->Profesion_Cli          = $params_array['Profesion_Cli'];
                $dt->Celular_Cli            = $params_array['Celular_Cli'];
                $dt->Telefono_Cli           = $params_array['Telefono_Cli'];
                $dt->Email_Cli              = $params_array['Email_Cli'];
                
                $dt->User_ID                = $params_array['User_ID'];

                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente el cliente',
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

    public function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                 'Client_Name'            => 'required',
                'Tipo_Documento_Cli'     => 'required',
                'No_Documento_Cli'       => 'required',
                'Fecha_Nacimiento_Cli'   => 'required',
                'Nivel_Estudios'         => 'required',
                'Celular_Cli'            => 'required',
                'Telefono_Cli'           => 'required',
                'Email_Cli'              => 'required',
               
                'User_ID'               =>  'required'
            ]);
            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status'  => 'error',
                    'mensaje' => 'Se ha encontrado un error.',
                    'error'   => $validate->errors()
                ];
            } else {

                unset($params_array['Cliente_ID']);
                unset($params_array['User_ID']);
                unset($params_array['Created_Date']);

                $dt = Clientes::where('Cliente_ID', $id)->update($params_array);

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con exito.',
                    'changes'   => $params_array

                ];
            }

            return response()->json($data, $data['code']);
        }
    }

    public function destroy($id, Request $request)
    {
    
        $dt = Clientes::find($id);
        
              
        
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
}
