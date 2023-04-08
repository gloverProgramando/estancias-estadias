<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Periodo;
use App\Models\Fase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Redirect;

class documentosEstancia1AdminController extends Controller
{

    public function periodo(){
        $fases = DB::table('fases')
        ->get();
        $periodos = DB::table('periodo')
        ->get();
        return view('admin.crear_periodo',compact('fases','periodos'));
    }

    public function cambiarPeriodo($IdPeriodo) {
        $periodo = Periodo::find($IdPeriodo);
        $periodos = DB::table('periodo')
        ->get();
        $fases = DB::table('fases')
        ->get();
        if($periodo){
            $activo = $periodo->Activo == 1 ? 0 : 1;
            $periodo->Activo = $activo;
            $periodo->save();
            $mensaje = $activo == 0 ? 'La fase ha sido desactivada' : 'La fase ha sido activada';
            return redirect()->to('/Periodo')->with('success',$mensaje , compact('fases','periodos'));
        } else {
            return redirect()->to('/Periodo')->with('error', 'No se encontró el periodo', compact('fases','periodos'));
        }
    }

    public function crearPeriodo(Request $request){
        $date = Carbon::now();
        $anio = Carbon::parse($date)->year;
        $mes = Carbon::parse($date)->month;

        if ($mes >= 1 && $mes <= 4) {
            $numero = $anio . '01';
        } elseif ($mes >= 5 && $mes <= 8) {
            $numero = $anio . '02';
        } else {
            $numero = $anio . '03';
        }
        $periodoExistente = Periodo::where('Periodo',$numero)->first();
        if($periodoExistente){
            return redirect()->to('/Periodo')->with('error','Periodo: '.$numero.' ya existe, si quiere activar las etapas, favor de hacerlo en la parte de abajo');
        }
        for ($i = 1; $i <= 3; $i++) {
            $periodo = new Periodo;
            $periodo->Periodo = $numero;
            $periodo->Idfase = $i;
            $periodo->Activo = 1;
            $periodo->save();
        }
        return redirect()->to('/Periodo')->with('success','periodo: '.$numero.' creado con exito');
    }

