<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index () 
    {
        $user = '弁当　太郎';
        $products = ['A弁当', 'B弁当', 'C弁当'];
        $orders = ['A弁当', 'B弁当'];

        return view('order', compact('user', 'products', 'orders'));
    }
}
