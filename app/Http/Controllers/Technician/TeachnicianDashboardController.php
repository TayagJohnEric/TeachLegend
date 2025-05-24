<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TechConsultationRequest;
use App\Models\ServiceBooking;




class TeachnicianDashboardController extends Controller
{
     public function dashboard()
    {
        $technicianId = Auth::id();

        // Total accepted service bookings for the technician
        $totalServices = ServiceBooking::where('technician_id', $technicianId)
            ->where('status', 'accepted')
            ->count();

        // Total number of consultation requests (all)
        $totalConsultations = TechConsultationRequest::count();

        return view('technician.dashboard', compact('totalServices', 'totalConsultations'));
    }
}
