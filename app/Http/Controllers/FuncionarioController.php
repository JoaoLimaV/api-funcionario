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
        $result = $this->model::all();

        if( !$result ) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        } 

        return response()->json($result);

    }

    public function findById($id){
        $result = $this->model->find($id);
        
        if(!$result) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        } 

        $message = $this->model->find($result->id);
        return response()->json($message);
    }

    public function save(Request $request){

        $this->validate($request, [
            'name'            => 'required',
            "telefone"        => "required|telefone|unique:funcionario|max:11|min:10",
            "cpf"             => "required|cpf|unique:funcionario|max:11|min:10",
            "rg"              => "",
            "endereco"        => "required",
            "data_nascimento" => "required|max:10|min:10",
            "cargo"           => "required",
            "data_admissao"   => "required|max:10|min:10",
            "data_demissao"   => "",
            'email'           => 'required|email|unique:funcionario',
            "sexo"            => 'required'
        ]);

        $data = $request->all();

        $result = $this->model->create($data);
        
        $message = (!$result)
        ? ["status" => "400", "message" => "Erro na criação de funcionário"]
        : ["status" => "200", "message" => "Funcionário criado com sucesso", "employee" => $this->model->find($result->id)];

        return response()->json($message);
    }


    public function update($id, Request $request){
        $data = $request->all();

        if( !$data ) {
            return response()->json(['message' => 'Dados inválidos foram enviados. Verifique os campos enviados.'], 400 );
        } 

        $result = $this->model->find($id);

        if( !$result ) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        $this->validate($request, [
            "telefone"        => "unique:funcionario|max:11|min:10",
            "cpf"             => "unique:funcionario|max:11|min:10",
            'email'           => 'unique:funcionario|min:1'
        ]);

        $result->update($data);

        $message = [
            "message" => "Funcionário atualizado com sucesso", 
            "employee" => $this->model->find($result->id)
        ];

        return response()->json($message);
    }

    public function delete($id){  
        $result = $this->model->find($id);

        if( !$result ) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        $result->delete();
        
        $message = ["message" => "Funcionário deletado com sucesso"];
        
        return response()->json($message);
    }
}

