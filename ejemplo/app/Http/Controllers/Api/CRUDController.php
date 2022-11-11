<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CRUDController extends Controller
{
    
    public function registerProducts(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'idCategory'=> 'required',
            'precio' => 'required',
            'cantidad' => 'required'
        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->idCategory = $request->idCategory;
        $product->precio = $request->precio;
        $product->cantidad = $request->cantidad;
        $product->save();
        return response()->json([
            "status" => 1,
            "msg" => "¡Registro de usuario exitoso!",
        ]);
    }
    
    public function registerCategory(Request $request) {
        $request->validate([
            'category' => 'required',
            
        ]);
        $category = new Category();
        $category->category = $request->category;
        
        $category->save();
        return response()->json([
            "status" => 1,
            "msg" => "¡Registro de usuario exitoso!",
        ]);
    }

    public function deleteCategory(Request $request) {
        $request->validate([
            'id' => 'required'
            
        ]);
        
    $category = Category::find($request -> id); 
    $category = DB::table('products')->where('id',$request ->id)->first();
    DB::table('categories')->where('id',$request ->id)->delete();

    }

    public function deleteProducts(Request $request) {
        $request->validate([
            'id' => 'required'
            
        ]);
        
    $product = Product::find($request -> id); 
    $product = DB::table('products')->where('idCategory',$request ->id)->first();
    DB::table('products')->where('idCategory',$request ->id)->delete();

    }

    public function updateProducts(Request $request) {
        $request->validate([
            'name' => '?',
            'description' => '?',
            'idCategory'=> 'required',
            'precio' => '?',
            'cantidad' => '?'
        ]);;
        
    
        DB::update('update products set name = ?, description = ?, precio = ?, cantidad = ? WHERE idCategory = ?',
        [ $request -> name, $request -> description, $request -> precio, $request -> cantidad, $request -> idCategory]);

    }

    public function updateCategory(Request $request) {
        $request->validate([
            'category' => 'required',
            'id' => 'required'
            
        ]);;
        
    
        DB::update('update categories set category = ? WHERE id = ?',
        [ $request -> category, $request -> id]);

    }

    public function readProduct(Request $request) {
        $request->validate([
            'name' => '',
            'description' => '',
            'idCategory'=> '',
            'precio' => '',
            'cantidad' => ''
            
        ]);;
        
        $product = new Product(); 
        $product = DB::select('select * FROM products WHERE idCategory = ? OR name = ? OR description = ? OR precio = ? OR cantidad = ?',
        [ $request -> idCategory , $request -> name , $request -> description , $request -> precio, $request -> cantidad]);

        return $product;
    }
}

