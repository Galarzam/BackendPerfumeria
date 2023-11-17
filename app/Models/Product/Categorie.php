<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use Carbon\Carbon;

class Categorie extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        "name",
        "imagen",
        "icono",
    ];
 
    public function setCreatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]=Carbon::now();
    }

    public function setUpdatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
