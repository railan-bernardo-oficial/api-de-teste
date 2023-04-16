<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    //lista
    public function index()
    {
        //lista todos os registro
        $vehicles = Vehicles::all();
        //verifica se tem registro
        $data = count($vehicles) > 0 ? $vehicles : 'Nenhum dado encontrado';

        return response()->json(['vehicles'=> $data]);
    }

    //salvar
    public function store(Request $request)
    {
        //valida os campos
        $validator = Validator::make($request->all(),[
            "category_id"=>"required",
            "name"=>"required",
            "brand"=>"required",
            "version"=>"required",
            "cover"=>"required",
            "year"=>"required",
            "price"=>"required",
            "description"=>"required",
            "status"=>"required",
        ]);

        //verifica se tem erro
        if($validator->fails()){
            return response()->json(['message'=> 'Verifique os dados']);
        }

        $vehicle = new Vehicles();

        $vehicle->category_id = $request->category_id;
        $vehicle->name = $request->name;
        $vehicle->brand = $request->brand;
        $vehicle->version = $request->version;
        $vehicle->year = $request->year;
        $vehicle->price = number_format(str_replace(['.', ','], '', $request->price), 2, '.', '');
        $vehicle->description = $request->description;
        $vehicle->status = $request->status;

        //realiza o upload da imagem
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $image = $request->file('cover');
            $file = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/veiculos');
            $image->move($destinationPath, $file);
            $vehicle->cover = $file;
        }

        //verifica se foi salvo no banco
        if(!$vehicle->save()){
            return response()->json(['message'=> 'Erro ao cadastrar']);
        }

        return response()->json(['message'=> 'Cadastrado com sucesso']);
    }


    //update
    public function edit(Request $request, $id)
    {
        //valida os campos
        $validator = Validator::make($request->all(),[
            "category_id"=>"required",
            "name"=>"required",
            "brand"=>"required",
            "version"=>"required",
            "cover"=>"required",
            "year"=>"required",
            "price"=>"required",
            "description"=>"required",
            "status"=>"required",
        ]);

        //verifica se tem erro
        if($validator->fails()){
            return response()->json(['message'=> 'Verifique os dados']);
        }

        //busca o modelo
        $vehicle = Vehicles::find($id);
        //verifica se o modelo não foi encontrado
        if(empty($vehicle)){
            return response()->json(['message'=> 'Não encontrado']);
        }

        $vehicle->category_id = $request->category_id;
        $vehicle->name = $request->name;
        $vehicle->brand = $request->brand;
        $vehicle->version = $request->version;
        $vehicle->year = $request->year;
        $vehicle->price = number_format(str_replace(['.', ','], '', $request->price), 2, '.', '');
        $vehicle->description = $request->description;
        $vehicle->status = $request->status;

        //realiza o upload da imagem
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            //verifica se existe a imagem se existe deleta a antiga
            if(File::exists('uploads/veiculos/'.$vehicle->cover)){
                File::delete('uploads/veiculos/'.$vehicle->cover);
            }
            $image = $request->file('cover');
            $file = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/veiculos');
            $image->move($destinationPath, $file);
            $vehicle->cover = $file;
        }

        //verifica se foi salvo no banco
        if(!$vehicle->save()){
            return response()->json(['message'=> 'Erro ao atualizar']);
        }

        return response()->json(['message'=> 'Atualizado com sucesso']);
    }

    //delete
    public function destroy($id)
    {
        //busca pelo modelo
        $vehicle = Vehicles::find($id);
        //verifica se não econtrou o modelo
        if(empty($vehicle)){
            return response()->json(['message'=> 'Não encontrado']);
        }
        //deleta a imagem antes de excluir
        if(File::exists('uploads/veiculos/'.$vehicle->cover)){
            File::delete('uploads/veiculos/'.$vehicle->cover);
        }
        //deleta modelo
        $vehicle->delete();

        return response()->json(['message'=> 'Deletado com sucesso']);
    }
}
