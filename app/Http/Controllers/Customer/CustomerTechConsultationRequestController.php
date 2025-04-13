<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultationResponse;
use App\Models\TechConsultationRequest;
use Illuminate\Support\Facades\Auth;


class CustomerTechConsultationRequestController extends Controller
{
    // Customer functions
    
   /**
 * Show the form for creating a new consultation request
 * No longer needed as a separate route since we're using a modal
 */
public function create()
{
    // This can be removed or kept as a fallback for non-JS users
    return redirect()->route('consultations.index');
}

/**
 * Store a newly created consultation request
 * Updated to support AJAX requests from the modal
 */
/**
 * Store a newly created consultation request
 * Updated to use a regular form submission
 */
public function store(Request $request)
{
    $request->validate([
        'request_details' => 'required|string',
    ]);
    
    $consultationRequest = TechConsultationRequest::create([
        'user_id' => Auth::id(),
        'request_details' => $request->request_details,
        'status' => 'pending',
    ]);
    
    // For regular form submissions, redirect with a flash message
    return redirect()->route('consultations.index')
        ->with('success', 'Consultation request submitted successfully!');
}
/**
 * Display all consultation requests for the authenticated customer
 * Updated to include the modal form
 */
public function index()
{
    $consultationRequests = TechConsultationRequest::where('user_id', Auth::id())
        ->with('responses.technician')
        ->orderBy('created_at', 'desc')
        ->paginate(10); // ✅ paginate instead of get
        
    return view('customer.consultations_index', compact('consultationRequests'));
}
    
    /**
     * Display the specified consultation request
     */
    public function show($id)
    {
        $consultationRequest = TechConsultationRequest::with('responses.technician')
            ->findOrFail($id);
            
        // Ensure the user can only view their own requests
        if (Auth::user()->role === 'customer' && $consultationRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('customer.consultations_show', compact('consultationRequest'));
    }
    
    /**
     * Update the status of a consultation request to 'closed' (customers only)
     */
    public function close($id)
    {
        $consultationRequest = TechConsultationRequest::findOrFail($id);
        
        // Ensure only the customer who created the request can close it
        if ($consultationRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure the request is in 'resolved' state before closing
        if ($consultationRequest->status !== 'resolved') {
            return redirect()->back()
                ->with('error', 'Only resolved requests can be closed.');
        }
        
        $consultationRequest->update(['status' => 'closed']);
        
        return redirect()->route('consultations.index')
            ->with('success', 'Consultation request closed successfully!');
    }
}
