<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
//Listar produtos do usuario autenticado
    public function index(): JsonResponse
    {
        $product =Product::orderby('id','desc')->get();
        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }

    public function store(ProductRequest $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image'
        ]);
        $productData = $request->only(['name', 'price', 'description']);
        $productData['user_id'] = Auth::id();

        //Upload de imagem (se for fornecida)
        if ($request->hasFile('image')) {
            $productData['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($productData);

        return response()->json(['product' => $product], 201);
    }

    //Editar produto
    public function update(ProductRequest $request, Product $product) : JsonResponse
    {
        if ($product->user_id != Auth::id()) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image'
        ]);

        $product->update($request->only(['name', 'price', 'description']));

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
            $product->save();
        }

        return response()->json(['product' => $product], 201);
    }

    //Deletar produto
    public function destroy(Product $product) : JsonResponse
    {
        if($product->user_id != Auth::id()){
            return response()->json(['message' => 'Acesso negado'], 403);
        }
        if($product->image){
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json(['message' => 'Produto deletado com sucesso!'], 201);
    }


}
