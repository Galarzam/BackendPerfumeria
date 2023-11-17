<?php

namespace App\Http\Controllers\Ecommerce\Cart;

use Illuminate\Http\Request;
use App\Models\Cart\CartShop;
use App\Models\Product\Product;
use App\Models\Product\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartShopResource;
use App\Http\Resources\Cart\CartShopCollection;

use App\Models\Cupon\Cupone;

class CartShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = CartShop::where("user_id",auth('api')->user()->id)->orderBy("id","desc")->get();
        //$categories = Categorie::orderBy("id","desc")->get();

        return response()->json(["carts" => CartShopCollection::make($carts)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function  apply_cupon($cupon)
    {
        $cupone = Cupone::where("code",$cupon)->where("state",1)->first();
        if(!$cupone){
            return response()->json(["message" => 403, "message_text" => "EL CODIGO DEL CUPON INGRESADO NO EXISTE"]);
        }
        $user = auth("api")->user();
        $cartshops = CartShop::where("user_id",$user->id)->orderBy("id","desc")->get();

        foreach ($cartshops as $key => $cart){
            if($cupone->products){
                $products = explode(",",$cupone->products);
                if(in_array($cart->product_id,$products)){
                    $subtotal = 0;
                    $total = 0;
                    if($cupone->type_discount == 1){
                        $subtotal = $cart->precio_unitario - $cart->precio_unitario * ($cupone->discount * 0.01);
                    }else{
                        $subtotal = $cart->precio_unitario - $cupone->discount;
                    }
                    $total = $subtotal * $cart->cantidad;

                    $cart->update(["subtotal" => $subtotal, "total" => $total , "type_discount" => $cupone->type_discount, "discount" => $cupone->discount, "code_cupon" => $cupone->code]);
                }
            }
            if($cupone->categories){
                $categories = explode(",",$cupone->categories);
                $categories = explode(",",$cupone->categories);
                if(in_array($cart->product->categorie_id,$categories)){
                    $subtotal = 0;
                    $total = 0;
                    if($cupone->type_discount == 1){
                        $subtotal = $cart->precio_unitario - $cart->precio_unitario * ($cupone->discount * 0.01);
                    }else{
                        $subtotal = $cart->precio_unitario - $cupone->discount;
                    }
                    $total = $subtotal * $cart->cantidad;

                    $cart->update(["subtotal" => $subtotal, "total" => $total , "type_discount" => $cupone->type_discount, "discount" => $cupone->discount, "code_cupon" => $cupone->code]);
                }
            }
        }
        return response()->json(["message" => 200, "carts" => CartShopCollection::make($cartshops)]);
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
        if($request->product_id){
            $validate_cart_shop = CartShop::where("product_id",$request->product_id)->first();
            if($validate_cart_shop){
                return response()->json(["message" => 403, "message_text" => "EL PRODUCTO SELECCIONADO FUE AGREGADO A SU CARRITO"]);
            }
        }
        
        
        if($request->product_id){
            $product = Product::findOrFail($request->product_id);
            if($product->stock < $request->cantidad){
                return response()->json(["message" => 403, "message_text" => "EL PRODUCTO NO SE ENCUNTRA EN STOCK ACTUALMENTE"]);
            }
        }
        $cart_shop = CartShop::create($request->all());
        return response(["message" => 200 , "cart_shop" => CartShopResource::make($cart_shop)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        if($request->product_id){
            $validate_cart_shop = CartShop::where("id","<>",$id)->where("product_id",$request->product_id)->first();
            if($validate_cart_shop){
                return response()->json(["message" => 403, "message_text" => "EL PRODUCTO SELECCIONADO YA EXISTE"]);
            }
            
        } 

         
         if($request->product_id){
             $product = Product::findOrFail($request->product_id);
             if($product->stock < $request->cantidad){
                 return response()->json(["message" => 403, "message_text" => "EL PRODUCTO NO SE ENCUNTRA EN STOCK ACTUALMENTE"]);
             }
         }
         $cart_shop = CartShop::findOrFail($id);
         $cart_shop->update($request->all());
         return response(["message" => 200 , "cart_shop" => CartShopResource::make($cart_shop)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart_shop = CartShop::findOrFail($id);
        $cart_shop->delete(); 
        return response(["message" => 200 ]);
    }
}
