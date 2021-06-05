<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrdersController extends Controller
{
    public function list() {
		$orders = Order::orderBy('created_at', 'DESC')->get();
		return view('orders.list', compact('orders'));
	}
}
