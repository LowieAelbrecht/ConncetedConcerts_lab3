<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('accessToken')) {
            
        } else {
            echo "User should not be able to visis this pages";
        }
    }

    public function index(Request $request)
    {
        return view('/user-rooms');
    }

    public function settings(Request $request)
    {
        if($_GET){
            $request->session()->flush();
            return redirect('/login');
        }
        return view('/settings');
    }
}
