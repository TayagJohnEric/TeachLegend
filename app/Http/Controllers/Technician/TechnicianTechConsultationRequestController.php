<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\TechConsultationRequest;
use App\Models\ConsultationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TechnicianTechConsultationRequestController extends Controller
{
    /**
 * Display all consultation requests for technicians with filtering options
 * 
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\View\View
 */
public function index(Request $request)
{
    // Start with a base query
    $query = TechConsultationRequest::with(['user', 'responses']);
    
    // Apply status filter if provided
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    // Apply search filter if provided
    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        
        $query->where(function($q) use ($searchTerm) {
            // Search in consultation request details
            $q->where('request_details', 'LIKE', $searchTerm)
              // Search by ID (if search term is numeric)
              ->orWhere(function($q) use ($searchTerm) {
                  if (is_numeric(trim($searchTerm, '%'))) {
                      $q->orWhere('id', trim($searchTerm, '%'));
                  }
              })
              // Search in related user's name
              ->orWhereHas('user', function($q) use ($searchTerm) {
                  $q->where('first_name', 'LIKE', $searchTerm)
                    ->orWhere('last_name', 'LIKE', $searchTerm)
                    ->orWhereRaw('CONCAT(first_name, " ", last_name) LIKE ?', [$searchTerm]);
              });
        });
    }
    
    // Apply sorting - first by status, then by creation date
    $query->orderBy('status', 'asc')
          ->orderBy('created_at', 'desc');
    
    // Paginate the results
    $consultationRequests = $query->paginate(10);
    
    // Preserve query parameters in pagination links
    $consultationRequests->appends($request->except('page'));
    
    return view('technician.consultations_index', compact('consultationRequests'));
}
    
    /**
     * Display the specified consultation request for technicians
     */
    public function show($id)
    {
        $consultationRequest = TechConsultationRequest::with(['user', 'responses.technician'])
            ->findOrFail($id);
            
        return view('technician.consultations_show', compact('consultationRequest'));
    }
    
    /**
     * Update the status of a consultation request (technicians only)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:in_progress,resolved',
        ]);
        
        $consultationRequest = TechConsultationRequest::findOrFail($id);
        $consultationRequest->update(['status' => $request->status]);
        
        return redirect()->route('technician.consultations.show', $id)
            ->with('success', 'Status updated successfully!');
    }
    
    /**
     * Store a response to a consultation request
     */
    public function storeResponse(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        
        $consultationRequest = TechConsultationRequest::findOrFail($id);
        
        // Create the response
        ConsultationResponse::create([
            'tech_consultation_request_id' => $id,
            'technician_id' => Auth::id(),
            'message' => $request->message,
        ]);
        
        // Update the status to in_progress if currently pending
        if ($consultationRequest->status === 'pending') {
            $consultationRequest->update(['status' => 'in_progress']);
        }
        
        return redirect()->route('technician.consultations.show', $id)
            ->with('success', 'Response submitted successfully!');
    }
}
