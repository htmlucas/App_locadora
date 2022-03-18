<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        
        $credenciais = $request->all(['email','password']);

        //autenticacao email e senha
        $token = auth('api')->attempt($credenciais);

        if($token){ #usuario autenticado
            return response()->json(['token' => $token]);
        }else{ //erro de usuario ou senha
            return response()->json(['erro' => 'usuario ou senha invalido'],403); #403 = forbiden = proibido (login invalido)
        }

            //retornar um jwt
        return 'login';
    }
    public function logout(){
        return 'logout';
    }
    public function refresh(){
        return 'refresh';
    }
    public function me(){
        return 'me';
    }
}
