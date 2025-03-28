<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcBuildConfiguration extends Model
{
    protected $table = 'pc_build_configurations';

    protected $fillable = [
        'user_id',
        'selected_components',
        'budget',
        'total_cost', // Added this field
        'estimated_performance',
    ];
  

    protected $casts = [
        'selected_components' => 'array', // Automatically converts JSON to array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
