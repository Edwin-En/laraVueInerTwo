<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('ManageSantander/IndexToProducts', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:products|max:255',
            'descripcion' => 'required',
            'stock' => 'required|integer',
            'precio_unitario' => 'required|numeric',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'codigo' => 'required|max:255|unique:products,codigo,' . $product->id,
            'descripcion' => 'required',
            'stock' => 'required|integer',
            'precio_unitario' => 'required|numeric',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
    }
}
