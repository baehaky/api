<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use File;
use Illuminate\Support\Facades\DB;

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
        return response()->json(['success' => true, 'message' => 'berhasil', 'data' => $product]);
    }

    function listProduct()
    {
        return Product::all();
    }

    function deleteProduct($id)
    {
        $transaksi = DB::table('transactions')
                            ->where('productID', $id)
                            ->delete();
        $product = DB::table('products')
                            ->where('productID', $id)
                            ->delete();

        if ($product) {
            return response()->json(['success' => true, 'message' => 'data hasbeen deleted', 'data' => $product]);
        }
    }

    function getProduct($id)
    {
        $product = Product::where('productID', $id)->get();
        return $product;
    }

    function updateProduct($id, Request $request)
    {
        $productName = $request->input('productName');
        $ProductDeskripsi = $request->input('ProductDeskripsi');
        $ProductRasa = $request->input('ProductRasa');
        $Harga = $request->input('Harga');
        $id_product = DB::table('products')->where('productID', $id)->first();
        if ($id_product) {
            try {
                $product = DB::table('products')
                    ->where('productID', $id)
                    ->update(
                        ['productName' => $productName],
                        ['ProductDeskripsi' => $ProductDeskripsi],
                        ['ProductRasa' => $ProductRasa],
                        ['Harga' => $Harga]
                    );
                return response()->json([
                    'message' => 'Product Updated Successfully!!',
                    'data' => $product
                ]);
            }

            // if ($product) {
            //     $productName = $request->input('productName');

            //     try {
            //         $product->update(['productName' => $productName]);
            // return response()->json([
            //     'message' => 'Product Updated Successfully!!'
            // ]);
            //     } 
            catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }
        // }
    }
}
