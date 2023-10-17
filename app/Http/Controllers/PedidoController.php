<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Mail\EmailController;

class PedidoController extends Controller
{
    private $model;  

    public function __construct(Carrinho $func)
    {
        $this->model = $func;
    }

    public function getAll(){
        $result = $this->model::with('sale_item.product.product_img', 'customer.delivery_address.address')->where('status','!=', 0)->get();

        if (!$result->isEmpty()) {

            $result = $result->values();

            foreach ($result as $sale) {
                $sale->makeHidden([
                    'sale_item', 'customer'
                ]);
                $sale->customer_name = $sale->customer->name;
                $delivery_address = []; 
                
                if ($sale->customer->delivery_address->isNotEmpty()) {
                    $firstAddress = $sale->customer->delivery_address->first();
    
                    $data = array(
                        'cep' => $firstAddress->address->cep,
                        'number' => $firstAddress->number,
                        'complement' => $firstAddress->complement,
                        'reference' => $firstAddress->reference,
                        'street' => $firstAddress->address->street,
                        'city' => $firstAddress->address->city,
                        'district' => $firstAddress->address->district,
                        'state' => $firstAddress->address->state,
                        'created_at' => $firstAddress->created_at,
                        'updated_at' => $firstAddress->updated_at
                    );
    
                    $sale->delivery_address = $data;
                }
                
                $sale_items = []; 

                foreach ( $sale->sale_item as $item) {
                    $data = array(
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->desc,
                        'product_img' => $item->product->product_img->first()->image_path, 
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

    public function findById($id)
    {
        
        $result = $this->model::with('sale_item.product.product_img')->where('status','!=', 0)->where('id', $id)->get();

        if (!$result->isEmpty()) {

            $result = $result->values();

            foreach ($result as $sale) {
                $sale->makeHidden([
                    'sale_item', 'customer'
                ]);
                $sale->customer_name = $sale->customer->name;

                if ($sale->customer->delivery_address->isNotEmpty()) {
                    $firstAddress = $sale->customer->delivery_address->first();
    
                    $data = array(
                        'cep' => $firstAddress->address->cep,
                        'number' => $firstAddress->number,
                        'complement' => $firstAddress->complement,
                        'reference' => $firstAddress->reference,
                        'street' => $firstAddress->address->street,
                        'city' => $firstAddress->address->city,
                        'district' => $firstAddress->address->district,
                        'state' => $firstAddress->address->state,
                        'created_at' => $firstAddress->created_at,
                        'updated_at' => $firstAddress->updated_at
                    );
    
                    $sale->delivery_address = $data;
                }

                $sale_items = []; 

                foreach ( $sale->sale_item as $item) {
                    $data = array(
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->desc,
                        'product_img' => $item->product->product_img->first()->image_path,
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
        
        $result = $this->model::with('sale_item.product.product_img')->where('status','!=', 0)->where('customer_id', $id)->get();

        if (!$result->isEmpty()) {

            $result = $result->values();

            foreach ($result as $sale) {
                $sale->makeHidden([
                    'sale_item', 'customer'
                ]);
                $sale->customer_name = $sale->customer->name;

                if ($sale->customer->delivery_address->isNotEmpty()) {
                    $firstAddress = $sale->customer->delivery_address->first();
    
                    $data = array(
                        'cep' => $firstAddress->address->cep,
                        'number' => $firstAddress->number,
                        'complement' => $firstAddress->complement,
                        'reference' => $firstAddress->reference,
                        'street' => $firstAddress->address->street,
                        'city' => $firstAddress->address->city,
                        'district' => $firstAddress->address->district,
                        'state' => $firstAddress->address->state,
                        'created_at' => $firstAddress->created_at,
                        'updated_at' => $firstAddress->updated_at
                    );
    
                    $sale->delivery_address = $data;
                }

                $sale_items = []; 

                foreach ( $sale->sale_item as $item) {
                    $data = array(
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->desc,
                        'product_img' => $item->product->product_img->first()->image_path,
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

    public function cancelSale($id){

        $result = $this->model::with('sale_item.product.product_img', 'customer.delivery_address.address')->where('status','!=', 0)->where('id', $id)->first();

        if( !$result || $result->status == 0) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        try {
            if($result->status != 5){
                $saleEmail = $result->customer->email;
                $saleName = $result->customer->name;
                $saleId = $result->id;
                $saleDeliveryPrice = number_format($result->delivery_price, 2, ',', '.');
                $saleDiscount = $result->payment_discount * 100;
                $saleTotal = number_format($result->total - $result->delivery_price, 2, ',', '.');
                $saleTrueTotal = number_format($result->total, 2, ',', '.');
                $saleStatus = 'foi <span class="status">cancelado</span>';
        
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
            }
            $result->update(['status' => 5]);

            $message = [
                'message'  => 'Pedido atualizado com sucesso', 
                'sale' => $this->model->find($result->id)->makeHidden([
                    'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                    'delivery_type', 'obs', 'payment_type', 'payment_date',
                    'payment_discount', 'installment_payment', 'total'
                ])
            ];

            return response()->json($message);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Modificação nao autorizada'], 500);
        }
    }

    public function badUpdate($id){

        $result = $this->model::with('sale_item.product.product_img', 'customer.delivery_address.address')->where('status','!=', 0)->where('id', $id)->first();

        if( !$result || $result->status == 0) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        try {
            $aux = ($result->status > 5) ? 0 : 5;

            $status = $result->status + $aux;
            $result->update(['status' => $status]);

            $message = [
                'message'  => 'Pedido atualizado com sucesso', 
                'sale' => $this->model->find($result->id)->makeHidden([
                    'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                    'delivery_type', 'obs', 'payment_type', 'payment_date',
                    'payment_discount', 'installment_payment'
                ])
            ];

            $saleEmail = $result->customer->email;
            $saleName = $result->customer->name;
            $saleId = $result->id;
            $saleDeliveryPrice = number_format($result->delivery_price, 2, ',', '.');
            $saleDiscount = $result->payment_discount * 100;
            $saleTotal = number_format($result->total - $result->delivery_price, 2, ',', '.');
            $saleTrueTotal = number_format($result->total, 2, ',', '.');
            $saleStatus = '';
            switch ($status) {
                case 6:
                    $saleStatus = 'teve seu <span class="status">pagamento negado</span>';
                    break;
                case 7:
                    $saleStatus = 'teve <span class="status">problemas com o trasporte</span>';
                    break;
                case 8:
                    $saleStatus = 'teve <span class="status">problemas com o trasporte</span>';
                    break;
            }
    
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

            return response()->json($message);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Modificação nao autorizada'], 500);
        }
    }

    public function goodUpdate($id) {
        $result = $this->model::with('sale_item.product.product_img', 'customer.delivery_address.address')->where('status','!=', 0)->where('id', $id)->first();
    
        if (!$result || $result->status == 0) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }
    
        try {
            $aux = ($result->status > 5) ? -4 : 1;
    
            $status = $result->status + $aux;
            $result->update(['status' => $status]);
    
            $message = [
                'message'  => 'Pedido atualizado com sucesso', 
                'sale' => $this->model->find($result->id)->makeHidden([
                    'emission_date', 'approval_date', 'transport_date', 'delivery_date',
                    'delivery_type', 'obs', 'payment_type', 'payment_date',
                    'payment_discount', 'installment_payment'
                ])
            ];
    
            $saleEmail = $result->customer->email;
            $saleName = $result->customer->name;
            $saleId = $result->id;
            $saleDeliveryPrice = number_format($result->delivery_price, 2, ',', '.');
            $saleDiscount = $result->payment_discount * 100;
            $saleTotal = number_format($result->total - $result->delivery_price, 2, ',', '.');
            $saleTrueTotal = number_format($result->total, 2, ',', '.');
            $saleStatus = '';
            switch ($status) {
                case 1:
                    $saleStatus = 'foi <span class="status">emitido</span>';
                    break;
                case 2:
                    $saleStatus = 'teve seu <span class="status">pagamento aprovado</span>';
                    break;
                case 3:
                    $saleStatus = 'saiu para <span class="status">transporte</span>';
                    break;
                case 4:
                    $saleStatus = 'foi <span class="status">entregue</span>';
                    break;
            }


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
    
            return response()->json($message);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Modificação não autorizada'], 500);
        }
    }    
}

