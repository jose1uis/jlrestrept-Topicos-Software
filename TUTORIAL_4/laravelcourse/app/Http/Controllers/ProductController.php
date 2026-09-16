<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class ProductController extends Controller
{


    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Products - Online Store';
        $viewData['subtitle'] = 'List of products';
        $viewData['products'] = Product::all();

        return view('product.index')->with('viewData', $viewData);
    }

    public function show(string $id): View|RedirectResponse
    {
        $viewData = [];
        $product = Product::find($id);

        if ($product === null) {
            return redirect()->route('home.index'); //ps por si no hay nada
        }

        $viewData['title'] = $product['name'] . ' - Online Store';
        $viewData['subtitle'] = $product['name'] . ' - Product information';
        $viewData['product'] = $product;

        return view('product.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Create product';

        return view('product.create')->with('viewData', $viewData);
    }

    public function save(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        Product::create($request->only(["name", "price"]));

        return back();
    }
}
