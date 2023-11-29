<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    function adminList()
    {
        return Admin::all();
    }
    function deleteAdmin($id)
    {
        $result = Admin::where('AdminID', $id)->delete();
        if ($result) {
            return response()->json(['success' => true, 'message' => 'data hasbeen deleted', 'data' => $result]);
        }
    }
}
