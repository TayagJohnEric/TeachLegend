<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TechConsultationRequest extends Model
{
    use HasFactory;

    protected $table = 'tech_consultation_requests';

    protected $fillable = [
        'user_id',
        'request_details',
        'status', // Added status here
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(ConsultationResponse::class);
    }
}
