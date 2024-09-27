<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Mail\ProductCreated;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
//Listar produtos
    public function index(): JsonResponse
    {
        $product = Product::orderby('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }

    public function show($id): JsonResponse
    {
       $product = Product::find($id);

        try {
            return response()->json([
                'status' => true,
                'product' => $product,
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Produto não encontrado.'
            ], 404);
        }
    }

    public function store(ProductRequest $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        $productData = $request->only(['name', 'price', 'description']);
        $productData['user_id'] = Auth::id();

        //Upload de imagem (se for fornecida)
        if ($request->hasFile('image')) {
            $productData['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($productData);

        //Queue de email a ser enviado
        try {
            Mail::to($request->user())->queue(new ProductCreated($product));
            return response()->json([
                'message' => 'Produto cadastrado com sucesso, e email enviado!',
                'product' => $product,
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar e-mail:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Produto cadastrado, mas falha ao enviar e-mail!'], 201);
        }

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

        //Enviar o email de notificação de edição
        try {
            Mail::to($request->user())->queue(new ProductUpdated($product));
            return response()->json([
                'message' => 'Produto atualizado com sucesso, e email enviado!',
                'product' => $product,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Produto atualizado, mas falha ao enviar e-mail!'], 201);
        }




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