    public function ver($proces){
        $name=['Estancia I','Estancia II','Estadia','Estadias Nacionales','Servicio Social'];
        //!cambiar este numero si se quiere agregar un nuevo proceso y tambien agregar el nombre en $name
        if($proces>0 && $proces<=5){//comprueba si el numero es de algun proceso del 1...5
            //$NmProces=$name[$proces-1];
            $var=[$proces,$name[$proces-1]];//guarda el numero y nombre del proceso
        }else return redirect('admin');
        
        //datos usuarios
        $users = DB::table('users')
        ->get();
        //datos de documentos
        $documentos=DB::table('users')
        ->get();
        //array 1
        $users   = ['usuarios' => $users];
        $docs   = ['documentos' => $documentos];
        $datos = Arr::collapse([$users,$docs]);


        return view('admin.documentosEstancia1',[]);
    }
    public function ver_cd_estancia_f03($id,$name){//#
        $users = DB::table('users')
        ->join('respuesta', 'users.id', '=', 'respuesta.id_usuario')
        ->join('formulario', 'respuesta.id_formulario', '=', 'formulario.id')
        ->join('alumno', 'formulario.id_alumno', '=', 'alumno.id')
        ->join('empresa', 'formulario.id_empresa', '=', 'empresa.id')
        ->join('asesor_empresarial', 'formulario.id_asesor_emp', '=', 'asesor_empresarial.id')
        ->join('asesor_academico', 'formulario.id_asesor_aca', '=', 'asesor_academico.id')
        ->join('proyecto', 'formulario.id_proyecto', '=', 'proyecto.id')
        ->join('carreras', 'carreras.id_carrera', '=', 'alumno.id_carrera')
        ->select('formulario.id_alumno','formulario.id_empresa','formulario.id_asesor_emp','formulario.id_asesor_aca','formulario.id_proyecto','formulario.id','respuesta.id_usuario','carreras.nombre_carrera','users.name','alumno.ape_paterno','alumno.ape_materno','alumno.nombres','alumno.tel','alumno.matricula','alumno.email_per','alumno.email','alumno.no_ss','alumno.direccion','alumno.id_carrera','empresa.nombre_emp','empresa.giro','empresa.id_tipo','empresa.direccion_emp','empresa.ape_paterno_rh','empresa.ape_materno_rh','empresa.nombres_rh','empresa.tel_lada','empresa.tel_num','empresa.tel_ext','empresa.email_emp','asesor_empresarial.ape_paterno_ae','asesor_empresarial.ape_materno_ae','asesor_empresarial.nombres_ae','asesor_empresarial.id_cargo_ae','asesor_empresarial.tel_lada_ae','asesor_empresarial.tel_num_ae','asesor_empresarial.email_ae','asesor_academico.ape_paterno_aa','asesor_academico.ape_materno_aa','asesor_academico.nombres_aa','asesor_academico.id_cargo_aa','asesor_academico.tel_lada_aa','asesor_academico.tel_num_aa','asesor_academico.email_aa','proyecto.nombre_proyecto')
        ->where('users.name',$name)
        ->get();

        $documentos=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('cedula_registro','documentos.id_c_registro','=','cedula_registro.id')
        ->where('cedula_registro.id',$id)
        ->get();

        $users   = ['usuarios' => $users];
        $docs   = ['documentos' => $documentos];

        
        $datos = Arr::collapse([$users,$docs]);
        return  view('admin.f03_cd_estancia',['documentos'=>$datos,]);
    }
    //ver documento
    public function ver_documento($name,$proces){//*funcion optimizada 
        $nombre='/documentos/'.$name;
        $nombreD= public_path($nombre);
        $resp=file_exists($nombreD);
        if($resp==true){
            return response()->file($nombreD);
        }else return redirect('estancia1_Documentos/'.$proces)->with('sinRespuesta',' Carga horaria no ha sido encontrado');        
    }
    //aceptar documentos->envia correo
    public function aceptar_documento(request $request,$idU,$id,$proces,$doc) {//*funcion optimizada
        $texto   =trim($request->get('texto1'));
        $estatus =trim($request->get('estatus'));
        $año     =trim($request->get('año'));
        $name=['Carga Horaria','Constancia de Derecho',
        'Carta Responsiva','Carta de Presentación',
        'Carta de Aceptacion','Cedula de Registro',
        'Definicion de Proyecto','Carta de Liberacion','Carta Compromiso','Reporte Mensual','Reporte Mensual',
        'Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual',
        'Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual'];
        $resp=$name[$doc-1].' Aceptada y '.CorreoController::store($idU, $name[$doc-1],1);
        return back()->withInput()->with('aceptado',$resp);
    }
    //documento pendiente->no manda correo
    public function pendiente_documento(request $request,$idU,$id,$proces,$doc) {//*funcion optimizada
        $texto   =trim($request->get('texto1'));
        $estatus =trim($request->get('estatus'));
        $año     =trim($request->get('año'));
        $name=['Carga Horaria','Constancia de Derecho',
        'Carta Responsiva','Carta de Presentación',
        'Carta de Aceptacion','Cedula de Registro',
        'Definicion de Proyecto','Carta de Liberacion','Carta Compromiso','Reporte Mensual','Reporte Mensual',
        'Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual',
        'Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual','Reporte Mensual'];
        return back()->withInput()->with('pendiente',$name[$doc-1].' Pendiente');
    }
    //vista observaciones carga horaria
    public function observaciones_documento(Request $request, $idU,$proces,$doc) {//*funcion optimizada
        $texto   =trim($request->get('texto1'));
        $estatus =trim($request->get('estatus'));
        $año     =trim($request->get('año'));
        $id_c   = ['id_c'=>$request->input('id_c'), 'idU'=>$idU,'#proces'=>$proces,'#doc'=>$doc,'#texto'=>$texto];//manda datos a la vista para despues pasarlo a correo
        $datos = Arr::collapse([$id_c]);
        return view('admin.observaciones_estancia_carga_horaria',['datos'=>$datos]);
    }
    //vista observaciones con observaciones carga horaria
    public function conObservaciones_documento_admin(Request $request,$proces,$doc) {//*funcion optimizada
        $id_c   = [ $request->input('id_c')];
        $id_c_r   = ['id_c'=>$request->input('id_c'),'#proces'=>$proces,'#doc'=>$doc];
        $datos = Arr::collapse([$id_c_r]);
        return view('admin.conObservaciones_estancia_carga_horaria',[]);
    }
    //guardar carga horaria->manda correo
    public function  guardarObservaciones_documento_admin(Request $request,$id, $idU,$proces,$doc){//*funcion optimizada
 
        if(Session("url_return")){
            return redirect(Session("url_return"))->with('Con Observacion');
            $request->session()->put('url_return', null);
        }
    }
    //buscar datos de usuario
    public function buscador_estancia1(Request $request,$proces,$name){//*optimizado
        $request->session()->put('url_return', $request->fullUrl());
        $var=[$proces,$name];  
        $texto   =trim($request->get('texto'));
        $estatus =trim($request->get('estatus'));
        $año     =trim($request->get('año'));

        $users0 = DB::table('users')
        ->where('users.name','LIKE','%'.$texto.'%')
        ->orWhere('users.email','LIKE','%'.$texto.'%')
        ->get();

        $nombres=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('cedula_registro','documentos.id_c_registro','=','cedula_registro.id')
        ->where('documentos.id_proceso',$proces)
        ->get();

        $users = DB::table('users')
        ->join('respuesta', 'users.id', '=', 'respuesta.id_usuario')
        ->join('formulario', 'respuesta.id_formulario', '=', 'formulario.id')
        ->join('alumno', 'formulario.id_alumno', '=', 'alumno.id')
        ->join('carreras', 'alumno.id_carrera', '=', 'carreras.id_carrera')
        ->where('alumno.id_procesos',$proces)
        ->get();

        $documentos=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->where('documentos.id_proceso',$proces)
        ->where('documentos.estatus','LIKE','%'.$estatus.'%')
        ->where('documentos.updated_at','LIKE','%'.$año.'%')
        ->get();

        $users1   = ['usuarios' => $users];
        $docs   = ['documentos' => $documentos];
        $datos = Arr::collapse([$users1,$docs]);

        return view('nombres.Buscar_estancia1',[]);
    }

