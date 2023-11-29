<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    function insertTransaction(Request $request)
    {
        $transaction = new Transaction;
        $transaction->TransactionID = $request->input('TransactionID');
        $transaction->productID = $request->input('productID');
        $transaction->CustomerID = $request->input('CustomerID');
        $transaction->TanggalPesan = $request->input('TanggalPesan');
        $transaction->Qty = $request->input('Qty');
        $transaction->TanggalSampai = $request->input('TanggalSampai');
        $transaction->Status = $request->input('Status');
        $transaction->save();
        return response()->json(['success' => true, 'data' => $transaction]);
    }

    function listTransaction($id)
    {
        $transaksi = DB::table('transactions')
            ->select('transactions.TanggalPesan as Tanggal_Pesan', 'products.productName as Nama_Produk', 'transactions.Qty as Jumlah_Produk', DB::raw('(transactions.Qty * products.Harga) as Pembayaran'), 'transactions.Status as Status_Pengiriman')
            ->join('products', 'products.productID', '=', 'transactions.productID')
            ->where('transactions.CustomerID', $id)
            ->where('transactions.Status', "Pending")
            ->orWhere('transactions.Status', "Disiapkan")
            ->get();
        return $transaksi;
    }
    function incomeTransaction()
    {
        $transaksi = DB::table('transactions')
            ->select('products.productName', 'products.Harga', 'transactions.Qty', DB::raw('(transactions.Qty * products.Harga) as Total'))
            ->join('products', 'products.productID', '=', 'transactions.productID')
            ->get();
        return $transaksi;
    }
    function notificationTransaction()
    {
        $transaksi = DB::table('transactions')
            ->select(
                'transactions.TransactionID',
                'transactions.TanggalPesan',
                'customers.CustomerName',
                'products.productName',
                'products.Harga',
                'transactions.Qty',
                DB::raw('(transactions.Qty * products.Harga) as Total'),
                'transactions.Status'
            )
            ->join('products', 'transactions.productID', '=', 'products.productID')
            ->join('customers', 'transactions.CustomerID', '=', 'customers.CustomerID')
            ->where('transactions.Status', 'Pending')
            ->orWhere('transactions.Status', 'Disiapkan')
            ->get();
        return $transaksi;
    }

    function updateTransaction(Request $request, $id)
    {
        $status = $request->input('Status');
        $TanggalSampai = $request->input('TanggalSampai');
        $transaksi = DB::table('transactions')
            ->where('TransactionID', $id)
            ->update([
                'Status' => $status,
                'TanggalSampai' => $TanggalSampai
            ]);
        return response()->json(['success' => "true", 'message' => 'data hasbeen Update', 'data' => $transaksi]);
    }

    function total()
    {
        $transaksi = DB::table('transactions')->select(DB::raw('SUM(transactions.Qty * products.Harga) as Total_Penjualan'))->join('products', 'products.productID', '=', 'transactions.productID')->get();
        return $transaksi;
    }

    function historyTransaksi($id)
    {
        $transaksi = DB::table('transactions')
            ->select('transactions.TanggalPesan as Tanggal_Pesan', 'transactions.TanggalSampai','products.productName as Nama_Produk', 'transactions.Qty as Jumlah_Produk', DB::raw('(transactions.Qty * products.Harga) as Pembayaran'), 'transactions.Status as Status_Pengiriman')
            ->join('products', 'products.productID', '=', 'transactions.productID')
            ->where('transactions.CustomerID', $id)
            ->where('transactions.Status', "Sampai")
            ->get();
        return $transaksi;
    }
}
