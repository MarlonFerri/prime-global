<?php

namespace App\Http\Controllers;

use App\Enums\CurrencyEnum;
use App\Http\Requests\StorePriceRequest;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * This function 
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storePrice(StorePriceRequest $request): JsonResponse
    {
        // I don't need to validate if exists because StorePriceRequest already do it.
        $product = Product::where('name', $request->product)->first();
        $size = Size::where('name', $request->size)->first();

        $price = $request->price;
        $currency = $request->enum('currency', CurrencyEnum::class);

        try {
            if ($this->hasPrice($product, $size))
                return response()->json(['This product already has a price.'], 422);

            // Create relationship between the size and the product
            $this->forceSize($product, $size);
            $this->addPrice($product, $size, $price, $currency);

            response()->json(['Price updated.']);
        } catch (\Throwable $th) {
            // Here goes logic to log this error or something like it;
            return response()->json(['Un error occur. Please contact the admin.'], 500);
        }
    }

    public function hasPrice(Product $product, Size $size): bool
    {
        $list = [];

        if ($product->isGroupingPrice())
            $list = $product->sizes()->wherePivotNotNull('price')->get();
        else 
            $list = $product->sizes()->wherePivotNotNull('price')->where('size.id', $size->id);

        return count($list);
        
    }

    public function addPrice(Product $product, Size $size, float $price, CurrencyEnum $currency)
    {
        $newPriceCurrency = ['price' => $price, 'currency' => $currency];
        if ($product->isGroupingPrice())
            $product->sizes()->newPivotQuery()->update($newPriceCurrency);
        else
            $product->sizes()->updateExistingPivot($size->id, $newPriceCurrency);
    }

 
    public function forceSize(Product $product, Size $size)
    {
        return $product->sizes()->attach($size->id);
    }
}
