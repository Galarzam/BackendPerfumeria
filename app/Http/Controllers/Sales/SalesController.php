<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use Carbon\Carbon;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleDetail;
use App\Models\Client\AddressUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Sale\SaleCollection;

use App\Models\Product\Categorie;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function sale_all(Request $request){
        $search = $request->search;

        $orders = Sale::filterAdvance($search)->orderBy("id","desc")->get();
        return response()->json(["orders" => SaleCollection::make($orders),]);
    }

    
    
   
    public function index()
    {
        $user = auth('api')->user();

        $address = AddressUser::where("user_id",$user->id)->orderBy("id","desc")->get();

        $orders = Sale::where("user_id",$user->id)->orderBy("id","desc")->get();

        $sales_details = SaleDetail::whereHas("sale",function($q) use($user) {
            $q->where("user_id",$user->id);
        })->with(["review","product","sale"])->orderBy("sale_id","desc")->get();

        
        return response()->json([
            
            "orders" => SaleCollection::make($orders),
            

        ]);
    }

}
