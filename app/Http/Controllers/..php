<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatchAllController extends Controller
{
    public function index(Request $request)
    {
        // Aqui você pode retornar uma resposta 404 ou qualquer outra resposta de erro
        $response = [
            "error" => "Rota não encontrada. Consulte a documentação no GitHub para rotas válidas.",
            "link_documentation" => "https://github.com/seu-usuario/seu-repositorio"
        ];

        return response()->json($response, 404);
    }
}