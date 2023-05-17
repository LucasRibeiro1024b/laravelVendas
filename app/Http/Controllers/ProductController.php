<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Products/index', [
            'products' => product::all()
        ]);
    }
    public function indexAPI(): JsonResponse
    {
        return response()->json(['produtos' => product::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required',
        ]);

        $product        = new product();
        $product->name  = $validated['name'];
        $product->price = $validated['price'];
        $product->save();

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required',
        ]);

        $product->update($validated);

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        $product->delete();

        return redirect(route('products.index'));
    }
}