    //buscar usuario lleno cedula de registro
    public function buscador_estancia1_c(Request $request,$proces,$name){//*optimizado
        $var=[$proces,$name];    
        $texto   =trim($request->get('texto'));
        $estatus =trim($request->get('estatus'));
        $año     =trim($request->get('año'));

        $users0 = DB::table('users')
        ->join('respuesta', 'users.id', '=', 'respuesta.id_usuario')
        ->join('formulario', 'respuesta.id_formulario', '=', 'formulario.id')
        ->join('alumno', 'formulario.id_alumno', '=', 'alumno.id')
        ->join('carreras', 'alumno.id_carrera', '=', 'carreras.id_carrera')
        ->where('alumno.id_procesos',$proces)
        ->where('alumno.id_procesos','0')  
        ->orWhere('alumno.nombres','LIKE','%'.$texto.'%')
        ->orWhere('alumno.ape_paterno','LIKE','%'.$texto.'%')
        ->orWhere('alumno.ape_materno','LIKE','%'.$texto.'%')
        ->orWhere('alumno.matricula','LIKE','%'.$texto.'%')
        ->orWhere('alumno.email','LIKE','%'.$texto.'%')
        ->orWhere('carreras.nombre_carrera','LIKE','%'.$texto.'%')
        ->get();
        
        $nombres=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('cedula_registro','documentos.id_c_registro','=','cedula_registro.id')
        ->get();

        $users = DB::table('users')
        ->join('respuesta', 'users.id', '=', 'respuesta.id_usuario')
        ->join('formulario', 'respuesta.id_formulario', '=', 'formulario.id')
        ->join('alumno', 'formulario.id_alumno', '=', 'alumno.id')
        ->join('carreras', 'alumno.id_carrera', '=', 'carreras.id_carrera')
        ->where('alumno.id_procesos',$proces)
        ->get();

        $documentos=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->where('documentos.id_proceso',$proces)
        ->get();

        $users1   = ['usuarios' => $users];
        $docs   = ['documentos' => $documentos];
        $datos = Arr::collapse([$users1,$docs]);

        $doc_f02 = DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('carta_aceptacion','documentos.id_c_aceptacion','=','carta_aceptacion.id')
        ->where('documentos.id_proceso',$proces)
        ->get();

        $doc_f04=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('definicion_proyecto','documentos.id_d_proyecto','=','definicion_proyecto.id')
        ->where('documentos.id_proceso',$proces)
        ->get();

        $c_a   = ['carta_aceptacion' => $doc_f02];
        $d_p   = ['definicion_proyecto' => $doc_f04];
        $datos1 = Arr::collapse([$c_a,$d_p]);
        $doc_f03=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('cedula_registro','documentos.id_c_registro','=','cedula_registro.id')
        ->where('documentos.id_proceso',$proces)
        ->get();
        $doc_f05=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('carta_liberacion','documentos.id_c_liberacion','=','carta_liberacion.id')
        ->where('documentos.id_proceso',$proces)
        ->get();
        $c_l   = ['carta_liberacion' => $doc_f05];
        $c_r   = ['cedula_registro' => $doc_f03];
        $datos2 = Arr::collapse([$c_l,$c_r]);

        $doc_carta_presentacion=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('carta_presentacion','documentos.id_c_presentacion','=','carta_presentacion.id')
        ->where('documentos.id_proceso',$proces)
        ->get();
        $doc_carga_horaria=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('carga_horaria','documentos.id_c_horaria','=','carga_horaria.id')
        ->where('documentos.id_proceso',$proces)
        ->get();
        $c_p   = ['carta_presentacion' => $doc_carta_presentacion];
        $c_h   = ['carga_horaria' => $doc_carga_horaria];
        $datos3 = Arr::collapse([$c_p,$c_h]);

        $doc_constancia_derecho=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('constancia_derecho','documentos.id_c_derecho','=','constancia_derecho.id')
        ->where('documentos.id_proceso',$proces)
        ->get();
        $doc_carta_responsiva=DB::table('users')
        ->join('respuesta_doc','users.id','=','respuesta_doc.id_usuario')
        ->join('documentos','documentos.id','=','respuesta_doc.id_documentos')
        ->join('carta_responsiva','documentos.id_c_responsiva','=','carta_responsiva.id')
        ->where('documentos.id_proceso',$proces)
        ->get();
        $c_d   = ['constancia_derecho' => $doc_constancia_derecho];
        $c_res   = ['carta_responsiva' => $doc_carta_responsiva];
        $datos4 = Arr::collapse([$c_d,$c_res]);
        $alumnos = DB::table('alumno')
        ->where('id_procesos',$proces)
        ->get();

        return view('nombres.Buscar_estancia1',['nombres'=>$nombres,'texto'=>$texto,'estatus'=>$estatus,'año'=>$año,
        'documentos'=>$users0,'documentos1'=>$datos,'documentos2'=>$datos1,'documentos3'=>$datos2,
        'documentos4'=>$datos3,'documentos5'=>$datos4,'alumnos'=>$alumnos,'proceso'=>$var]);
    }
}
