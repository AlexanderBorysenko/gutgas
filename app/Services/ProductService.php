<?php

namespace App\Services;

use App\Models\AttributeGroup;
use App\Models\Product;
use App\Models\ProductsGroup;
use Illuminate\Http\Request;

class ProductService
{
    public function productsCatalogQuery(Request $request)
    {
        $products = Product::query()->orderBy('created_at', 'desc');

        $priceRange = $request->query('priceRange');
        if (!empty($priceRange)) {
            $products->whereBetween('price', [$priceRange['from'], $priceRange['to']]);
        }

        $attributes = $request->query('attributes');
        if (!empty($attributes)) {
            foreach ($attributes as $key => $attribute) {
                $products->whereHas('attributes', function ($query) use ($attribute) {
                    $query->where('attributes.id', $attribute);
                });
            }
        }

        $productsGroup = $request->query('productsGroup');
        if (!empty($productsGroup)) {
            $products->whereHas('productsGroups', function ($query) use ($productsGroup) {
                $query->where('products_groups.id', $productsGroup);
            });
        }

        return $products;
    }

    public function productsCatalogData(Request $request, $productsQuery = null)
    {
        if (!$productsQuery) $productsQuery = $this->productsCatalogQuery($request);


        $availableAttributes = AttributeGroup::with('attributes')->where('use_in_filters', '=', true)->get();

        $priceMin = Product::min('price');
        $priceMax = Product::max('price');

        return [
            'priceMin' => +$priceMin,
            'priceMax' => +$priceMax,
            'priceRange' => $request->query('priceRange') ?? [
                'from' => +$priceMin,
                'to' => +$priceMax,
            ],
            'products' => $productsQuery->paginate(9),
            'productsGroup' => $request->query('productsGroup') ?? null,
            'attributeGroups' => $availableAttributes,
            'productsGroups' => ProductsGroup::all()->where('is_active', '=', 1),
            'appliedAttributes' => $request->query('attributes') ?? [],
            'totalProductsCount' => Product::count(),
        ];
    }

    public function extractProductRequiredData(Request $request)
    {
        $productData = $request->only([
            'category_id',
            'sku',
            'name',
            'price',
            'stock',
            'description'
        ]);

        return $productData;
    }
}
