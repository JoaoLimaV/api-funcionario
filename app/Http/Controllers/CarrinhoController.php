<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;

class CarrinhoController extends Controller
{
    private $model;  

    public function __construct(Carrinho $func)
    {
        $this->model = $func;
    }

    public function getAll(){
        $result = $this->model::with('sale_item.product')->where('status', 0)->get();

        if (!$result->isEmpty()) {

            $result = $result->values();

            foreach ($result as $sale) {
                $sale->makeHidden([
                    'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                    'delivery_type', 'delivery_price', 'obs', 'payment_type', 'payment_date',
                    'payment_discount', 'installment_payment', 'sale_item'
                ]);

                $cart_items = []; 

                foreach ( $sale->sale_item as $item) {
                    $data = array(
                        'id' => $item->id,
                        'product_id' => $item->product_id, 
                        'amount' => $item->amount,
                        'item_discount' => $item->discount, 
                        'unity_price' => $item->unity_price, 
                        'item_total' => $item->total,
                        'created_at' => $item->created_at, 
                        'updated_at' => $item->updated_at
                    );

                    $cart_items[] = $data;
                }

                $sale->cart_items = $cart_items;
            }
            return response()->json($result);
        }
        return response()->json(['message' => 'Nenhum carrinho encontrado'], 404);
    }

    public function findByCustomerId($id)
    {
        // Use o método first() para encontrar o carrinho
        $result = $this->model::with('sale_item.product')->where('customer_id', $id)->where('status', 0)->first();

        if ($result) {
            // Oculte os campos não desejados
            $result->makeHidden([
                'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                'delivery_type', 'delivery_price', 'obs', 'payment_type', 'payment_date',
                'payment_discount', 'installment_payment', 'sale_item'
            ]);

            $cart_items = [];

            // Acesse a relação sale_item diretamente
            foreach ($result->sale_item as $item) {
                $data = [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'amount' => $item->amount,
                    'item_discount' => $item->discount,
                    'unity_price' => $item->unity_price,
                    'item_total' => $item->total,
                ];

                $cart_items[] = $data;
            }

            
            $result->cart_items = $cart_items;

            return response()->json($result);
        }

        return response()->json(['message' => 'Nenhum carrinho encontrado para este cliente'], 404);
    }

    public function addItem(Request $request, $id)
    {
        $data = $request->all();

        try {
            // Verifique se já existe um sale com status 0 para o cliente
            $sale = $this->model::where('customer_id', $id)->where('status', 0)->first();

            // Se não existir, crie um novo sale com status 0 para o cliente
            if (!$sale) {
                $sale = $this->model::create([
                    'customer_id' => $id,
                    'status' => 0,
                    // Outros campos do sale, se houver
                ]);
            }

            // Crie o sale_item associado ao sale
            $novoSaleItem = $sale->sale_item()->create($data);

            if ($novoSaleItem) {
                $message = [
                    'message' => 'Produto adicionado com sucesso'
                ];

                return response()->json($message, 201);
            } else {
                return response()->json(['message' => 'Erro ao adicionar ao carrinho'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro interno'], 500);
        }
    }

    public function updateItem(Request $request, $id)
    {
        $data = $request->all();

        try {
            // Encontre o carrinho pelo ID do sale_item
            $carrinho = $this->model::whereHas('sale_item', function ($query) use ($id) {
                $query->where('id', $id);
            })->first();

            if ($carrinho) {
                // Encontre o sale_item específico dentro do carrinho
                $saleItem = $carrinho->sale_item->where('id', $id)->first();

                if ($saleItem) {
                    // Atualize os campos do sale_item com os dados fornecidos no corpo da requisição
                    $saleItem->update($data);

                    $message = [
                        'message' => 'Sale_item atualizado com sucesso'
                    ];

                    return response()->json($message, 200);
                } else {
                    return response()->json(['message' => 'Cart_item não encontrado no carrinho'], 404);
                }
            } else {
                return response()->json(['message' => 'carrinho não encontrado para este cart_item'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro interno'], 500);
        }
    }
}

