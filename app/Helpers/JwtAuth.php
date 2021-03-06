<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;


class JwtAuth
{
   
    public $key;

    public function __construct()
    {
        $this->key = "Me'r'cu!@&oFt¡";
    }

    public function signUp($User_Email, $User_Contrasena, $getToken = null)
    {
       
        //Buscar si existe el usuario con sus credenciales Email y password
        $user = User::where([
            'User_Email' => $User_Email,
            'User_Contrasena' => $User_Contrasena
        ])->first();
        
        
        //Generar el token con los datos del usuario identificado
        if (is_object($user)) {
            
            $token = array(
                'sub'           => $user->User_ID,
                'email'         => $user->User_Email,
                'nombres'       => $user->User_Name,
                'apellidos'     => $user->User_Apellido,
                'perfil_id'     => $user->Perfil_User,
                'image'         => $user->User_Ruta_Imagen,
                'iat'           => time(),
                'exp'           => time() + (7 * 24 * 60 * 60)
            );
           
            $jwt = JWT::encode($token, $this->key, 'HS256');

            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            //Devolver los datos decodificados o el token en funcion de un parametro
            if (is_null($getToken)) {
                $data =  $jwt;
            } else {
                $data =  $decoded;
            }
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Login Incorrecto'

            );
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = false)
    {

        $auth = false;
        try {
            $jwt = str_replace('"','',$jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        } else {
            $auth = false;
        }
        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }
}
