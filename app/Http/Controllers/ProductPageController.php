<?php

namespace App\Http\Controllers;

use App\Models\ProductPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductPageController extends Controller
{
    public function show(Request $request, ProductPage $productPage)
    {
        $product = $productPage->product;
        return Inertia::render('ProductPage', [
            'product' => $product,
            'productPage' => $productPage,
            'seoEntity' => $productPage->seoEntity,
            'attributeGroups' => $product->attributeGroups(),
        ]);
    }
}
