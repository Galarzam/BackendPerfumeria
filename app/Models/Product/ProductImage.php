<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "product_id",
        "file_name",
        "imagen",
        "type",
        "size",
    ]; 

    public function setCreatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]=Carbon::now();
    }

    public function setUpdatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]=Carbon::now();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
