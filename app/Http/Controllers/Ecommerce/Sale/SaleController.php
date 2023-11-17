<?php

namespace App\Http\Controllers\Ecommerce\Sale;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Sale\SaleAddress;
use App\Models\Sale\SaleDetail;
use App\Models\Cart\CartShop;
use Illuminate\Http\Request;
use App\Mail\Sale\SaleMail;
use App\Models\Sale\Sale;

class SaleController extends Controller
{

    //public function __construct()
    //{
    //    $this->middleware('auth:api');
    //}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale = Sale::create($request->sale);

        $sale_address = $request->sale_address;
        $sale_address["sale_id"] = $sale->id;
        $sale_address = SaleAddress::create($sale_address);

        //carrito de compra o detalle

        $cartshop = CartShop::where("user_id", auth('api')->user()->id)->get();

        foreach($cartshop as $key => $cart){
            $cart->delete();
            $sale_detail = $cart->toArray();
            $sale_detail["sale_id"] = $sale->id;
            SaleDetail::create($sale_detail);
        }
        return response()->json(["message" => 200,"message_text" => "La venta se efectuo de manera correcta"]);
    }

    public function send_email($id)
    {
        $sale = Sale::findOrFail($id);
        Mail::to("angelogalarza2106@gmail.com")->send(new SaleMail($sale));
        return "TODO SALIO BIEN";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
