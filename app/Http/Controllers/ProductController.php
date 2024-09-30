<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Mail\ProductCreated;
use App\Mail\ProductUpdated;
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
        $products = Product::orderby('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'product' => $products
        ], 200); //código 200 Sucesso na solicitação
    }
    public function show($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produto não encontrado.',
            ], 404);
        }
        $product->image = $product->image ? Storage::url($product->image) : null;
        return response()->json([
            'status' => true,
            'product' => $product,
        ], 200);
    }


    //Criar produto
    public function store(ProductRequest $request) : JsonResponse
    {
        $productData = $request->only(['name', 'price', 'description']);
        $productData['user_id'] = Auth::id();

        //Upload de imagem (se for fornecida)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('/', 'public');
            $productData['image'] = Storage::url($imagePath);
        }
        $product = Product::create($productData);

        //Queue de email a ser enviado
        try {
            Mail::to($request->user())->queue(new ProductCreated($product));
        } catch (\Exception $e) {
            Log::error('Falha no envio de E-mail', ['Erro' => $e->getMessage()]);
        }
        return response()->json([
            'message' => 'Produto cadastrado com sucesso, e email enviado!',
            'product' => $product,
        ], 201);
    }

    //Editar produto
    public function update(ProductRequest $request, Product $product) : JsonResponse
    {
        if ($product->user_id != Auth::id()) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        try {
            $product->update($request->except(['image']));

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $request->file('image')->store('products', 'public');
                $product->save();
            }

            //Envia o email de alteração do produto
            Mail::to($request->user())->queue(new ProductUpdated($product));
        }catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o produto',
                'erro' => $e->getMessage()
            ], 500);
        }
        return response()->json([
            'message' => 'Produto atualizado com sucesso, você receberá um e-mail email!',
            'product' => $product,
        ], 200);
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
