<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use App\Models\{Movement, Product};
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function getHistoric(): JsonResponse
    {
        return response()->json([
            Movement::select('sku', 'quantity', 'created_at')->get()
        ], 200);
    }

    public function createProduct(Request $request)
    {
        $return_message = $this->verifyProductName($request->name);

        if ($return_message !== true) {
            return $return_message;
        }

        DB::beginTransaction();
        $product = Product::create($request->all());
        $product->save();
        DB::commit();

        return response()->json([
            "product" => $product
        ], 200);
    }

    public function createMovement(Request $request, Product $product): JsonResponse
    {
        DB::beginTransaction();
        $movement = new Movement;
        $movement->sku = $request->sku;
        $movement->quantity = $request->quantity;
        $movement->save();
        DB::commit();

        return response()->json([
            "movement" => $movement,
            "product" => $product
        ], 200);
    }

    public function updateStock(Request $request): JsonResponse
    {
        $return_message = $this->verifyProduct($request);

        if ($return_message !== true) {
            return $return_message;
        }

        DB::beginTransaction();
        $product = Product::find($request->sku);
        $product->quantity = $product->quantity + $request->quantity;
        $product->save();
        DB::commit();

        return $this->createMovement($request, $product);
    }

    private function verifyProduct(Request $request): JsonResponse|bool
    {
        if (Product::where('sku', $request->sku)->exists()) {
            if ($request->quantity > 0) {
                return true;
            }

            return $this->verifyMovement($request->sku, $request->quantity);
        }

        return response()->json([
            "message" => "Product not found"
        ], 404);
    }

    private function verifyProductName(string $name): JsonResponse|bool
    {
        if (Product::where('name', $name)->exists()) {
            return response()->json([
                "message" => "Product aready exists"
            ], 403);
        }

        return true;
    }

    private function verifyMovement(string $sku, int $quantity): JsonResponse|bool
    {
        $product_quantity = intval(DB::table('products')
            ->select('quantity')
            ->where('sku', $sku)
            ->value('quantity'));

        if (($product_quantity + $quantity) >= 0) {
            return true;
        }

        return response()->json([
            "message" => "Insufficient amount"
        ], 403);
    }
}
