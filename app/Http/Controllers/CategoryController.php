<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //lista todos
    public function index()
    {
        $categ = Category::all();
        $data = count($categ) > 0 ? $categ : 'Nenhum dado encontrado';
        return response()->json(['categorys' => $data]);
    }

    //salva no banco
    public function store(Request $request)
    {
        //verifica os campos
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            'status' => 'required'
        ]);

        //verifica se tem erro
        if ($validator->fails()) {
            return response()->json(['message' => 'Verifique os dados']);
        }

        $category = new Category();

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => "Cadastrado com sucesso"]);
    }

    //atualiza
    public function edit(Request $request, $id)
    {
        $categ = Category::find($id);

        //verifica se a categoria não foi encontrado
        if (empty($vehicle)) {
            return response()->json(['message' => 'Não encontrado']);
        }

        $categ->name = $request->name;
        $categ->status = $request->status;

        $categ->save();

        return response()->json(['message' => "Atualizado com sucesso"]);
    }

    //deleta
    public function destroy($id)
    {
        $categ = Category::find($id);
        //verifica se a categoria não foi encontrado
        if (empty($vehicle)) {
            return response()->json(['message' => 'Não encontrado']);
        }

        //deleta
        $categ->delete();

        return response()->json(['message' => "Deletado com sucesso"]);
    }
}
