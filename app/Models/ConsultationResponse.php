<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultationResponse extends Model
{
    use HasFactory;

    protected $table = 'consultation_responses';

    protected $fillable = [
        'tech_consultation_request_id',
        'technician_id',
        'message',
    ];

    public function consultationRequest()
    {
        return $this->belongsTo(TechConsultationRequest::class, 'tech_consultation_request_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
