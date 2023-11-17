<?php

namespace App\Models\Client;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AddressUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "full_name",
        "full_surname",
        "company_name",
        "region",
        "direccion",
        "city",
        "zip_code",
        "phone",
        "email",
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Si sale un error fijarse el user ya que no de importo del User al Address
}
