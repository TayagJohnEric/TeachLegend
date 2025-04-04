<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use Illuminate\Support\Facades\Auth;

class CustomerServiceBookingController extends Controller
{
    public function index()
    {
        // Example services - in a real app, these might come from a database
        $services = [
            [
                'id' => 'pc-repair',
                'name' => 'PC Repair',
                'description' => 'Professional computer repair and maintenance services',
                'image' => 'images/services/pc-repair.jpg'
            ],
            [
                'id' => 'virus-removal',
                'name' => 'Virus Removal',
                'description' => 'Complete virus and malware removal services',
                'image' => 'images/services/virus-removal.jpg'
            ],
            [
                'id' => 'data-recovery',
                'name' => 'Data Recovery',
                'description' => 'Recover lost or deleted data from your storage devices',
                'image' => 'images/services/data-recovery.jpg'
            ],
            [
                'id' => 'hardware-upgrade',
                'name' => 'Hardware Upgrade',
                'description' => 'Upgrade your computer components for better performance',
                'image' => 'images/services/hardware-upgrade.jpg'
            ]
        ];

        return view('customer.services', compact('services'));
    }

    /**
     * Display a listing of the customer's bookings.
     */
    public function bookings()
    {
        $bookings = ServiceBooking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

            
        return view('customer.my_bookings', compact('bookings'));
    }

    /**
     * Store a newly created service booking in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'service_type' => ['required', 'string', 'max:255'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string'],
        ]);

        try {
            // Create a new service booking
            $booking = new ServiceBooking();
            $booking->user_id = Auth::id();
            $booking->service_type = $validated['service_type'];
            $booking->appointment_date = $validated['appointment_date'];
            $booking->notes = $validated['notes'] ?? null;
            $booking->status = 'pending';
            $booking->save();

            return redirect()->route('customer.bookings')
                ->with('success', 'Service booking created successfully. We will assign a technician shortly.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create booking. Please try again.');
        }
    }

    public function cancelBooking($id)
{
    $booking = ServiceBooking::findOrFail($id);

    if ($booking->status === 'cancelled') {
        return redirect()->back()->with('error', 'This booking has already been cancelled.');
    }

    $booking->update(['status' => 'cancelled']);

    return redirect()->back()->with('success', 'Your booking has been successfully cancelled.');
}
}