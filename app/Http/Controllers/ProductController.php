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
     * Store price entry point, will check price and add if has none
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
        // $currency = $request->enum('currency', CurrencyEnum::class);
        $currency = $request->currency;

        try {
            if ($this->hasPrice($product, $size))
                return response()->json(['This product already has a price.'], 422);

            // Create relationship between the size and the product
            $this->forceSize($product, $size);
            $this->addPrice($product, $size, $price, $currency);

            return response()->json(['Price updated.']);
        } catch (\Throwable $th) {
            // Here goes logic to log this error or something like it;
            return response()->json(['Un error occur. Please contact the admin.'], 500);
        }
    }

    /**
     * Check if the product already has a price.
     * If the product has a category with grouping, it will check all available sizes.
     *
     * @param Product $product
     * @param Size $size
     * @return boolean
     */
    public function hasPrice(Product $product, Size $size): bool
    {
        $list = [];

        if ($product->isGroupingPrice())
            $list = $product->sizes()->wherePivotNotNull('price')->get();
        else 
            $list = $product->sizes()->wherePivotNotNull('price')->where('sizes.id', $size->id)->get();

        return count($list);
        
    }

    /**
     * Add the price in pivot table for a single row or all sizes available based on category
     *
     * @param Product $product
     * @param Size $size
     * @param float $price
     * @param string $currency
     * @return void
     */
    public function addPrice(Product $product, Size $size, float $price, string $currency)
    {
        $newPriceCurrency = ['price' => $price, 'currency' => $currency];
        if ($product->isGroupingPrice())
            $product->sizes()->newPivotQuery()->update($newPriceCurrency);
        else
            $product->sizes()->updateExistingPivot($size->id, $newPriceCurrency);
    }

    /**
     * Attach the size for product if not attached before.
     *
     * @param Product $product
     * @param Size $size
     * @return void
     */
    public function forceSize(Product $product, Size $size)
    {
        return $product->sizes()->syncWithoutDetaching($size->id);
    }
}
