<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller{
    public function index(){
        $products = Product::all();

        return response()->json([
            'success' => true,
            'message' => 'All product fetched successfully',
            'data' => $products
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:100',
            'detail' => 'required|max:255'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation error']);
        }
        $product = Product::create($data);

        return response([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function show($id){
        if (Product::where('id', $id)->exists()) {
            $product = Product::where('id', $id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Product successfully retrieved',
                'data' => $product], 200);
        } 
        else {
            return response()->json([
              "message" => "Product not found"
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $existingProduct = Product::find($id);

        if($existingProduct){
            $existingProduct->name = $request->name;
            $existingProduct->detail = $request->detail;
            $existingProduct->save();
            return response()->json(['message' => 'Product updated successfully', 'data' => $existingProduct], 200);
        }

        return response()->json(["message" => "Student not found"], 404);
    }

    public function destroy($id){
        $productToDelete = Product::find($id);
        if($productToDelete){
            $productToDelete->delete();
            return response()->json(['message' => 'Product deleted successfully'], 202);
        }
        
        return response()->json(["message" => "Student with id $id was not found"], 404);    
    }
    
}
