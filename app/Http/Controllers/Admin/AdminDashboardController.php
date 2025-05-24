<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServiceBooking;
use Carbon\Carbon;




class AdminDashboardController extends Controller
{
   public function dashboard()
    {
        // Get total technicians count
        $totalTechnicians = User::where('role', 'technician')->count();
        
        // Get total customers count
        $totalCustomers = User::where('role', 'customer')->count();
        
        // Get today's bookings count
        $todaysBookings = ServiceBooking::whereDate('created_at', Carbon::today())->count();
        
        return view('admin.dashboard', compact(
            'totalTechnicians',
            'totalCustomers', 
            'todaysBookings'
        ));
    }
}
