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

        if (!isset($result)) {
            $result = [
                "status" => "404",
                "message" => "Funcionário não encontrado"
            ];
        }

        return response()->json($result);
    }

    public function save(Request $request){
        
        $data = $request->all();
        $result = $this->model->create($data);
        
        $mesage = (!$result)
        ? ["status" => "400", "message" => "Erro na criação de Funcionário"]
        : ["status" => "200", "message" => "Funcionário criado com sucesso", "funcionario" => $result];

        return response()->json($result);
    }

    public function update($id, Request $request){
        $func = $this->model->find($id);

        $data = $request->all();

        $result = $func->update($data);
        $mesage = (!$result)
        ? ["status" => "400", "message" => "Erro na criação de Funcionário"]
        : ["status" => "200", "message" => "Funcionário atualizado com sucesso", "funcionario" => $result];

        return $mesage;
    }

    public function delete($id, Request $request){
        
        $func = $this->model->find($id);
        
        ->delete();

        return response()->json(null);
    }

}
