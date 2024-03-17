<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Products::all();
            $count = Products::count();
            error_log('Some message here.');
            return [
                "count" => $count,
                "data" => $products,
                "message" => 'get all product succsessfully'
            ];
        } catch (\Throwable $th) {
            Log::debug("message", $th->getMessage());
            return [
                "message" => $th
            ];
        }

    }

    public function productWithCart()
    {
        try {
            $products = Products::leftJoin('carts', function ($join) {
                $join->on('products.id', '=', 'carts.product_id');

            })
                ->select('products.*', DB::raw('IF(carts.product_id IS NOT NULL, true, false) AS is_in_cart'))
                ->get();



            return [
                "data" => $products,
                "message" => 'get all cart successfully'
            ];

        } catch (\Throwable $th) {
            return [
                "message" => $th
            ];
        }

    }

    public function importFromJson()
    {
        // Đường dẫn đến tệp JSON
        $filePath = storage_path('\backend\server-laravel\app\Http\Controllers\data.json');

        // Đảm bảo tệp tồn tại
        if (File::exists($filePath)) {
            // Đọc nội dung từ tệp JSON
            $jsonContent = File::get($filePath);

            // Chuyển đổi nội dung JSON thành mảng dữ liệu
            $data = json_decode($jsonContent, true);

            // Lặp qua mảng dữ liệu và lưu vào cơ sở dữ liệu
            foreach ($data['shoes'] as $shoe) {
                Products::create([
                    'id' => $shoe['id'],
                    'image' => $shoe['image'],
                    'name' => $shoe['name'],
                    'description' => $shoe['description'],
                    'price' => $shoe['price'],
                    'color' => $shoe['color'],

                ]);
            }

            return response()->json(['message' => 'Data imported successfully'], 200);
        } else {
            return response()->json(['message' => 'JSON file not found'], 404);
        }
    }
}
