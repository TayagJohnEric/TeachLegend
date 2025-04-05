<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminServiceBookingController extends Controller
{
      /**
     * Display a listing of all bookings with filtering options
     */
   
     public function index(Request $request)
     {
         $query = ServiceBooking::with(['user', 'technician']);
     
         // Apply filters if they exist
         if ($request->filled('date_from') && $request->filled('date_to')) {
             $query->whereBetween('appointment_date', [
                 $request->date_from . ' 00:00:00', 
                 $request->date_to . ' 23:59:59'
             ]);
         }
     
         if ($request->filled('status')) {
             $query->where('status', $request->status);
         }
     
         if ($request->filled('user_id')) {
             $query->where('user_id', $request->user_id);
         }
     
         if ($request->filled('technician_id')) {
             $query->where('technician_id', $request->technician_id);
         }
     
         // Order by creation date instead of appointment date
         $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
         
         // Get data for filters
         $users = User::where('role', 'customer')->get();
         $technicians = User::where('role', 'technician')->get();
         $statuses = ServiceBooking::distinct('status')->pluck('status')->toArray();
     
         return view('admin.service_bookings', compact(
             'bookings', 'users', 'technicians', 'statuses'
         ));
     }
   /**
    * Show details of a specific booking
    */
   public function show($id)
   {
       $booking = ServiceBooking::with(['user', 'technician'])->findOrFail($id);
       $technicians = User::where('role', 'technician')->get();
       
       return view('admin.bookings_show', compact('booking', 'technicians'));
   }

   /**
    * Assign a technician to a booking and update its status
    */
   public function assignTechnician(Request $request, $id)
   {
       $request->validate([
           'technician_id' => 'required|exists:users,id',
       ]);

       $booking = ServiceBooking::findOrFail($id);
       $booking->technician_id = $request->technician_id;
       $booking->status = 'assigned';
       $booking->save();

       return redirect()->route('admin.bookings.show', $booking->id)
           ->with('success', 'Technician assigned and booking approved successfully');
   }

   /**
    * Update the status of a booking
    */
   public function updateStatus(Request $request, $id)
   {
       $request->validate([
           'status' => 'required|in:pending,approved,in_progress,completed,cancelled',
       ]);

       $booking = ServiceBooking::findOrFail($id);
       $booking->status = $request->status;
       $booking->save();

       return redirect()->route('admin.bookings.index')
           ->with('success', 'Booking status updated successfully');
   }

   /**
    * Handle booking cancellations
    */
   public function handleCancellation($id)
   {
       $booking = ServiceBooking::findOrFail($id);
       $booking->status = 'cancelled';
       $booking->save();

       return redirect()->route('admin.bookings.index')
           ->with('success', 'Booking has been cancelled');
   }

   /**
    * Soft delete a booking
    */
   public function softDelete($id)
   {
       $booking = ServiceBooking::findOrFail($id);
       $booking->delete(); // This will use the softDeletes functionality

       return redirect()->route('admin.bookings.index')
           ->with('success', 'Booking has been archived');
   }

   /**
    * Bulk soft delete old bookings
    */
   public function bulkSoftDelete(Request $request)
   {
       $request->validate([
           'date_before' => 'required|date',
           'status' => 'required|in:all,completed,cancelled',
       ]);

       $query = ServiceBooking::where('appointment_date', '<', $request->date_before);
       
       if ($request->status !== 'all') {
           $query->where('status', $request->status);
       }

       $count = $query->count();
       $query->delete(); // Soft delete

       return redirect()->route('admin.bookings.index')
           ->with('success', $count . ' old bookings have been archived');
   }
}
