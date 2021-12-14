<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\ApiAuthMiddleware;
use GuzzleHttp\Middleware;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','MailController@getMail');

Route::get('enviarCorreo', 'MailController@enviarCorreo');
//--------------------------------
//Rutas  del modulo de inventario
//--------------------------------

Route::resource('proveedor', 'proveedoresController');
Route::resource('producto', 'MateriaController');

Route::get('MaterialeFitro', 'MateriaController@filtroMaterial');
Route::get('MaterialFitroNombre/{nombre}', 'MateriaController@filtroMaterialNombre');
Route::get('MaterialFitroInteligente/{nombre}/{marca}', 'MateriaController@filtroMaterialEconomico');





Route::resource('estados/proyecto', 'estadoProyectoController');


Route::resource('estados/separacion', 'estado_separacionController');




Route::get('validarNombreProyecto/{nombre}', 'proyectoController@validarNombreProyecto');


Route::resource('proyectos', 'proyectoController');
Route::name('print')->get('imprimir', 'proyectoController@imprimir');



//-------------------------------
//inventario inmueble
//-------------------------------


Route::get('sendbasicemail','MailController@basic_email');
Route::get('sendhtmlemail','MailController@html_email');
Route::get('attachment_email','MailController@attachment_email');


Route::resource('inmueble', 'InmuebleController');
Route::resource('tipo_inmueble', 'tInmuebleController');
Route::post('filtroInmueble/{id}', 'InmuebleController@filtroInmuebles');
Route::post('filtroInmueblesTipo/{id}','InmuebleController@filtroInmueblesTipo');

Route::resource('torre', 'TorreController');
Route::get('buscarTorre/{nombre}/{proyecto}', 'TorreController@filtroTorreProyecto');
Route::get('filtroProyectoTorre/{proyecto}', 'TorreController@filtroProyectoTorre');




Route::post('inmueblesDisponibles/{id}','InmuebleController@inmueblesDisponibles');
Route::get('filtroInmueblesTorre/{torre}/{proyecto}', 'InmuebleController@filtroInmueblesTorre');

//--------------------------------------------------------------------

//Rutas  del modulo de oportunidad de venta
//--------------------------------------------------------------------


// Rutas del controlador de oportunidad de venta

Route::resource('oportunidad_venta', 'Oportunidad_ventaController');
Route::resource('estado/oportunidad', 'Estado_OpController');



// Rutas del controlador de cliente
Route::resource('cliente', 'ClientesController');

Route::post('mostrarInformacion','Oportunidad_ventaController@mostrarInformacion');



// rutas del controlador de tareas
Route::resource('tareas', 'TareasController');
Route::resource('estado/tarea', 'Estado_tareaController');


// Rutas del controlador nivel de estudios

Route::resource('nivelEstudios', 'nivelEstudiosController');




//--------------------------------------------------------------------
//Rutas  del controlador de ordenes de compra
//--------------------------------------------------------------------


Route::resource('ordenesCompra', 'ordenesCompraController');
Route::post('replicarData', 'ordenesCompraController@replicarData');

Route::get('generateReferencia', 'ordenesCompraController@generateReference');
Route::get('FiltroGerencia', 'ordenesCompraController@FiltroGerente');
Route::put('revisarGerente/{id}', 'ordenesCompraController@revisionGerente');




//--------------------------------------------------------------------
//Rutas  de  cotizaciones
//--------------------------------------------------------------------


Route::resource('cotizaciones', 'cotizacionesController');


Route::get('validacion/{id}', 'fechaPagosCotizacionController@validacionPorcentaje');



Route::get('generateReferencia', 'fechaPagosCotizacionController@generateReferencia');



Route::get('consultaEstado', 'fechaPagosCotizacionController@consultaEstados');

Route::resource('fechaPagos/Cotizaciones', 'fechaPagosCotizacionController');





Route::post('filtroPago', 'cotizacionesController@filtroPago');



Route::resource('estados/Cotizacion', 'estadoCotizacionController');

// Route::resource('estados/FechaPago', 'estadoFechaPagosController');

//--------------------------------------------------------------------
// Rutas de las configuraciones del aplicativo
//---------------------------------------------------------------------

Route::resource('medida', 'medidaController');
Route::resource('category', 'categoriaMateriaController');

Route::resource('dtIdentificacion', 'tIdentificacionController');

//Routas de perfiles

Route::post('perfil/agregar', 'PerfilController@addPerfil');
Route::get('perfil/detail/{id}', 'PerfilController@getPerfil');
Route::get('perfil', 'PerfilController@index');

//Routas del controlador de usuario

Route::get('usuarios', 'UserController@index');
Route::post('usuario/registro', 'UserController@register');
Route::post('usuario/login', 'UserController@login');
Route::put('usuario/update/{id}', 'UserController@update');
Route::post('usuario/upload', 'UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('usuario/avatar/{filename}', 'UserController@getImage');
Route::get('usuario/detail/{id}', 'UserController@detail');
Route::delete('users/{id}','UserController@delete');

// Ciudades



Route::resource('ciudades', 'ciudad_departamentoController');

Route::get('filtroDepartamento','ciudad_departamentoController@filtroDepartamento');
Route::get('filtroMunicipio/{codigo}','ciudad_departamentoController@filtroMunicipio');

Route::post('FiltroDisponibles','Oportunidad_ventaController@FiltroDisponibles');
Route::get('filterProyectoId/{id}','TorreController@filterProyectoId');



