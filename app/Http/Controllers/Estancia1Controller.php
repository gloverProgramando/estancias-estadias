<?php

namespace App\Http\Controllers;


use App\Models\documentos;
use App\Models\aa_pp;
use App\Models\ae_pp;
use App\Models\tipodoc;
use App\Models\detalledoc;
use App\Models\estadodoc;
use App\Models\proceso;
use App\Models\periodo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 
use Carbon\Carbon;
use phpDocumentor\Reflection\Location;

class Estancia1Controller extends Controller
{
    public function CrearPeriodoAlumno(Request $request,$idUsuario,$procesos){
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
        $periodoExistente = periodo::where('Periodo',$numero)->first();
        $procesoExistente = proceso::where('IdUsuario',$idUsuario)->where('IdTipoProceso',$procesos)->where('IdPeriodo',$periodoExistente->IdPeriodo)->first();
        if(!$periodoExistente){
            return redirect('estancia1/' . $procesos)->with('error', 'Periodo Actual todavia no existe, contacta con el administrador del sistema');
        }else {
            if($procesoExistente){
                return redirect('estancia1/'. $procesos)->with('error','ya tienes un proceso con este periodo');
            }else{
                $request->validate([
                    'asesorempresarial' => 'required',
                    'asesoracademico' => 'required',
                ]);
                $asesorEmpresarial = $request->input('asesorempresarial');
                $asesorAcademico = $request->input('asesoracademico');
                $proceso = new proceso;
                $proceso->IdUsuario = $idUsuario;
                $proceso->IdTipoProceso = $procesos;
                $proceso->IdPeriodo = $periodoExistente->IdPeriodo;
                $proceso->save();
                $idProceso = $proceso->id;
                $relacionAA = new aa_pp;
                $relacionAA->IdAsesor = $asesorAcademico;
                $relacionAA->IdProceso = $idProceso;
                $relacionAA->save();
                $relacionAE = new ae_pp;
                $relacionAE->Idae = $asesorEmpresarial;
                $relacionAE->IdProceso = $idProceso;
                $relacionAE->save();
                return redirect('estancia1/'. $procesos)->with('success','Dado de alta en periodo actual'); 
            }
        }
        return view('estancia1.index')->with('error','error desconocido favor de intentarlo en otro momento');
    }

    public function ver($proces)
    { //*funcional
        $userID = Auth::user()->id;
        $name = ['Estancia I', 'Estancias II', 'Estadía', 'Estadías Nacionales', 'Servicio Social'];
        //!cambiar este numero si se quiere agregar un nuevo proceso y tambien agregar el nombre en $name
        if ($proces > 0 && $proces <= 5) { //comprueba si el numero es de algun proceso del 1...5
            $var = [$proces, $name[$proces - 1]]; //guarda el numero y nombre del proceso
        } else return redirect('inicio');
        $tiposdocumentos = DB::table('tipodoc')->get();
        $documentos = DB::table('documentos')
        ->join('detalledoc','documentos.IdDoc', "=" ,'detalledoc.IdDoc')
        ->join('proceso','proceso.IdProceso', "=", "detalledoc.IdProceso")
        ->where('IdTipoProceso',$proces)
        ->where('IdUsuario',$userID)
        ->get();
        $asesoresEmpresariales = DB::table('ae')->get();
        $asesoresAcademicos = DB::table('aa')->get();
        return view('estancia1', ['proceso' => $var,'documentos' => $tiposdocumentos,'documentacion'=>$documentos,'ae' =>$asesoresEmpresariales,'aa' =>$asesoresAcademicos]);
    }

