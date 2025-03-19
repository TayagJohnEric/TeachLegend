<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeachnicianDashboardController extends Controller
{
    public function dashboard(){
        return view('technician.dashboard');
    }
}
