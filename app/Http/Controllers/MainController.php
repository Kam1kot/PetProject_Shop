<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Sections/MainCatalog', [
            'title' => 'Главная страница',

            'products' => Product::with('category')->when($request->search, function($q, $search) {
                    $q->where('name', 'like', "%{$search}%");
                })->paginate(16)->withQueryString(),

            'hitProducts' => Cache::remember("hitProducts.all", 60, function () {
                    return Product::with('category')->inRandomOrder()->limit(6)->get()->toArray();
                })
        ]);
    }
}
