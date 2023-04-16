<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    //login, caso tente acessar uma rota sem estar autenticado será redirecionado pro login
    public function login()
    {
        //retorna um erro de não autenticado
        return response()->json([
            'error' => 'Unauthorized',
        ], 401);
    }

    //autentica o usuário
    public function auth(Request $request)
    {
        //pega as crendeciais passada
        $credentials = $request->only('email', 'password');

        //verifica as credenciais
        if (Auth::attempt($credentials)) {
            //gera um token de autenticação
            $token = $request->user()->createToken('API Token')->accessToken;
            //retorna o token
            return response()->json([
                'token' => $token,
            ]);
        }
            //caso o usuário não seja encontrado retorna um erro
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);

    }


}
