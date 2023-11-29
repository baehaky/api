<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    function insertProduct(Request $request)
    {
        // $data = $request->all();
        // $produk = Product::create
        $product = new Product;
        $product->productID = $request->input('productID');
        $product->productName = $request->input('productName');
        $product->ProductImage = $request->file('ProductImage')->store('products');
        $product->ProductDeskripsi = $request->input('ProductDeskripsi');
        $product->ProductRasa = $request->input('ProductRasa');
        $product->Harga = $request->input('Harga');
        $product->amount = $request->input('amount');
        $product->save();
        return response()->json(['success' => true,'data' => $product]);
    }

    function listProduct()
    {
        return Product::all();
    }

    function deleteProduct($id)
    {
        $result = Product::where('productID', $id)->delete();
        if ($result) {
            return response()->json(['success' => true, 'message' => 'data hasbeen deleted', 'data' => $result]);
        }
    }

    function getProduct($id)
    {
        $product = Product::where('productID', $id)->get();
        return $product;
    }

    function updateProduct(Request $request)
    {
        try {
            $product = Product::where('productID', $request)->get();
            $product->productName = $request->input('productName');
            // $product->imageProduct = $request->file('imageProduct')->store('products');
            // $product->detailProduct = $request->input('detailProduct');
            // $product->rasaProduct = $request->input('rasaProduct');
            // $product->rating = $request->input('rating');
            // $product->harga = $request->input('harga');
            $product->save();

            // $product->fill($request->post())->update();

            // if($request->hasFile('imageProduct')){

            //     // remove old image
            //     if($product->imageProduct){
            //         $exists = Storage::disk('public')->exists("product/{$product->imageProduct}");
            //         if($exists){
            //             Storage::disk('public')->delete("product/image/{$product->imageProduct}");
            //         }
            //     }

            //     $imageName = Str::random().'.'.$request->imageProduct->getClientOriginalExtension();
            //     Storage::disk('public')->put('product/', $request->imageProduct,$imageName);
            //     $product->imageProduct = $imageName;
            //     $product->save();
            // }

            return response()->json([
                'message' => 'Product Updated Successfully!!'
            ]);
        } catch (\Exception $e) { {
                return response()->json([
                    'message' => 'Something goes wrong while updating a product!!'
                ], 500);
            }
        }
    }
}
