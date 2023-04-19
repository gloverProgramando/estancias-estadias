<?php

use App\Http\Controllers\CedulaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\carta_aceptacionController;
use App\Http\Controllers\datosController;
use App\Http\Controllers\definicion_proyectoController;
use App\Http\Controllers\definicionController;
use App\Http\Controllers\DescargaController;
use App\Http\Controllers\documentosEstadiaAdminController;
use App\Http\Controllers\documentosEstadiaNacionalAdminController;
use App\Http\Controllers\documentosEstancia1AdminController;
use App\Http\Controllers\documentosEstancia2AdminController;
use App\Http\Controllers\documentosServicioSocialAdminController;
use App\Http\Controllers\Estadia_NacionalesController;
use App\Http\Controllers\EstadiaController;
use App\Http\Controllers\Estancia1Controller;
use App\Http\Controllers\Estancia2Controller;
use App\Http\Controllers\falloController;
use App\Http\Controllers\FormulariosController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ScrollController;
use App\Http\Controllers\ServicioSocialesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\BotonesController;
use App\Http\Controllers\datatableController;
use App\Models\documentos;
use App\Models\Formulario;
use App\Models\universidad;
use League\CommonMark\Block\Element\Document;

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

Route::get('/', function () {
    return redirect('/login');
})->middleware('login');

Route::get('/register', [RegisterController::class, 'create'])
->middleware('login')
->name('register.index');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');



Route::get('/login', [LoginController::class, 'create'])
    ->middleware('login')
    ->name('login.index');

Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');

