<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::latest('id')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|min:1",
            'price' => "required|min:1|numeric",
            'stock' => "required|min:1|numeric"
        ]);

        $product = Product::create([
            "name" => $request->name,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) return response()->json(['message' => "Product is not found"], 404);

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => "nullable|min:1",
            'price' => "nullable|min:1|numeric",
            'stock' => "nullable|min:1|numeric"
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => "Product is not found"], 404);
        };

        if ($request->name) {
            $product->name = $request->name;
        }
        if ($request->price) {
            $product->price = $request->price;
        }
        if ($request->stock) {
            $product->stock = $request->stock;
        }
        $product->update();

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) return response()->json(['message' => "Product is not found"], 404);

        $product->delete();
        return response()->json(['message' => "Product is deleted"], 204);
    }
}