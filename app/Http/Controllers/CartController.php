<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\Products;

class CartController extends Controller
{
    public function index()
    {
        try {
            $carts = Carts::all();
            $count = Carts::count();
            return [
                "count" => $count,
                "data" => $carts,
                "message" => 'get all cart successfully'
            ];
        } catch (\Throwable $th) {
            return [
                "message" => $th
            ];
        }

    }



    public function create(Request $req)
    {
        // Log::log("level", $req);
        try {
            $product = Products::find($req->product_id);
            if (empty ($product)) {
                return [
                    "data" => null,
                    "message" => 'product is not exsit'
                ];
            }

            $findCart = Carts::where('product_id', $product->id)->first();

            if (!empty ($findCart)) {
                return response()->json([
                    "data" => 0,
                    "message" => 'product exsit in cart'
                ], 201);
            }


            $cart = new Carts();
            $cart->product_id = $req->product_id;
            $cart->quantity = $req->quantity;
            $cart->save();

            return response()->json([
                "data" => $cart,
                "message" => 'add to cart successfully'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "$th + 'error'"
            ], 200);
        }



    }

    public function update(Request $request, $id)
    {
        try {

            if (Carts::where('id', $id)->exists()) {
                $cart = Carts::find($id);
                $cart->quantity = $request->quantity;

                $cart->save();
                return [
                    "data" => $cart,
                    "message" => 'update cart successfully'
                ];
            }
        } catch (\Throwable $th) {
            return [
                "message" => $th
            ];
        }

    }

    public function delete($id)
    {
        try {

            if (Carts::where('id', $id)->exists()) {
                $cart = Carts::find($id);
                $cart->delete();
                return [
                    "data" => 1,
                    "message" => 'delete successfully'
                ];
            } else {
                return [
                    "data" => 0,
                    "message" => 'cart is not exsit'
                ];
            }
        } catch (\Throwable $th) {
            return [
                "message" => $th
            ];
        }

    }

}
