<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])->orderBy('created_at', 'desc');
    
        // Apply filter if order_status is selected
        if ($request->has('order_status') && !empty($request->order_status)) {
            $query->where('order_status', $request->order_status);
        }
    
        $orders = $query->get();
    
        return view('admin.manage_orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['order_status' => $request->order_status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}


