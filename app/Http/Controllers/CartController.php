<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        $data['carts'] = array();
        return view('cart', $data);
    }

    public function cartadd(Request $request)
    {
        dd($request->product_id);
    }
}
