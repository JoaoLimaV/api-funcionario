<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $model;  

    public function __construct(Funcionario $func)
    {
        $this->model = $func;
    }

    public function getAll(){
        return response()->json( $this->model::all() );
    }

    public function findById($id){
        $result = $this->model->find($id);

        if(!isset($result)) {
            $result = [
                "status" => "404",
                "mesage" => "Funcionário não encontrado"
            ];
        } 
        return response()->json($result);
    }

    public function save(Request $request){
        
        $data = $request->all();
        $result = $this->model->create($data);
        
        $message = ($result)
        ? ["status" => "200", "message" => "Funcionário criado com sucesso", "data" => $this->model->find($result->id)]
        : ["status" => "400", "message" => "Erro na criação de Funcionário"];

        return response()->json($message);
    }

    public function update($id, Request $request){
        return "Funcion update Users";
    }

    public function delete($id, Request $request){

        return "Funcion update Users";
    }

}
