<?php

namespace App\Http\Controllers;


use App\Models\documentos;
use App\Models\tipodoc;
use App\Models\detalledoc;
use App\Models\estadodoc;
use App\Models\proceso;
use App\Mpdels\periodo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use phpDocumentor\Reflection\Location;
class Estancia1Controller extends Controller
{
    //
    public function ver($proces){//*funcional
        $userID=Auth::user()->id;
        $name=['Estancia I','Estancias II','Estadía','Estadías Nacionales','Servicio Social'];
        //!cambiar este numero si se quiere agregar un nuevo proceso y tambien agregar el nombre en $name
        if($proces>0 && $proces<=5){//comprueba si el numero es de algun proceso del 1...5
            $var=[$proces,$name[$proces-1]];//guarda el numero y nombre del proceso
        }else return redirect('inicio');
        $users = DB::table('users')
        ->join('users','proceso.idUsuario','=','users.id')
        ->join('tipoproceso','proceso.idTipoProceso','=','tipoproceso.idTipoProceso')
        ->join('periodo','proceso.idPeriodo','=','periodo.idPeriodo')
        ->join('aa','proceso.idAA','=','aa.idAsesor')
        ->join('ae','proceso.idAE','=','ae.idAE')
        ->join('carrera','proceso.idCarrera','=','carrera.idCarrera')
        ->join('aa_pp','proceso.idAsesor','=','aa_pp.idProceso')
        ->join('ae_pp','proceso.idAE','=','ae_pp.idProceso')
        ->join('ae_emp','empresa.idEmp','=','ae_emp.idEmp')
        ->select('')
        ->where('users.id',$userID)
        ->where('alumno.id_procesos',$proces)
        ->get();

        $u   = ['user' => $users];
        $datos = Arr::collapse([$u,$datosCF]);

        $documentos=DB::table('users')
        ->join('detalledoc','proceso.idProceso','=','detalledoc.idProceso')
        ->join('documentos','tipodoc.idTipoDoc','=','documentos.idTipoDoc')
        ->where('users.id',$userID)
        ->where('id_proceso',$proces) //cambio 1 para arreglar error de duplicacion de datos en estancia y estadia
        ->get();

        $carta_co =['carta_compromiso'=> $carta_compromiso];
        $reporte_m =['reporte_mensual'=> $reporte_mensual];
        $reporte_m2 =['reporte_mensual2'=> $reporte_mensual2];
        $reporte_m3 =['reporte_mensual3'=> $reporte_mensual3];
        $reporte_m4 =['reporte_mensual4'=> $reporte_mensual4];
        $reporte_m5 =['reporte_mensual5'=> $reporte_mensual5];
        $reporte_m6 =['reporte_mensual6'=> $reporte_mensual6];
        $reporte_m7 =['reporte_mensual7'=> $reporte_mensual7];
        $reporte_m8 =['reporte_mensual8'=> $reporte_mensual8];
        $reporte_m9 =['reporte_mensual9'=> $reporte_mensual9];
        $reporte_m10 =['reporte_mensual10'=> $reporte_mensual10];
        $reporte_m11 =['reporte_mensual11'=> $reporte_mensual11];
        $reporte_m12 =['reporte_mensual12'=> $reporte_mensual12];
        $datos14 = Arr::collapse([$carta_co,$reporte_m]);

        return view('estancia1',['datos'=>$datos,'definicionP'=>$datos1,
        'documentos'=>$datos2,'etapas'=>$datos3,'carta_aceptacion'=>$datos4,
        'carta'=>$datos5,'carta1'=>$datos6,'proceso'=>$var,'noActivar'=>$noActivar,'documentos2'=>$datos14,'botones'=>$botones,'reporte_mensual2'=>$reporte_m2,
        'reporte_mensual3'=>$reporte_m3,'reporte_mensual4'=>$reporte_m4,'reporte_mensual5'=>$reporte_m5,'reporte_mensual6'=>$reporte_m6,'reporte_mensual7'=>$reporte_m7,
        'reporte_mensual8'=>$reporte_m8,'reporte_mensual9'=>$reporte_m9,'reporte_mensual10'=>$reporte_m10,'reporte_mensual11'=>$reporte_m11,'reporte_mensual12'=>$reporte_m12]);
    }

