<?php

namespace App\Models\Sale;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sale\SaleDetail;
use App\Models\Sale\SaleAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "method_payment",
        "currency_total",
        "currency_payment",
        "total",
        "price_dolar",
        "n_transaccion",
    ];

    public function setCreatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]=Carbon::now();
    }

    public function setUpdatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sale_address()
    {
        return $this->hasOne(SaleAddress::class);
    }

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function scopefilterAdvance($query, $search)
    {
        if($search){
            $query->whereHas("user",function($q) use($search) {
                $q->where("name","like","%".$search."%")->orWhere("surname","like","%".$search."%");
            });
        }
        return $query;
    }
}
