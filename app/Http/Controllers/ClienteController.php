<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    private $model;  

    public function __construct(Cliente $func)
    {
        $this->model = $func;
    }

    public function getAll(){
        $clientes = $this->model::with('delivery_address.address')->get();
    
        if (!$clientes) {
            return response()->json(['message' => 'Clientes não encontrados'], 404);
        }

        foreach( $clientes as $cliente ) {

            $cliente->makeHidden(['delivery_address']);
            $cliente->makeHidden(['password']);

            $delivery_address = []; 
        
            foreach ( $cliente->delivery_address as $adresses) {
                $data = array(
                    'cep' => $adresses->address->cep,
                    'number' => $adresses->number,
                    'complement' => $adresses->complement,
                    'reference' => $adresses->reference,
                    'street' => $adresses->address->street,
                    'city' => $adresses->address->city,
                    'district' => $adresses->address->district,
                    'state' => $adresses->address->state,
                    'created_at' => $adresses->created_at,
                    'updated_at' => $adresses->updated_at
                );

                $delivery_address[] = $data;
            }

            $cliente->adresses = $delivery_address;
        }

        return response()->json($clientes);
    }

    public function findById($id){
        $cliente = $this->model::with('delivery_address.address')->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->makeHidden(['password']);
        $cliente->makeHidden(['delivery_address']);

        $delivery_address = []; 
        foreach ( $cliente->delivery_address as $adresses) {
            $data = array(
                'cep' => $adresses->address->cep,
                'number' => $adresses->number,
                'complement' => $adresses->complement,
                'reference' => $adresses->reference,
                'street' => $adresses->address->street,
                'city' => $adresses->address->city,
                'district' => $adresses->address->district,
                'state' => $adresses->address->state,
                'created_at' => $adresses->created_at,
                'updated_at' => $adresses->updated_at
            );

            $delivery_address[] = $data;
        }

        $cliente->adresses = $delivery_address;
            
        return response()->json($cliente);

    }

    public function getResume(){
        $selectedFields = Cliente::select('id', 'identify_document', 'name', 'email', 'image_path', 'status')->get();

        if ($selectedFields->isEmpty()) {
            return response()->json(['message' => 'Clientes não encontrados'], 404);
        }

        return response()->json($selectedFields);
    }
}