    //subir documento sin datos carga horaria
    public function subir_carga_horaria_estancia1(Request $request, $name,$proces,$idDoc){//*funcional
    //!al subir el primer documento se crea el registro de la tabla documeentos
        $Ndoc=['carga_horaria','constancia_derecho','carta_responsiva','f01','f02','f03','f04','f05','carta_compromiso','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual',
        'reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual'];
        $request->validate([
            $Ndoc[$idDoc-1]=> "required|mimetypes:application/pdf|max:30000"
        ]);
        $arrayResult = array();

        $Ncol=[];
        try{
            if($request->hasFile($Ndoc[$idDoc-1])){
                $archivo=$request->file($Ndoc[$idDoc-1]);
                //$nombreA=$archivo->getClientOriginalName();
                $nombreAF=$name.$Ndoc[$idDoc-1].$proces.'.pdf';//!ej. 202000052Carga_horaria1
                $archivo->move(public_path().'/documentos/',$nombreAF);

            }
            switch ($idDoc) {
                case '1':
                    $data5 = array('nombre_c_h'   => $nombreAF,'estado_c_h'=> 1);
                    $response = documentos::requestInsertcargaH($data5);
                    break;
                case '2':
                    $data5 = array('nombre_c_d'   => $nombreAF,'estado_c_d'=> 1);
                    $response = documentos::requestInsertconstanciaD($data5);
                    break;
                case '3':
                    $data5 = array('nombre_c_r'   => $nombreAF,'estado_c_r'=> 1);
                    $response = documentos::requestInsertcartaR($data5);
                    break;
                case '4':
                    $data5 = array('nombre_c_p'   => $nombreAF,'estado_c_p'=> 1);
                    $response = documentos::requestInsertcartaP($data5);
                    break;
                case '5':
                    $data5 = array('nombre'   => $nombreAF,'estado'=> 1);
                    $response = documentos::requestInsertcartaA($data5);
                    break;
                case '6':
                    $data5 = array('nombre_c_r'   => $nombreAF,'estado_c_r'=> 1);
                    $response = documentos::requestInsertCedulaR($data5);
                    break;
                case '7':
                    $data5 = array('nombre_d_p'   => $nombreAF,'estado_d_p'=> 1);
                    $response = documentos::requestInsertDefinicionP($data5);
                    break;
                case '8':
                    $data5 = array('nombre_c_l'   => $nombreAF,'estado_c_l'=> 1);
                    $response = documentos::requestInsertcartaL($data5);
                    break;
                case '9':
                    $data5 = array('nombre_c_c' => $nombreAF,'estado_c_c'=> 1);
                    $response = documentos::requestInsertcargaC($data5);
                    break;
                case '10':
                    $data5 = array('nombre_r_m' => $nombreAF,'estado_r_m'=> 1);
                    $response = documentos::requestInsertcartarp($data5);
                    break;
                case '11':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '12':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '13':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '14':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '15':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '16':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '17':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '18':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '19':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '20':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '21':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
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
            $NcolBD=['id_c_horaria','id_c_derecho','id_c_responsiva','id_c_presentacion',
            'id_c_aceptacion','id_c_registro','id_d_proyecto','id_c_liberacion','id_c_compromiso','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual','id_r_mensual'];

            //controlador de estatus
           borrar $date = Carbon::now()->format('m');
            if ($date=1 || $date=2 || $date=3 || $date=4 ){
                    $estatus3 = 'enero-abril';
            } if ( $date=5 || $date=6 || $date=7 || $date=8 ) {
                    $estatus3 = 'mayo-agosto';
            } if ($date=9 || $date=10 || $date=11 || $date=12){
                    $estatus3 = 'septiembre-diciembre';
            }
            $data6 = array(
                $NcolBD[$idDoc-1]     =>  $response['id'],
                'id_proceso'             =>  $proces,//!Es donde pasa el # de proceso y periodo de clase
                'estatus'          =>  $estatus3
            );
            $response_documentos = documentos::requestInsertDoc($data6);//!aqui se crea el registro de documentos

            if (isset($response_documentos["code"]) && $response_documentos["code"] == 200) {
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
                        'message'   => $response_documentos['message'],
                        'code'      => $response_documentos['code']
                    ),
                );
            }

            $data7 = array(
                'id_usuario'    => Auth::user()->id,
                'id_documentos' => $response_documentos['id']
            );
            //!Crear el registro de respuests_doc
            $response_respuesta = detalle_doc::requestInsertRespuesta($data7);


        } catch(\Illuminate\Database\QueryException $ex) {
            $arrayResult = array(
                'Response'  => array(
                    'message'   => "Error: " . " - " . "Fallo :v",
                    "code"      => "500"
                )
            );
        } catch( Exception $ex ){
            $arrayResult = array(
            'Response' => array(
                'message' => "Error: " . " - " . $ex->getMessage(),
                "code"    => "500"
            )
            );
        }
        $msj= json_encode($arrayResult);
        if($msj=='{"Response":{"ok":true,"message":"Se ha guardado el registro","code":"200"}}'){
            return redirect('estancia1/'.$proces)->with('success','Documento agregado');
        }else
        {
            return redirect('estancia1/'.$proces)->with('errorPDF','Hay un error en el nombre de tu pdf 2');
        }
    }

    //actualizar documento carga horaria
    public function actualizar_carga_horaria_estancia1(Request $request, $name,$proces,$idDoc){//*funcional
        //!Al subir un documento se actualiza el registro de la tabla documentos
        $Ndoc=['carga_horaria','constancia_derecho','carta_responsiva','f01','f02','f03','f04','f05','carta_compromiso',
        'reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual',
        'reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual','reporte_mensual'];
        $request->validate([
            $Ndoc[$idDoc-1]=> "required|mimetypes:application/pdf|max:30000"
        ]);
        $arrayResult = array();
        try{
            if($request->hasFile($Ndoc[$idDoc-1])){
                $archivo=$request->file($Ndoc[$idDoc-1]);
                $nombreAF=$name.$Ndoc[$idDoc-1].$proces.$idDoc.'.pdf';//!ej. 202000052Carga_horaria1
                $archivo->move(public_path().'/documentos/',$nombreAF);

            }
            switch ($idDoc) {
                case '1':
                    $data5 = array('nombre_c_h'   => $nombreAF,'estado_c_h'=> 1);
                    $response = documentos::requestInsertcargaH($data5);
                    break;
                case '2':
                    $data5 = array('nombre_c_d'   => $nombreAF,'estado_c_d'=> 1);
                    $response = documentos::requestInsertconstanciaD($data5);
                    break;
                case '3':
                    $data5 = array('nombre_c_r'   => $nombreAF,'estado_c_r'=> 1);
                    $response = documentos::requestInsertcartaR($data5);
                    break;
                case '4':
                    $data5 = array('nombre_c_p'   => $nombreAF,'estado_c_p'=> 1);
                    $response = documentos::requestInsertcartaP($data5);
                    break;
                case '5':
                    $data5 = array('nombre'   => $nombreAF,'estado'=> 1);
                    $response = documentos::requestInsertcartaA($data5);
                    break;
                case '6':
                    $data5 = array('nombre_c_r'   => $nombreAF,'estado_c_r'=> 1);
                    $response = documentos::requestInsertCedulaR($data5);
                    break;
                case '7':
                    $data5 = array('nombre_d_p'   => $nombreAF,'estado_d_p'=> 1);
                    $response = documentos::requestInsertDefinicionP($data5);
                    break;
                case '8':
                    $data5 = array('nombre_c_l'   => $nombreAF,'estado_c_l'=> 1);
                    $response = documentos::requestInsertcartaL($data5);
                    break;
                case '9':
                    $data5 = array('nombre_c_c'   =>$nombreAF,'estado_c_c'=> 1);
                    $response = documentos::requestInsertcargaC($data5);
                    break;
                case '10':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '11':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '12':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '13':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '14':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '15':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '16':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '17':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '18':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '19':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '20':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
                    $response = documentos::requestInsertcargarp($data5);
                    break;
                case '21':
                    $data5 = array('nombre_r_m'   =>$nombreAF,'estado_r_m' =>1);
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
            $carta=documentos::find($request->get('id_docs'));
            switch ($idDoc) {
                case 1:$carta->id_c_horaria=$response['id'];
                    break;
                case 2:$carta->id_c_derecho=$response['id'];
                    break;
                case 3:$carta->id_c_responsiva=$response['id'];
                    break;
                case 4:$carta->id_c_presentacion=$response['id'];
                    break;
                case 5:$carta->id_c_aceptacion=$response['id'];
                    break;
                case 6:$carta->id_c_registro=$response['id'];
                    break;
                case 7:$carta->id_d_proyecto=$response['id'];
                    break;
                case 8:$carta->id_c_liberacion=$response['id'];
                    break;
                case 9:$carta->id_c_compromiso=$response['id'];
                    break;
                case 10:$carta->id_r_mensual=$response['id'];
                    break;
                case 11:$carta->id_r_mensual2=$response['id'];
                    break;
                case 12:$carta->id_r_mensual3=$response['id'];
                    break;
                case 13:$carta->id_r_mensual4=$response['id'];
                    break;
                case 14:$carta->id_r_mensual5=$response['id'];
                    break;
                case 15:$carta->id_r_mensual6=$response['id'];
                    break;
                case 16:$carta->id_r_mensual7=$response['id'];
                    break;
                case 17:$carta->id_r_mensual8=$response['id'];
                    break;
                case 18:$carta->id_r_mensual9=$response['id'];
                    break;
                case 19:$carta->id_r_mensual10=$response['id'];
                    break;
                case 20:$carta->id_r_mensual11=$response['id'];
                    break;
                case 21:$carta->id_r_mensual12=$response['id'];
                    break;
                default:
                    # code...
                    break;
            }
            //$carta->id_proceso=1;
            $carta->save();


        } catch(\Illuminate\Database\QueryException $ex) {
            $arrayResult = array(
                'Response'  => array(
                    'message'   => "Error: " . " - " . "Fallo :v",
                    "code"      => "500"
                )
            );
        } catch( Exception $ex ){
            $arrayResult = array(
            'Response' => array(
                'message' => "Error: " . " - " . $ex->getMessage(),
                "code"    => "500"
            )
            );
        }
        $msj= json_encode($arrayResult);
        if($msj=='{"Response":{"ok":true,"message":"Se ha guardado el registro","code":"200"}}'){
            return redirect('estancia1/'.$proces)->with('success','Documento agregado');
        }else
        {
            return redirect('estancia1/'.$proces)->with('errorPDF','Hay un error en el nombre de tu pdf');
        }
    }
    //ver observaciones del documento
    public function verObservaciones1_carga_horaria($proces,$idDoc,$id){//*funcional
        $Ntab=['carga_horaria','constancia_derecho','carta_responsiva','carta_presentacion','carta_aceptacion',
        'cedula_registro','definicion_proyecto','carta_liberacion','carta_compromiso','reporte_mensual','reporte_mensual2'];
        $Ncol=['observaciones_c_h','observaciones_c_d','observaciones_c_r','observaciones_c_p','observaciones',
        'observaciones_c_r','observaciones_d_p','observaciones_c_l','observaciones_c_c','observaciones_r_m','observaciones_r_m'];
        $observ=DB::table($Ntab[$idDoc-1])
        ->select($Ncol[$idDoc-1].' as observacion')
        ->where('id',$id)
        ->get();
        //dd($observ);
        return view('usuario.observaciones_carga_horaria',['datos'=>$observ,'proceso'=>$proces]);
    }
}
