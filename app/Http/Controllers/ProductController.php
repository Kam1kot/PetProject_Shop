<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function products(Request $request)
    {
        $page = request()->get('page',1);
        $perPage = request()->get('perPage', 16);
        $search = request()->get('search');

        $cacheKey = "products.page.$page.perPage.$perPage.search." . md5($search);

        $products = Cache::remember($cacheKey, 60, function () use ($perPage, $search) {
            $query = Product::with('category');
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            }
            return $query->paginate($perPage)->toArray();
        });
        // dd($products->toArray());

        // dd($products);
        return response()->json($products);
    }
    public function hitProducts () {
        $hitProducts = Cache::remember("hitProducts.all", 60, function () {
            return Product::with('category')->inRandomOrder()->limit(6)->get()->toArray();
        });

        return response()->json($hitProducts);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductRequest $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        Cache::forget("products.all");

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Cache::remember("product_show.$id", now()->addMinutes(60), function () use ($id) {
            $item = Product::with(['category', 'brand', 'tags'])->findOrFail($id);
            return $item->toArray();
        });

        if (!$product) abort(404);

        $tagIds = collect(data_get($product,'tags'))->pluck('id')->toArray();
        $brandId = data_get($product, 'brand_id');

        $otherTagProducts = Cache::remember("product_tagRelated.$id", now()->addMinutes(60), function () use ($tagIds, $id) {
            $item = Product::whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id',$tagIds);
            })->where('id','!=',$id)
            ->with(['category','tags'])
            ->limit(6)->get();
            return $item->toArray();
        });
        if (!$otherTagProducts) abort(404);
        $otherBrandProducts = Cache::remember("product_brandRelated.$id",now()->addMinutes(60), function () use ($brandId, $id) {
            $item = Product::where('brand_id', $brandId)->where('id','!=',$id)->with(['category','tags'])
            ->limit(6)->get();
            return $item->toArray();
        });
        if (!$otherBrandProducts) abort(404);
        return Inertia::render('Products/Product', [
            'product' => $product,
            'otherTagProducts' => $otherTagProducts,
            'otherBrandProducts' => $otherBrandProducts
        ]);
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
        $product = Product::findOrFail($id);
        $product->update($request->all());

        Cache::forget('products.$id');
        Cache::forget('products.all');

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();

        Cache::forget('products.$id');
        Cache::forget('products.all');

        return response()->json(['status' => 'deleted']);
    }
}
