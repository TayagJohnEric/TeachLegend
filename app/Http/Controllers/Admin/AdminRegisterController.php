<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <-- Add this line
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegisterController extends Controller
{
     // Show the registration form
     public function showRegistrationForm()
     {
         return view('auth.admin_register');
     }
 
     // Handle the registration logic
     public function register(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:6|confirmed',
             'phone_number' => 'nullable|string|max:15',
         ]);
 
         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }
 
         // Create admin user
         User::create([
             'first_name' => $request->first_name,
             'last_name' => $request->last_name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'phone_number' => $request->phone_number,
             'role' => 'admin', // Ensure only admins are created
         ]);
 
         return redirect()->route('admin.register')->with('success', 'Admin account created successfully.');
     }
}
