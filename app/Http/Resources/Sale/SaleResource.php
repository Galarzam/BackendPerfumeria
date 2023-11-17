<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "user" => [
                "id" => $this->resource->user->id,
                "full_name" => $this->resource->user->name. ' '.$this->resource->user->surname,
            ],
            "method_payment" => $this->resource->method_payment,
            "currency_total" => $this->resource->currency_total,
            "currency_payment" => $this->resource->currency_payment,
            "total" => $this->resource->total,
            "price_dolar" => $this->resource->price_dolar,
            "n_transaccion" => $this->resource->n_transaccion,
            "created_at" => $this->resource->created_at->format("Y/m/d"),
           "items" => $this->resource->sale_details->map(function($detail){
               return [
                   "id" => $detail->id,
                   "title" => $detail->product->title,
                   "type_discount" => $detail->type_discount,
                   "discount" => $detail->discount,
                   "cantidad" => $detail->cantidad,
                   "imagen" =>  env("APP_URL")."storage/".$detail->product->imagen,
                   "code_cupon" => $detail->code_cupon,
                   "code_discount" => $detail->code_discount,
                   "precio_unitario" => $detail->precio_unitario,
                   "subtotal" => $detail->subtotal,
                   "total" => $detail->total,
               ];    
           })
        ];
    }
}
