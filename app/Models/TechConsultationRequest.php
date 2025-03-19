<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechConsultationRequest extends Model
{
    protected $table = 'tech_consultation_requests';

    protected $fillable = [
        'user_id',
        'request_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
