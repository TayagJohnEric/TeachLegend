<?php

namespace App\Services;

use App\Models\Product;

class PcBuildPerformanceService
{
    public function calculatePerformance(array $componentIds)
    {
        // Fetch components with category relationship
        $components = Product::with('category')->whereIn('id', $componentIds)->get();

        // Define the categories we care about for performance
        $performanceScores = [
            'CPU' => optional($components->firstWhere('category.name', 'CPU'))->performance_score ?? 0,
            'GPU' => optional($components->firstWhere('category.name', 'GPU'))->performance_score ?? 0,
            'RAM' => optional($components->firstWhere('category.name', 'RAM'))->performance_score ?? 0,
        ];

        // Calculate overall performance tier
        $validScores = array_filter($performanceScores); // Remove null values
        $averageScore = !empty($validScores) ? array_sum($validScores) / count($validScores) : 0;

        return $this->getPerformanceTier($averageScore);
    }

    private function getPerformanceTier($score)
    {
        if ($score > 90) return 'Extreme';
        if ($score > 70) return 'High';
        if ($score > 50) return 'Medium';
        return 'Basic';
    }
}
