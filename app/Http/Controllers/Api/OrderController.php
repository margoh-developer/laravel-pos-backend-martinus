<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //store
    public function store(Request $request){
        $request->validate([
            //kasir_id
            'transaction_time' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'total_item' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            'order_items.*.total_price' => 'required|numeric',
            // 'payment_method' => 'required|string|in:cash,qris',
        ]);

        $order = \App\Models\Order::create([
            'transaction_time' => $request->transaction_time,
            'total_price' => $request->total_price,
            'total_item' => $request->total_item,
            'kasir_id' => $request->kasir_id,
            'payment_method' => $request->payment_method
        ]);

        foreach($request->order_items as $order_item){
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $order_item['product_id'],
                'quantity' => $order_item['quantity'],
                'total_price' => $order_item['total_price'],
                // 'payment_method' => $request->payment_method,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',

        ], 201);

    }


}
