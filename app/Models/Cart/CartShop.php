<?php

namespace App\Models\Cart;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class CartShop extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "type_discount",
        "discount",
        "cantidad",
        "code_cupon",
        "code_discount",
        "precio_unitario",
        "subtotal",
        "total",
    ];

    public function setCreatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();
    }
    public function setUpdatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    public function client()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
