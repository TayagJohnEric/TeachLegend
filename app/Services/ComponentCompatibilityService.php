<?php

namespace App\Services;

use App\Models\Product;

class ComponentCompatibilityService
{
    public function validateComponentCompatibility(array $componentIds)
    {
        $components = Product::with('category')->whereIn('id', $componentIds)->get();
        $errors = [];

        // Find motherboard and CPU
        $motherboard = $components->first(fn($comp) => $comp->category->name === 'Motherboard');
        $cpu = $components->first(fn($comp) => $comp->category->name === 'CPU');

        // Decode JSON compatibility data safely
        $motherboardSocket = $motherboard ? json_decode($motherboard->compatibility_data, true)['socket'] ?? null : null;
        $cpuSocket = $cpu ? json_decode($cpu->compatibility_data, true)['socket'] ?? null : null;

        // Validate motherboard and CPU socket compatibility
        if ($motherboardSocket !== $cpuSocket) {
            $errors[] = "CPU and Motherboard socket types are incompatible.";
        }

        // Add more complex compatibility checks here...

        return $errors;
    }
}
