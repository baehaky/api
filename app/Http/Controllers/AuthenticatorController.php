<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class AuthenticatorController extends Controller
{
    function authenticated(Request $request){
        $email = $request->input('Email');
        $password = $request->input('Password');
        
        $admin = Admin::where('Email', $email)->where('Password', $password)->first();
        $customer = Customer::where('Email', $email)->where('Password', $password)->first();
        if($admin){
            return response()->json(['success'=>true,'message'=>'success','role'=>'Admin', 'data' => $admin]);
        } else if($customer){
            return response()->json(['success'=>true,'message'=>'success','role'=>'Customer', 'data' => $customer]);
        } else {
            return response()->json(['success'=>false,'message'=>'Incorrect Email or Password']);
        }
    }
}
