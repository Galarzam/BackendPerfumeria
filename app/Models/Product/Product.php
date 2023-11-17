<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "categorie_id",
        "title",
        "slug",
        "sku",
        "price_soles",
        "price_usd",
        "tags",
        "description",
        "resumen",
        "state",
        "imagen",
        "stock",
    ]; 

    public function setCreatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]=Carbon::now();
    }

    public function setUpdatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]=Carbon::now();
    }


    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function scopefilterProduct($query,$search,$categorie_id){ 
        if($search){
            $query->where("title","like","%".$search."%");
        }
        if($categorie_id){
            $query->where("categorie_id",$categorie_id);
        }
        return $query;
    }

    public function scopefilterAdvance($query,$categories,$search_product){
        if($categories && sizeof($categories) > 0){
            $query->whereIn("categorie_id",$categories);
        }
        if($search_product){
            $query->where("title","like","%".$search_product."%");
        }
        return $query;
    }
}
