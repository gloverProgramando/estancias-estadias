<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create() {

        return view('auth.register');
    }

    public function store() {

        $this->validate(request(), [
            'name' => 'required',
            'IdTipoUsu'  => 'required',
            'email' => 'required',
            'password' => 'required',
            'Nombre' => 'required',
            'Matricula' => 'required'
        ]);
        
        $user = User::create(request(['name', 'IdTipoUsu', 'email', 'password','Nombre','Matricula']));

        if (auth()->login($user) == 1 || auth()->login($user) == '1') {
            return view('admin.index');
        } else {
            return redirect()->to('/usuarios');
        }
    }
    public function registrar(Request $request) {

        $this->validate(request(), [
            'name' => 'required',
            'IdTipoUsu'  => 'required',
            'email' => 'required',
            'password' => 'required',
            'Nombre' => 'required',
            'Matricula' => 'required'
        ]);
        User::create(request(['name', 'IdTipoUsu', 'email', 'password','Nombre','Matricula']));

        return redirect()->to('/datatable_user')->with('success','Usuario agregado');

    }
}
