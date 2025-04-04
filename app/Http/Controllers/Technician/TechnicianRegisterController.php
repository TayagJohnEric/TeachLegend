<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TechnicianRegisterController extends Controller
{
    // Show the technician registration form
    public function showRegistrationForm()
    {
        return view('auth.technician_signup');
    }

    // Handle technician registration
    public function registerTechnician(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone_number' => 'nullable|string|max:20',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'technician', // Ensuring the role is set as 'technician'
        ]);

        return redirect()->route('technician.signup')->with('success', 'Technician registered successfully!');
    }
}
