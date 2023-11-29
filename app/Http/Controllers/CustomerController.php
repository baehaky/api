<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function CustomerRegister(Request $request){
        $admin = new Customer;
        $admin->CustomerID = $request->input('CustomerID');
        $admin->CustomerName = $request->input('CustomerName');
        $admin->Email = $request->input('Email');
        $admin->Password = $request->input('Password');
        $admin->save();
        return response()->json(['success'=>true,'data' => $admin]);
    }
}
