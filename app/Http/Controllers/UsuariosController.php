<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use App\Models\User;
use App\Models\Users;
use App\Models\usuarios;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
class UsuariosController extends Controller
{
    public function create() {;
    }
    //eliminar usuario
    public function eliminarUsuario($id){
        Users::find($id)->delete();
        return redirect('usuarios')->with('eliminar','Usuario eliminado');
    }

     //eliminar usuario COMPLETO
     public function eliminarUsuarioC($id){
        DB::table('users')->where('id',$id)->delete();
        return redirect('usuarios')->with('eliminarC','Usuario eliminado Completamente');
    }
    //restaurar usuario
    public function restaurarUsuario($id){
        Users::withTrashed()->find($id)->restore();
        return redirect('usuarios')->with('restaurar','Usuario restaurado');
    }
    public function buscarUsuario(Request $request){
        $texto   =trim($request->get('texto'));

        $users = DB::table('users')
        ->where('users.name','LIKE','%'.$texto.'%')
        ->orWhere('users.email','LIKE','%'.$texto.'%')
        ->orWhere('users.role','LIKE','%'.$texto.'%')
        ->orWhere('users.id','LIKE','%'.$texto.'%')
        ->get();

       

        $respuestas = DB::table('users')
        ->join('respuesta', 'users.id', '=', 'respuesta.id_usuario')
        ->join('formulario', 'respuesta.id_formulario', '=', 'formulario.id')
        ->join('alumno', 'formulario.id_alumno', '=', 'alumno.id')
        ->join('procesos', 'procesos.id_procesos', '=', 'alumno.id_procesos')
        ->join('carreras', 'carreras.id_carrera', '=', 'alumno.id_carrera')

        ->orderBy('users.id','ASC')
        ->get();

        $u   = ['users' => $users];
        $r   = ['respuestas' => $respuestas];
        $datos = Arr::collapse([$u,$r]);

        return view('nombres.buscar_usuario',['texto'=>$texto,'datos'=>$datos]);
    }

    public function buscarUsuarioDatos(Request $request){
        
    }

    public function ver(){
        $tiposUsuarios = DB::table('tipousuario')->get();
        return view('admin.agregar_usuario',['tipousuario'=>$tiposUsuarios]);
    }
    public function ver_datos_usuario($id){
        $datos=DB::table('users')->where('id',$id)->get();
        return view('admin.editar_datos_usuario',['datos'=>$datos]);
    }

    public function editar_datos_usuario($id){
        $this->validate(request(), [
            'name' => 'integer',
            'email' => 'email',
            'password' => 'required',
            'Nombre' => 'string',
            'Matricula' => 'string'

            
        ]);
        $user = User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');
        $user->Nombre = request('Nombre');
        $user->Matricula = request('Matricula');
        $user->save();
        return redirect()->to('/datatable_user')->with('success','Datos cambiados');
    }

    public function armar(){
        
    }
}
