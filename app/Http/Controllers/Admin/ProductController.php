<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsGroup;
use App\Models\RequiredProductsGroup;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class ProductController extends Controller
{

    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $search = '')
    {
        if (request()->routeIs('admin.product.search') && empty($search)) {
            return redirect()->route('admin.product.index');
        }

        return inertia('Admin/Product/Index')->with([
            'products' => Product::with('mediaFile.thumbnail')
                ->with('seoEntity')
                ->orderBy('id', 'desc')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('sku', 'LIKE', "%{$search}%")
                ->orWhere('id', $search)
                ->paginate(15),
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Product/Create')->with([
            'attributes' => Attribute::all(),
            'categories' => Category::tree()->get(),
            'productsGroups' => ProductsGroup::all(),
            'requiredProductsGroups' => RequiredProductsGroup::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();

        try {
            $product = Product::create($this->productService->extractProductRequiredData($request));

            $product->syncProductRelationsData($data);

            $product->productPage()->create([
                'title' => $product->name,
                'media_gallery' => [],
            ]);

            $product->productPage->seoEntity()->update([
                'slug' => 'catalog/product-' . $product->id,
                'title' => $product->name,
                'description' => $product->description,
                'og_image' => $product->mediaFile->url ?? null,
            ]);

            return redirect()->route('admin.product.edit', $product->id)->with('message', [
                'type' => 'success',
                'text' => 'Product created successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return inertia('Admin/Product/Edit')->with([
            'product' => $product->load('mediaFile')->load('seoEntity')->load('productsGroups')->load('requiredProductsGroups'),
            'productPage' => $product->productPage,
            'productAttributes' => $product->attributes,
            'attributes' => Attribute::all(),
            'categories' => Category::tree()->get(),
            'productsGroups' => ProductsGroup::all(),
            'requiredProductsGroups' => RequiredProductsGroup::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Product $product)
    {
        DB::beginTransaction();

        $data = $request->validated();

        try {
            $product->update($this->productService->extractProductRequiredData($request));

            $product->syncProductRelationsData($data);

            $product->save();

            return redirect()->route('admin.product.edit', $product->id)->with('message', [
                'type' => 'success',
                'text' => 'Product updated successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.product.index')->with('message', [
            'type' => 'success',
            'text' => 'Page deleted successfully',
        ]);
    }
}
