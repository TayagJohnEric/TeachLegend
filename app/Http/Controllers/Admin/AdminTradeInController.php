<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeInListing;
use App\Models\User;
use Illuminate\Support\Facades\Storage;



class AdminTradeInController extends Controller
{
     public function index()
    {
        $listings = TradeInListing::latest()->paginate(10);
        return view('admin.trade_in_index', compact('listings'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.trade_in_create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'component_details' => 'required|string',
            'condition' => 'required|in:Like New,Used,Needs Repair',
            'pricing' => 'required|numeric',
            'status' => 'required|in:Available,Pending,Sold,Removed',
            'component_type' => 'nullable|string',
            'brand' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('tradeins', 'public');
        }

        TradeInListing::create($data);

        return redirect()->route('admin.trade-ins.index')->with('success', 'Listing created successfully.');
    }

    public function show(TradeInListing $trade_in)
    {
        return view('admin.trade_in_show', compact('trade_in'));
    }

    public function edit(TradeInListing $trade_in)
    {
        $users = User::all();
        return view('admin.trade_in_edit', compact('trade_in', 'users'));
    }

    public function update(Request $request, TradeInListing $trade_in)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'component_details' => 'required|string',
            'condition' => 'required|in:Like New,Used,Needs Repair',
            'pricing' => 'required|numeric',
            'status' => 'required|in:Available,Pending,Sold,Removed',
            'component_type' => 'nullable|string',
            'brand' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            if ($trade_in->image_path) {
                Storage::disk('public')->delete($trade_in->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('tradeins', 'public');
        }

        $trade_in->update($data);

        return redirect()->route('admin.trade-ins.index')->with('success', 'Listing updated.');
    }

    public function destroy(TradeInListing $trade_in)
    {
        if ($trade_in->image_path) {
            Storage::disk('public')->delete($trade_in->image_path);
        }

        $trade_in->delete();
        return redirect()->route('admin.trade-ins.index')->with('success', 'Listing deleted.');
    }
}
