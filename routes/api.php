<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as Product;
use App\Http\Controllers\AuthenticatorController as Authenticator;
use App\Http\Controllers\CustomerController as Customer;
use App\Http\Controllers\TransactionController as Transaction;
use App\Http\Controllers\AdminController as Admin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Admin routes
Route::get('adminList', [Admin::class, 'adminList']);

// Transaction routes
Route::post('insertTransaction', [Transaction::class, 'insertTransaction']);
Route::get('listTransaction', [Transaction::class, 'listTransaction']);
Route::get('listTransaction/{CustomerID}', [Transaction::class, 'listTransaction']);
Route::get('historyTransaksi/{CustomerID}', [Transaction::class, 'historyTransaksi']);
Route::delete('deleteTransaction', [Transaction::class, 'deleteTransaction']);
Route::post('updateTransaction/{TransactionID}', [Transaction::class, 'updateTransaction']);
Route::get('incomeTransaction', [Transaction::class, 'incomeTransaction']);
Route::get('notificationTransaction', [Transaction::class, 'notificationTransaction']);
Route::get('total', [Transaction::class, 'total']);

// Product routes
Route::get('listProduct', [Product::class, 'listProduct']);
Route::get('getProduct/{productID}', [Product::class, 'getProduct']);
Route::post('updateProduct/{productID}', [Product::class, 'updateProduct']);
Route::post('insertProduct', [Product::class, 'insertProduct']);
Route::delete('deleteProduct/{productID}', [Product::class, 'deleteProduct']);

// Auth routes
Route::post('authenticated', [Authenticator::class, 'authenticated']);

// Customer routes
Route::post('CustomerRegister', [Customer::class, 'CustomerRegister']);
