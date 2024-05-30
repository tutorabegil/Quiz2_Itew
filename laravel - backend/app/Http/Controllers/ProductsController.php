<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index(){
        $products = Products::all();

        return response()->json([
            'products' => $products,
            'method' => 'GET'
        ], 200);
    }

    public function getProductsById(Request $request){
        $userId = $request->query('user_id');
        $products = Products::where('user_id', $userId)->get();
        return response()->json([
            'products' => $products,
            'method' => 'GET'
        ], 200);
    }

    public function show($id){
        $product = Products::where('id', $id)->firstorFail();

        return response()->json([
            'product' => $product,
            'method' => 'GET'
        ], 200);
    }

    public function store(Request $request){
        $product = Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'stocks' => $request->stocks,
            'user_id' => $request->user_id,
            'price' => $request->price
        ]);

        return response()->json([
            'product' => $product,
            'method' => 'POST'
        ], 201);
    }

    public function update(Request $request, $id){
        $product = Products::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'stocks' => $request->stocks,
            'price' => $request->price
        ]);

        return response()->json([
            'count_updated_row' => $product,
            'method' => 'PUT'
        ], 200);
    }

    public function destroy($id){
        $product = Products::where('id', $id)->delete();

        return response()->json([
            'count_deleted_row' => $product,
            'method' => 'DELETE'
        ], 200);
    }
}
