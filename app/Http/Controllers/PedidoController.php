<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;

class PedidoController extends Controller
{
    private $model;  

    public function __construct(Carrinho $func)
    {
        $this->model = $func;
    }

    public function getAll(){
        $result = $this->model::with('sale_item.product')->where('status','!=', 0)->get();

        if (!$result->isEmpty()) {

            $result = $result->values();

            foreach ($result as $sale) {
                $sale->makeHidden([
                    'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                    'delivery_type', 'delivery_price', 'obs', 'payment_type', 'payment_date',
                    'payment_discount', 'installment_payment', 'sale_item'
                ]);

                $sale_items = []; 

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

                    $sale_items[] = $data;
                }

                $sale->sale_items = $sale_items;
            }
            return response()->json($result);
        }
        return response()->json(['message' => 'Nenhum pedido encontrado'], 404);
    }

    public function findByCustomerId($id)
    {
        
        $result = $this->model::with('sale_item.product')->where('status','!=', 0)->where('customer_id', $id)->get();

        if (!$result->isEmpty()) {

            $result = $result->values();

            foreach ($result as $sale) {
                $sale->makeHidden([
                    'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                    'delivery_type', 'delivery_price', 'obs', 'payment_type', 'payment_date',
                    'payment_discount', 'installment_payment', 'sale_item'
                ]);

                $sale_items = []; 

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

                    $sale_items[] = $data;
                }

                $sale->sale_items = $sale_items;
            }
            return response()->json($result);
        }

        return response()->json(['message' => 'Nenhum pedido encontrado para este cliente'], 404);
    }
}

