<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 
        'technician_id', 
        'service_type', 
        'appointment_date', 
        'status', 
        'notes'
    ];

    /**
     * Get the customer who booked the service.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assigned technician.
     */

     protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'assigned' => 'Assigned to Technician',
            'in-progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
