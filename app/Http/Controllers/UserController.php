<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //lista
    public function index()
    {
        $users = User::all();
        //verifica se tem registro
        $data = count($users) > 0 ? $users : 'Nenhum dado encontrado';
        //retorna uma lista de usuários em json
        return response()->json(["users" => $data]);
    }

    //salvar
    public function store(Request $request)
    {

        //verifica os campos
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required"
        ]);

        //verifica se tem erro
        if ($validator->fails()) {
            return response()->json(["error" => "Verifique os dados"], 422);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        //gera o token de autenticação
        $token = $user->createToken($request->name)->accessToken;

        return response()->json(["token" => $token], 200);
    }

    //editar
    public function edit(Request $request, $id)
    {
        //busca pelo o usuário
        $user = User::find($id);

        //verifica se o usuário não foi encontrado
        if (empty($vehicle)) {
            return response()->json(['message' => 'Não encontrado']);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        //retorna mensagem de sucesso
        return response()->json(["message" => "Usuário atualizado"]);
    }

    //deletar
    public function destroy($id)
    {
        //busca o usuário
        $user = User::find($id);
        //verifica se o usuário não foi encontrado
        if (empty($user)) {
            return response()->json(['message' => 'Não encontrado']);
        }
        //deleta o usuário
        $user->delete();

        return response()->json(["message" => "Deletado com sucesso"]);
    }
}
