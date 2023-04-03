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
            'name' => 'required|integer',
            'tole'  => 'required|integer',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        
        $user = User::create(request(['name', 'IdTipoUsu', 'email', 'password']));

        if (auth()->login($user) == 1 || auth()->login($user) == '1') {
            return view('admin.index');
        } else {
            return redirect()->to('/usuarios');
        }
    }
    public function registrar(Request $request) {

        $this->validate(request(), [
            'name' => 'required',
            'IdTipoUsu'  => 'required|integer',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        User::create(request(['name', 'IdTipoUsu', 'email', 'password']));

        return redirect()->to('/datatable_user')->with('success','Usuario agregado');

    }
}
