<?php

namespace App\Http\Controllers;

use App\Models\documentos;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    //
    public function ver() {
        return view('inicio');
    }

    public function redirect(){
        $userID=Auth::user()->id; 
        $userrole=Auth::user()->role; 

        if(!$userID){
            return redirect('/login');
        }else{
            if($userrole=='admin'){
                return redirect('/admin');
            }else{
                return redirect('/inicio');
            }
        }
    }
    public function reiniciarU($id){
        $docf=documentos::find($id);
        $docf->id_proceso=null;
        $docf->save();
        return redirect('alumno_ver_editar')->with('usuarioR','Usuario reiniciado');
    }
}
