<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MateriaController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['']]);
    }


    public function index()
    {


        $producto = Materia::all()->load('Medida', 'Categoria','No_Documento_Prov', 'User_ID');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'producto'  => $producto

        ]);
    }




    /**Metodo que guarda un dato */

    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'Material_Name'  => 'required',
                'Marca'          => 'required',
                'Medida'         => 'required',
                'Categoria'      => 'required'
                

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar la Materia',
                    'error' =>   $validate->errors()

                ];
            } else {

                $timestamp = time();
                $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $fecha = Carbon::parse($date);
                $mfecha = $fecha->month;
                $dfecha = $fecha->day;
                $afecha = $fecha->year;





                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
                $reference = 'Us' . substr(str_shuffle($permitted_chars), 0, 4) . $mfecha . $dfecha . $afecha;

                $dt = new Materia();
                $dt->Codigo_ID           = $reference;
                $dt->Material_Name       = $params_array['Material_Name'];
                $dt->Cantidad_Material   = $params_array['Cantidad_Material'];
                $dt->Marca               = $params_array['Marca'];
                $dt->Medida              = $params_array['Medida'];
                $dt->Precio_Compra       = $params_array['Precio_Compra'];
                $dt->Categoria           = $params_array['Categoria'];
                $dt->No_Documento_Prov   = $params_array['No_Documento_Prov'];
                $dt->User_ID             = $params_array['User_ID'];

                $dt->save();


                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha guardado el dato!!!',
                    'dato' => $dt

                ];
            }
        } else {

            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados no son los correctos.',
                'data' => $params
            );
        }


        return response()->json($data, $data['code']);
    }

    public function show($id)
    {
        
        $producto = Materia::find($id)->load('No_Documento_Prov');

        if (is_object($producto)) {

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'producto'  => $producto
            ];
        } else {

            $data = [
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'el producto no existe'

            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * que permite editar un dato
     */
    public function update($id, Request $request)
    {

        //Recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            //Validar los datos
            $validate = \Validator::make($params_array, [
                'Material_Name'  => 'required',
                'Marca'          => 'required',
                'Medida'         => 'required',
                'Categoria'      => 'required'
            ]);
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $params_array
                ];
                return response()->json($data, $data['code']);
            }
            //Eliminar lo que no queremos actualizar
            unset($params_array['Codigo_ID']);
            unset($params_array['User_ID ']);
            unset($params_array['Created_Date']);




            $producto = Materia::where('Codigo_ID', $id);


            if (!empty($producto) && is_object($producto)) {

                $producto->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualizacion  Correctamente',
                    'post' => $producto,
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
     * Permite eliminar un dato
     */

    public function destroy($id, Request $request)
    {
        $producto = Materia::where('Codigo_ID', $id)->first();

        if (!empty($producto)) {
            $producto->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Dato eliminado correctamente'
            ];
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Hubo un error al eliminar un producto'
            ];
        }
        return response()->json($data, $data['code']);
    }


    //Metodo para generar los filtros para ordenes de compra


    public function filtroMaterial()
    {


        // $data = Materia::orderBy('proveedor_id','ASC')->havingRaw('count(proveedor_id) >= ?',[1])->get()->load('medida_id','categoria_id','proveedor_id');

        $data = Materia::groupBy('No_Documento_Prov')->havingRaw('count(No_Documento_Prov) >= ?', [1])->get()->load('Medida', 'Categoria', 'No_Documento_Prov');



        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }


    public function filtroMaterialNombre($id)
    {

        $data = Materia::WHERE('No_Documento_Prov', $id)->orderBy('Precio_Compra', 'ASC')->get()->load('Medida', 'Categoria', 'No_Documento_Prov');
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }

    public function filtroMaterialEconomico($nombre, $marca)
    {
        // $data = DB::select(

        // 'SELECT *,
        // min(A.precio_compra) AS precio_compra
        // FROM `materia` AS A
        // WHERE nombre = ? and marca = ?',
        // [$nombre, $marca]

        // );

        $data = Materia::where(['Material_Name' => $nombre, 'Marca' => $marca])->orderBy('Precio_Compra', 'asc')->first()->load('Medida', 'Categoria', 'No_Documento_Prov');

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data,


        ]);
    }
}
