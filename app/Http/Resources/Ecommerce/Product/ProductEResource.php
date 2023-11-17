<?php

namespace App\Http\Resources\Ecommerce\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductEResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // logica de descuento
        return [
            "id" => $this->id,
            "title" => $this->resource->title,
            "categorie_id" => $this->resource->categorie_id,
            "categorie" => [
                "id" => $this->resource->categorie->id,
                "icono" => $this->resource->categorie->icono,
                "name" => $this->resource->categorie->name,
            ],
            "slug" => $this->resource->slug,
            "sku" => $this->resource->sku,
            "price_soles" => $this->resource->price_soles,
            "price_usd" => $this->resource->price_usd,
            "resumen" => $this->resource->resumen,
            "description" => $this->resource->description,
            "imagen" => env("APP_URL")."storage/".$this->resource->imagen,
            "stock" => $this->resource->stock,
            "images" => $this->resource->images->map(function($img){
                return [
                    "id" => $img->id,
                    "file_name" => $img->file_name,
                    "imagen" => env("APP_URL")."storage/".$img->imagen,
                    "size" => $img->size,
                    "type" => $img->type,
                ];
            })
        ];
    }
}