Route::get('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('login.destroy');

//admin
    //editar contra vista
    Route::get('/admin_ver_editar', [AdminController::class, 'ver'])
    ->middleware('auth.admin')
    ->name('admin_ver_editar.index');
    
    //editar contra
    Route::match(['post','get','put'],'/admin_editar', [AdminController::class, 'editar'])
    ->middleware('auth.admin')
    ->name('admin_editar.index');

    //dashboard
    Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth.admin')
    ->name('admin.index');

    Route::get('/Periodo',[documentosEstancia1AdminController::class, 'periodo'])
    ->middleware('auth.admin')
    ->name('adminPeriodo.index');

    Route::get('/CrearPeriodo',[documentosEstancia1AdminController::class, 'crearPeriodo'])
    ->middleware('auth.admin')
    ->name('adminPeriodoCrear.index');

    Route::get('/Asesores',[documentosEstancia1AdminController::class,'ver_csv_academico'])
    ->middleware('auth.admin')
    ->name('asesores.index');

    Route::match(['post','get'],'/Asesores_subir',[documentosEstancia1AdminController::class,'subir_csv_academico'])
    ->middleware('auth.admin')
    ->name('asesores_subir.index');

    Route::match(['post','get'],'/Asesores_subir_E',[documentosEstancia1AdminController::class,'subir_csv_empresarial'])
    ->middleware('auth.admin')
    ->name('asesores_subir_E.index');

    Route::match(['post','get'],'/modificarFase_{id}/{fase}',[documentosEstancia1AdminController::class,'cambiarPeriodo'])
    ->middleware('auth.admin')
    ->name('adminActivarFase.index');
//Ver usuarios
    // Route::get('/usuarios/table', [UsuariosController::class, 'armar'])
    // ->name('usuarios/table.index') //Para usar con data tables
    // ->middleware('auth.admin');

    Route::get('/usuarios', [UsuariosController::class, 'create'])
    ->name('usuarios.index')
    ->middleware('auth.admin');
    
         //buscardor
        Route::get('/buscar_usuario', [UsuariosController::class, 'buscarUsuario'])
        ->name('buscar_usuario.index')
        ->middleware('auth.admin');

          //buscardor datos
        Route::get('/buscar_datos', [UsuariosController::class, 'buscarUsuarioDatos'])
        ->name('buscar_usuario_datos.index')
        ->middleware('auth.admin');

          //agregar usuario
        Route::get('/agregar_usuario', [UsuariosController::class, 'ver'])
        ->name('agregar_usuario.index')
        ->middleware('auth.admin');

          //registrar usuario
        Route::post('/registrar', [RegisterController::class, 'registrar'])
        ->name('registrar_usuario.index');

         //cambiar datos usuario
        Route::match(['post','get','delete'],'/ver_datos_usuario_{id}', [UsuariosController::class, 'ver_datos_usuario'])
        ->name('ver_datos_usuario.index');
        
        //editar datos usuario
        Route::match(['post','get','delete'],'/editar_datos_usuario_{id}', [UsuariosController::class, 'editar_datos_usuario'])
        ->name('editar_datos_usuario.index');
        
         //eliminarusuarios
        Route::match(['post','get','delete'],'/eliminar_usuario_{id}', [UsuariosController::class, 'eliminarUsuario'])
        ->name('eliminarUsuario.index');

          //eliminarusuarios
        Route::match(['post','get','delete'],'/eliminar_usuarioC_{id}', [UsuariosController::class, 'eliminarUsuarioC'])
        ->name('eliminarUsuarioCompleto.index');

         //restaurar usuarios
        Route::match(['post','get','delete'],'/restaurar_usuario_{id}', [UsuariosController::class, 'restaurarUsuario'])
        ->name('restaurarUsuario.index');

//cambiar datos director
    Route::get('/datos', [datosController::class, 'ver'])
    ->name('datos.index')
    ->middleware('auth.admin');

        //guardar datos vinculacion
        Route::match(['post','get','put'],'/guardar_datos_vinculacion', [datosController::class, 'guardar'])
        ->name('guardar_vinculacion.index');

        //actualizar datos vinculacion
        Route::match(['post','get','put'],'/actualizar_datos_vinculacion', [datosController::class, 'actualizar'])
        ->name('actualizar_vinculacion.index');  

        //imagen
        Route::match(['post','get','put'],'/imagen/{filename}', [datosController::class, 'imagen'])
        ->name('imagen.index');      
//*proceso

    Route::get('/activar_botones', [BotonesController::class, 'ver'])
    ->name('activar_botones.index')// Para los botones
    ->middleware('auth.admin');

    Route::get('/datatable_user',[datatableController::class, 'ver']) //datatable de prueba
    ->name('datatable.index')
    ->middleware('auth.admin');
    //datatable detallada
    Route::get('/datatable_user_detallados_datos',[datatableController::class ,'verdetalles'])
    ->name('datatabledetallada.index')
    ->middleware('auth.admin');

    Route::put('/actualizar_botones', [BotonesController::class, 'updateBoton'])
    ->name('actualizar_botones.index');// Para los botones

    Route::match(['post','get'],'/estancia1_Documentos/{proces}', [documentosEstancia1AdminController::class, 'ver'])
    ->name('documentoEstancia1Admin.index')//!ver alumnos por proceso 1,2,3..etc.
    ->middleware('auth.admin');
    //*opciones de todos los docs
         //*ver documentos
         Route::match(['post','get'],'/ver_documento/{name}/{proces}', [documentosEstancia1AdminController::class, 'ver_documento'])
         ->name('ver_documento.index')//!ver documentos admin
         ->middleware('auth.admin');
         //*Cambiar estado doc
         Route::match(['post','get','put'],'/aceptar_documento/admin/{idU}', [documentosEstancia1AdminController::class, 'Cambiar_Estado_Doc'])
         ->name('Cambiar_documento_Estado.index');//!aceptar documentos admin
         //*observacion
         Route::match(['get','post','put'],'/observaciones_documento_admin/{idDoc}', [documentosEstancia1AdminController::class, 'observacion_documento_ver'])
         ->name('observacion_documento_ver.index');
         //*observacion guardar
         Route::match(['get','post','put'],'/guardar_observaciones_documento_admin/{idDoc}', [documentosEstancia1AdminController::class, 'observacion_documento'])
         ->name('observacion_documento.index');

         //*aceptar docs
         Route::match(['post','get','put'],'/aceptar_documento/admin/{idU}/{id}/{proces}/{doc}', [documentosEstancia1AdminController::class, 'aceptar_documento'])
         ->name('aceptar_documento.index');//!aceptar documentos admin
 
         //*pendiente docs
         Route::match(['post','get','put'],'/pendiente_documento/admin/{idU}/{id}/{proces}/{doc}', [documentosEstancia1AdminController::class, 'pendiente_documento'])
         ->name('pendiente_documento.index');//!pendiente docs admin
 
         //*observaciones docs
         Route::match(['post','get','put'],'/observaciones_documento_admin/{idU}/{proces}/{doc}', [documentosEstancia1AdminController::class, 'observaciones_documento'])
         ->name('observaciones_documento.index')//!observaciones docs admin
         ->middleware('auth.admin');
 
         //*guardar observaciones docs
         Route::match(['get','post','put'],'/guardar_observaciones_documento_admin/{id}/{idU}/{proces}/{doc}', [documentosEstancia1AdminController::class, 'guardarObservaciones_documento_admin'])
         ->name('guardarObservaciones_documento.index');//!guardar obsv de docs admin
 
         //*ver observaciones docs
         Route::match(['post','get'],'/con_Observaciones_documento_admin1/{proces}/{doc}', [documentosEstancia1AdminController::class, 'conObservaciones_documento_admin'])
         ->name('conObservaciones_documento.index')//!ver observaciones admin
         ->middleware('auth.admin');
    
        //*buscardor por matricula
        Route::get('/Buscar/{proces}/{name}', [documentosEstancia1AdminController::class, 'buscador_estancia1'])
        ->name('Buscar_estancia1.index')//!buscar por matricula
        ->middleware('auth.admin');


        //*buscador por nombre 
        Route::get('/Buscar_datos_c/{proces}/{name}', [documentosEstancia1AdminController::class, 'buscador_estancia1_c'])
        ->name('Buscar_estancia1_c.index')//!buscar por nombre o 1 apellido
        ->middleware('auth.admin');

//-----------estadia nacional
    Route::match(['post','get'],'/estadia_nacional_Documentos', [documentosEstadiaNacionalAdminController::class, 'ver'])
    ->name('documentoEstadiaNacionalAdmin.index')
    ->middleware('auth.admin');

//-----------servicio social
    Route::match(['post','get'],'/servicio_social_Documentos', [documentosServicioSocialAdminController::class, 'ver'])
    ->name('documentoServicioSocialAdmin.index')
    ->middleware('auth.admin');


//alumno
    //inicio
    Route::get('/inicio', [InicioController::class, 'ver'])
    ->name('inicio.index')
    ->middleware('auth');

    //editar contra vista
    Route::get('/alumno_ver_editar', [LoginController::class, 'ver'])
    ->middleware('auth')
    ->name('alumno_ver_editar.index');

    //editar contra
    Route::match(['post','get','put'],'/alumno_editar', [LoginController::class, 'editar'])
    ->middleware('auth')
    ->name('alumno_editar.index');

    //reiniciar USUARIO
    Route::match(['post','get','put'],'/reiniciar_{id}', [InicioController::class, 'reiniciarU'])
    ->name('reiniciarU.index')
    ->middleware('auth');

    Route::match(['post', 'delete','put','get'],'/CrearPeriodo/{name}/{proces}',[Estancia1Controller::class, 'CrearPeriodoAlumno'])
    ->name('CrearProcesoAlumno.index');


//formatos
Route::match(['post','get'],'/estancia1/{Proces}', [Estancia1Controller::class, 'ver'])
    ->name('estancia1.index')//*funcion optimizada
    ->middleware('auth');

 //enviar documento carga horaria con datos
    Route::match(['post', 'delete','put'],'actualizar/carga_horaria1/{name}/{proces}/{idDoc}', [Estancia1Controller::class, 'actualizar_carga_horaria_estancia1'])
    ->name('actualizar_docs.index');//*funcion optimizada

    //enviar documento carga horaria sin datos 
    Route::match(['post', 'delete','put','get'],'subir/carga_horaria1/{name}/{proces}/{IdTipoDoc}', [Estancia1Controller::class, 'subir_carga_horaria_estancia1'])
    ->name('subir_doc.index');//*funcion optimizada

    Route::match(['post', 'delete','put','get'],'subir/carga_horaria1/{name}/{proces}/{idDoc}', [Estancia1Controller::class, 'subir_carga_horaria_estancia1'])
    ->name('subir_doc_alumno.index');//*funcion optimizada

    //cancelar solicitud documento carga horaria
    Route::match(['post', 'delete','put'], '/cancelar_documento_alumno/{proces}/{id_docs}',[Estancia1Controller::class,'cancelar_documento_alumno'])
    ->name('cancelar_doc.index');//*funcion optimizada

    Route::match(['post', 'delete','put'], '/carga_horaria/{proces}/{id_docs}/{id_d}/{idDoc}',[Estancia1Controller::class,'cancelar_carga_horaria_Estancia'])
    ->name('cancelar_doc_alumno.index');//*funcion optimizada
//#
    

    //descargar con datos f01
    Route::get('/descarga_cd_estancia_f01/{proces}', [DescargaController::class, 'descarga_carta_presentacion'])
    ->name('descarga_cd_estancia_f01.index');//*optimizado

    Route::get('/descargarFormatos/{doc}', [DescargaController::class, 'DescargarFormatoDocumento'])
    ->name('DescargarFormatoDocumento.index');//*optimizado
    
    //descargar con datos f02
    Route::get('/descarga_cd_estancia_f02/{proces}', [PdfController::class, 'descarga_cd_f02_estancia'])
    ->name('descarga_cd_estancia_f02.index');//*optimizado

    

    //llenar f03
    Route::get('/home/{id_proces}', [CedulaController::class, 'ver'])
    ->name('home.index')
    ->middleware('auth');//*funcional
    
    Route::post('/home', [CedulaController::class, 'store'])
        ->name('home.store');//*funcional
    
    

    //descargar con datos f03
    Route::get('/descarga_cd_estancia_f03/{id_proces}', [PdfController::class, 'descarga_cd_estancia_f03'])
    ->name('descarga_cd_estancia_f03.index');//*funcional

    //eliminar f03 estancia
    Route::match(['post', 'delete','put','get'],'/f03Estancia/{proces}/{id_a}/{id_e}/{id_a_e}/{id_a_a}/{id_p}',[PdfController::class,'eliminarF03Estancia'])
    ->name('eliminar_f03');//*funcional
    

    //llenar datos f04
    Route::get('/usuario_estancia/f04-definicion_de_proyecto/{proces}/{name}', [definicionController::class, 'ver'])
    ->name('f04Formulario.index')//*optimizado
    ->middleware('auth');

    //guardar f04
    Route::post('/usuario/f04-definicion_de_proyecto1', [definicion_proyectoController::class, 'store'])
    ->name('f04Guardar1.index');//*optimizado

    //eliminar f04
    Route::match(['post', 'delete','put','get'],'/f04/{proces}/{id_a}/{id_a_e}/{id_p}/{id_d}',[PdfController::class,'eliminarF04'])
    ->name('eliminar_f04.index');//*optimizado

    //descargar f04 con datos
    Route::get('/descarga_cd_estacia_f04/{id_proces}/{name}', [PdfController::class, 'descarga_cd_estancia_f04'])
    ->name('descarga_cd_estancia_f04.index');//*optimizado



    //descargar f05 con datos
    Route::get('/descarga_cd_estacia_f05/{proces}', [PdfController::class, 'descarga_cd_estancia_f05'])
    ->name('descarga_cd_estancia_f05.index');//*optimizado

    
    //reporte evaluacion
    //Descarga
    Route::match(['post', 'delete','put','get'],'descarga/reporte_evaluaciona_estancia/{proces}', [DescargaController::class, 'descarga_reporte_estancia'])
    ->name('descarga_reporte_evaluacion_estancia.index');//*optimizado


    //Descarga
    Route::match(['post', 'delete','put','get'],'descarga/carta_responsiva_estancia', [DescargaController::class, 'descarga_carta_responsiva'])
    ->name('descarga_carta_responsiva.index');//*funcional


 //f05
  
//------------------estadia_nacionales
    Route::match(['post','get'],'/estadia_nacionales', [Estadia_NacionalesController::class, 'ver'])
    ->name('estadia_nacionales.index')
    ->middleware('auth');



//------------------------servicio_sociales
    Route::match(['post','get'],'/servicio_sociales1', [ServicioSocialesController::class, 'ver'])
    ->name('servicio_sociales.index')
    ->middleware('auth');

    Route::match(['post','get'],'/servicio_sociales1D', [DescargaController::class, 'descarga_carta_compromiso'])
    ->name('descargar_carta_compromiso.index')
    ->middleware('auth');

    Route::match(['post','get'],'/servicio_sociales1S', [DescargaController::class, 'descarga_reporte_mensual'])
    ->name('descargar_reporte_mensual.index')
    ->middleware('auth');

    Route::match(['post','get'],'/servicio_sociales1a', [DescargaController::class, 'descarga_carta_aceptacion'])
    ->name('descargar_carta_aceptacion_servicio.index')
    ->middleware('auth');

//------------fallos
    Route::match(['post','get'],'/errores', [falloController::class, 'ver'])
    ->name('fallos.index')
    ->middleware('auth');;

    

    //registro final cedula f03

    Route::match(['post','get'],'/registro_final_cedula/{id_proces}', [falloController::class, 'verRegistroFinalCedula'])
    ->name('registro_final_cedula.index')//*funcional
    ->middleware('auth');;


    //registro final definicion f04
    Route::match(['post','get'],'/registro_final_definicion', [falloController::class, 'verRegistroFinalDefinicion'])
    ->name('registro_final_definicion.index')
    ->middleware('auth');;
//---observaciones documentos estancia 1 ------
    //Ver Observaciones  Carga horaria del admin vista usuario
    Route::match(['post','get'],'/observaciones1_carga_horaria/{proces}/{idDoc}/{id}', [Estancia1Controller::class, 'verObservaciones1_carga_horaria'])
    ->name('observaciones_doc.index')//!optimizado
    ->middleware('auth');

