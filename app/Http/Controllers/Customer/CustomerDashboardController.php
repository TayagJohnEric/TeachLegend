<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\TechConsultationRequest;
use App\Models\ServiceBooking;
use Illuminate\Support\Carbon;

class CustomerDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $totalOrders = Order::where('user_id', $user->id)->count();

        $totalConsultations = TechConsultationRequest::where('user_id', $user->id)->count();

        $todayBooking = ServiceBooking::where('user_id', $user->id)
            ->whereDate('appointment_date', Carbon::today())
            ->exists();

        return view('customer.dashboard', compact(
            'totalOrders',
            'totalConsultations',
            'todayBooking'
        ));
    }
}

