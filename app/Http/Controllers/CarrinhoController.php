<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\ItemCarrinho;
use App\Mail\EmailController;

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
                ]);
            }

            // Verifique se já existe um sale_item com o mesmo product_id no carrinho
            $existingSaleItem = $sale->sale_item->where('product_id', $data['product_id'])->first();

            if ($existingSaleItem) {
                // Atualize os campos do sale_item existente com os dados fornecidos no corpo da requisição
                $existingSaleItem->update($data);

                $message = [
                    'message' => 'Produto atualizado com sucesso no carrinho'
                ];

                return response()->json($message, 200);
            } else {
                // Crie um novo sale_item associado ao sale
                $novoSaleItem = $sale->sale_item()->create($data);

                if ($novoSaleItem) {
                    $message = [
                        'message' => 'Produto adicionado com sucesso no carrinho'
                    ];

                    return response()->json($message, 201);
                } else {
                    return response()->json(['message' => 'Erro ao adicionar ao carrinho'], 400);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro interno'], 500);
        }
    }

    public function deleteItem($id){

        $result = ItemCarrinho::find($id);

        if( !$result ) {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }

        $result->delete();
        
        $message = ['message' => 'Item deletado com sucesso'];
        
        return response()->json($message);
    }

    

    public function toSale(Request $request, $id){

        $data = $request->all();
        $result = $this->model::with('sale_item.product')->where('customer_id', $id)->where('status', 0)->first();
        

        if( !$result || $result->status != 0) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        try {

            $result->update(['status' => 1]);
            $result->update(['delivery_type' => $data['delivery_type']]);
            $result->update(['delivery_price' => $data['delivery_price']]);
            $result->update(['payment_type' => $data['payment_type']]);
            $result->update(['payment_discount' => $data['payment_discount']]);
            $result->update(['installment_payment' => $data['installment_payment']]);
            $result->update(['obs' => $data['obs']]);

            $saleEmail = $result->customer->email;
            $saleName = $result->customer->name;
            $saleId = $result->id;
            $saleDeliveryPrice = number_format($result->delivery_price, 2, ',', '.');
            $saleDiscount = $result->payment_discount * 100;
            $saleTotal = number_format($result->total - $result->delivery_price, 2, ',', '.');
            $saleTrueTotal = number_format($result->total, 2, ',', '.');
            $saleStatus = 'foi <span class="status">emitido</span>';
        
            $products =[]; 
            foreach ($result->sale_item as $item) {
                $data = array(
                    'image_url' => $item->product->product_img->first()->image_path,
                    'name' => $item->product->desc,
                    'price' => $item->unity_price,
                    'quantity' => $item->amount
                );
                $products[] = $data;
            }
    
            $email = new EmailController();
            $email->sendConfirmOrder(
                $saleEmail, $saleName, $saleId, $saleDeliveryPrice, $saleDiscount, $saleTotal, $saleTrueTotal, $saleStatus, $products
            ); 

            $message = [
                'message'  => 'Carrinho transformado em pedido com sucesso', 
                'sale' => $this->model->find($result->id)
            ]; 

            return response()->json($message);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Modificação nao autorizada'], 500);
        }
    }
}

