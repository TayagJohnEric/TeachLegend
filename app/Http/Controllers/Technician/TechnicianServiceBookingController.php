<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use Illuminate\Support\Facades\Auth;



class TechnicianServiceBookingController extends Controller
{

    /**
     * Display a listing of bookings assigned to the technician.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technician = Auth::user();
        
        // Get all bookings assigned to this technician
        $bookings = ServiceBooking::where('technician_id', $technician->id)
                    ->orderBy('appointment_date', 'asc')
                    ->get();
        
        return view('technician.service_bookings', compact('bookings'));
    }

    /**
     * Display the details of a specific booking.
     *
     * @param  \App\Models\ServiceBooking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceBooking $booking)
    {
        // Verify the booking belongs to this technician
        if ($booking->technician_id !== Auth::id()) {
            return redirect()->route('technician.bookings.index')
                ->with('error', 'You are not authorized to view this booking.');
        }

        return view('technician.bookings_show', compact('booking'));
    }

    /**
     * Accept a booking and change status to "in-progress".
     *
     * @param  \App\Models\ServiceBooking  $booking
     * @return \Illuminate\Http\Response
     */
    public function accept(ServiceBooking $booking)
    {
        // Verify the booking belongs to this technician
        if ($booking->technician_id !== Auth::id()) {
            return redirect()->route('technician.bookings.index')
                ->with('error', 'You are not authorized to update this booking.');
        }

        // Verify the booking is in 'assigned' status
        if ($booking->status !== 'assigned') {
            return redirect()->route('technician.bookings.show', $booking)
                ->with('error', 'This booking cannot be accepted because it is not in "Assigned" status.');
        }

        $booking->status = 'in-progress';
        $booking->save();

        return redirect()->route('technician.bookings.show', $booking)
            ->with('success', 'Booking accepted successfully. Status updated to "In Progress".');
    }

    /**
     * Cancel a booking.
     *
     * @param  \App\Models\ServiceBooking  $booking
     * @return \Illuminate\Http\Response
     */
    public function cancel(ServiceBooking $booking)
    {
        // Verify the booking belongs to this technician
        if ($booking->technician_id !== Auth::id()) {
            return redirect()->route('technician.bookings.index')
                ->with('error', 'You are not authorized to update this booking.');
        }

        // Verify the booking is not already completed or cancelled
        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return redirect()->route('technician.bookings.show', $booking)
                ->with('error', 'This booking cannot be cancelled because it is already completed or cancelled.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('technician.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Mark a booking as completed.
     *
     * @param  \App\Models\ServiceBooking  $booking
     * @return \Illuminate\Http\Response
     */
    public function complete(ServiceBooking $booking)
    {
        // Verify the booking belongs to this technician
        if ($booking->technician_id !== Auth::id()) {
            return redirect()->route('technician.bookings.index')
                ->with('error', 'You are not authorized to update this booking.');
        }

        // Verify the booking is in 'in-progress' status
        if ($booking->status !== 'in-progress') {
            return redirect()->route('technician.bookings.show', $booking)
                ->with('error', 'This booking cannot be marked as completed because it is not in "In Progress" status.');
        }

        $booking->status = 'completed';
        $booking->save();

        return redirect()->route('technician.bookings.index')
            ->with('success', 'Booking marked as completed successfully.');
    }

    /**
     * Add notes to a booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceBooking  $booking
     * @return \Illuminate\Http\Response
     */
    public function addNotes(Request $request, ServiceBooking $booking)
    {
        // Validate the request
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        // Verify the booking belongs to this technician
        if ($booking->technician_id !== Auth::id()) {
            return redirect()->route('technician.bookings.index')
                ->with('error', 'You are not authorized to update this booking.');
        }

        $booking->notes = $request->notes;
        $booking->save();

        return redirect()->route('technician.bookings.show', $booking)
            ->with('success', 'Notes added successfully.');
    }
}