    //subir documento sin datos carga horaria
    public function subir_carga_horaria_estancia1(Request $request, $name, $proces, $IdTipoDoc){
        $userID = Auth::user()->id;
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
        $periodoExistente = periodo::where('Periodo',$numero)->first();
        $procesoExistente = proceso::where('IdUsuario',$userID)->where('IdTipoProceso',$proces)->where('IdPeriodo',$periodoExistente->IdPeriodo)->first();
        if($procesoExistente){
            $Ndoc = [
                'carga_horaria', 'constancia_derecho', 'carta_responsiva', 'f01', 'f02', 'f03', 'f04', 'f05', 'carta_compromiso', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual',
                'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual'
            ];
            $arrayResult = array();
            try {
                if ($request->hasFile('docs_archivo')) {
                    $archivo = $request->file('docs_archivo');
                    $nombreDoc = $name . $Ndoc[$IdTipoDoc-1] . $proces . '.pdf';
                    $RutaDeGuardado =public_path().'\documentos'; 
                    $archivo->move($RutaDeGuardado, $nombreDoc);
                    $data5 = array('ruta'=> $nombreDoc, 'IdEstado'=> 2,'IdTipoDoc'=>$IdTipoDoc,'Usuario'=>$userID);
                    $response = documentos::requestInsertDoc($data5);
                    if (isset($response["code"]) && $response["code"] == 200) {
                        $arrayResult = array(
                            'Response'  => array(
                                'ok'        => true,
                                'message'   => "Se ha guardado el registro",
                                'code'      => "200",
                            ),
                        );
                    } else {
                        $arrayResult = array(
                            'Response'  => array(
                                'ok'        => false,
                                'message'   => $response['message'],
                                'code'      => $response['code']
                            ),
                        );
                    }
                    //controlador de estatus
                    $data6 = array(
                        'IdDoc'=>  $response['IdDoc'],
                        'IdProceso'=>  $procesoExistente->IdProceso, 
                    );
                    $response_documentos = detalledoc::requestInsertDetailsDocs($data6); 
        
                    if (isset($response_documentos["code"]) && $response_documentos["code"] == 200) {

                    } else {
                        $arrayResult = array(
                            'Response_2'  => array(
                                'ok'        => false,
                                'message'   => $response_documentos['message'],
                                'code'      => $response_documentos['code']
                            ),
                        );
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $arrayResult = array(
                    'Response_3'  => array(
                        'message'   => "Error: " . " - " . "Fallo :v",
                        "code"      => "500"
                    )
                );
            } catch (Exception $ex) {
                $arrayResult = array(
                    'Response_3' => array(
                        'message' => "Error: " . " - " . $ex->getMessage(),
                        "code"    => "500"
                    )
                );
            }
            $msj = json_encode($arrayResult);
            if ($msj == '{"Response":{"ok":true,"message":"Se ha guardado el registro","code":"200"}}') {
                return redirect('estancia1/' . $proces)->with('success', 'Documento agregado');
            } else {
                return redirect('estancia1/' . $proces)->with('errorPDF', 'Hay un error en el nombre de tu pdf'.$msj);
            }
        }else{
            return redirect('estancia1/' . $proces)->with('error', 'Favor de darse de alta en periodo');
        }
    }
    //actualizar documento carga horaria
    public function actualizar_carga_horaria_estancia1(Request $request, $name, $proces, $idDoc)
    { //*funcional
        //!Al subir un documento se actualiza el registro de la tabla documentos
        $Ndoc = [
            'carga_horaria', 'constancia_derecho', 'carta_responsiva', 'f01', 'f02', 'f03', 'f04', 'f05', 'carta_compromiso',
            'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual',
            'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual', 'reporte_mensual'
        ];
        $request->validate([
            $Ndoc[$idDoc - 1] => "required|mimetypes:application/pdf|max:30000"
        ]);
        $arrayResult = array();
        try {
            if ($request->hasFile($Ndoc[$idDoc - 1])) {
                $archivo = $request->file($Ndoc[$idDoc - 1]);
                $nombreAF = $name . $Ndoc[$idDoc - 1] . $proces . $idDoc . '.pdf'; //!ej. 202000052Carga_horaria1
                $archivo->move(public_path() . '/documentos/', $nombreAF);
            }
            switch ($idDoc) {
                case '1':
                    $data5 = array('nombre_c_h'   => $nombreAF, 'estado_c_h' => 1);
                    $response = documentos::requestInsertcargaH($data5);
                    break;
                case '2':
                    $data5 = array('nombre_c_d'   => $nombreAF, 'estado_c_d' => 1);
                    $response = documentos::requestInsertconstanciaD($data5);
                    break;
                case '3':
                    $data5 = array('nombre_c_r'   => $nombreAF, 'estado_c_r' => 1);
                    $response = documentos::requestInsertcartaR($data5);
                    break;
                case '4':
                    $data5 = array('nombre_c_p'   => $nombreAF, 'estado_c_p' => 1);
                    $response = documentos::requestInsertcartaP($data5);
                    break;
                case '5':
                    $data5 = array('nombre'   => $nombreAF, 'estado' => 1);
                    $response = documentos::requestInsertcartaA($data5);
                    break;
                case '6':
                    $data5 = array('nombre_c_r'   => $nombreAF, 'estado_c_r' => 1);
                    $response = documentos::requestInsertCedulaR($data5);
                    break;
                case '7':
                    $data5 = array('nombre_d_p'   => $nombreAF, 'estado_d_p' => 1);
                    $response = documentos::requestInsertDefinicionP($data5);
                    break;
                case '8':
                    $data5 = array('nombre_c_l'   => $nombreAF, 'estado_c_l' => 1);
                    $response = documentos::requestInsertcartaL($data5);
                    break;
                case '9':
                    $data5 = array('nombre_c_c'   => $nombreAF, 'estado_c_c' => 1);
                    $response = documentos::requestInsertcargaC($data5);
                    break;
                case '10':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '11':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '12':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '13':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '14':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '15':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '16':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '17':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '18':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '19':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '20':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '21':
                    $data5 = array('nombre_r_m'   => $nombreAF, 'estado_r_m' => 1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                default:
                    # code...
                    break;
            }

            if (isset($response["code"]) && $response["code"] == 200) {
                $arrayResult = array(
                    'Response'  => array(
                        'ok'        => true,
                        'message'   => "Se ha guardado el registro",
                        'code'      => "200",
                    ),
                );
            } else {
                $arrayResult = array(
                    'Response'  => array(
                        'ok'        => false,
                        'message'   => $response['message'],
                        'code'      => $response['code']
                    ),
                );
            }
            //$NcolBD=['id_c_horaria','id_c_derecho','id_c_responsiva','id_c_presentacion',
            //'id_c_aceptacion','id_c_registro','id_d_proyecto','id_c_liberacion'];
            $carta = documentos::find($request->get('id_docs'));
            switch ($idDoc) {
                case 1:
                    $carta->id_c_horaria = $response['id'];
                    break;
                case 2:
                    $carta->id_c_derecho = $response['id'];
                    break;
                case 3:
                    $carta->id_c_responsiva = $response['id'];
                    break;
                case 4:
                    $carta->id_c_presentacion = $response['id'];
                    break;
                case 5:
                    $carta->id_c_aceptacion = $response['id'];
                    break;
                case 6:
                    $carta->id_c_registro = $response['id'];
                    break;
                case 7:
                    $carta->id_d_proyecto = $response['id'];
                    break;
                case 8:
                    $carta->id_c_liberacion = $response['id'];
                    break;
                case 9:
                    $carta->id_c_compromiso = $response['id'];
                    break;
                case 10:
                    $carta->id_r_mensual = $response['id'];
                    break;
                case 11:
                    $carta->id_r_mensual2 = $response['id'];
                    break;
                case 12:
                    $carta->id_r_mensual3 = $response['id'];
                    break;
                case 13:
                    $carta->id_r_mensual4 = $response['id'];
                    break;
                case 14:
                    $carta->id_r_mensual5 = $response['id'];
                    break;
                case 15:
                    $carta->id_r_mensual6 = $response['id'];
                    break;
                case 16:
                    $carta->id_r_mensual7 = $response['id'];
                    break;
                case 17:
                    $carta->id_r_mensual8 = $response['id'];
                    break;
                case 18:
                    $carta->id_r_mensual9 = $response['id'];
                    break;
                case 19:
                    $carta->id_r_mensual10 = $response['id'];
                    break;
                case 20:
                    $carta->id_r_mensual11 = $response['id'];
                    break;
                case 21:
                    $carta->id_r_mensual12 = $response['id'];
                    break;
                default:
                    # code...
                    break;
            }
            //$carta->id_proceso=1;
            $carta->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            $arrayResult = array(
                'Response'  => array(
                    'message'   => "Error: " . " - " . "Fallo :v",
                    "code"      => "500"
                )
            );
        } catch (Exception $ex) {
            $arrayResult = array(
                'Response' => array(
                    'message' => "Error: " . " - " . $ex->getMessage(),
                    "code"    => "500"
                )
            );
        }
        $msj = json_encode($arrayResult);
        if ($msj == '{"Response":{"ok":true,"message":"Se ha guardado el registro","code":"200"}}') {
            return redirect('estancia1/' . $proces)->with('success', 'Documento agregado');
        } else {
            return redirect('estancia1/' . $proces)->with('errorPDF', 'Hay un error en el nombre de tu pdf');
        }
    }
    //ver observaciones del documento
    public function verObservaciones1_carga_horaria($proces, $idDoc, $id)
    { //*funcional
        $Ntab = [
            'carga_horaria', 'constancia_derecho', 'carta_responsiva', 'carta_presentacion', 'carta_aceptacion',
            'cedula_registro', 'definicion_proyecto', 'carta_liberacion', 'carta_compromiso', 'reporte_mensual', 'reporte_mensual2'
        ];
        $Ncol = [
            'observaciones_c_h', 'observaciones_c_d', 'observaciones_c_r', 'observaciones_c_p', 'observaciones',
            'observaciones_c_r', 'observaciones_d_p', 'observaciones_c_l', 'observaciones_c_c', 'observaciones_r_m', 'observaciones_r_m'
        ];
        $observ = DB::table($Ntab[$idDoc - 1])
            ->select($Ncol[$idDoc - 1] . ' as observacion')
            ->where('id', $id)
            ->get();
        //dd($observ);
        return view('usuario.observaciones_carga_horaria', ['datos' => $observ, 'proceso' => $proces]);
    }

    public function cancelar_documento_alumno(Request $request,$proces, $idDoc){
        $nombreDoc = $request->input('nombreDoc');
        $documento=documentos::find($idDoc);
        $relacionDocumentos=detalledoc::where('IdDoc',$idDoc)->first();
        $documento->delete();
        $relacionDocumentos->delete();
        $path=public_path().'/documentos/'.$nombreDoc;
        if(File::exists($path)){
          File::delete($path);
          return redirect('estancia1/'.$proces)->with('success','Documento Cancelada: '.$nombreDoc);
        }else{
          return redirect('estancia1/'.$proces)->with('error','error cancelando: ' .$nombreDoc. ' Favor de intentarlo mas tarde');
        }
    }
}
