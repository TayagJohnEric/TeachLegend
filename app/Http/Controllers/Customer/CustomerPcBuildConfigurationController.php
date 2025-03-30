<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PcBuildConfiguration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerPcBuildConfigurationController extends Controller
{
    // Display the PC Builder Page with categorized products
    public function index()
    {
        $categories = Product::with('category')
            ->select('category_id', DB::raw('GROUP_CONCAT(id) as product_ids'))
            ->groupBy('category_id')
            ->get()
            ->mapWithKeys(function ($item) {
                if ($item->category_id) {
                    $category = Category::find($item->category_id);
                    if ($category) {
                        return [$category->name => Product::whereIn('id', explode(',', $item->product_ids))->get()];
                    }
                }
                return [];
            });

        return view('customer.pc_builder_index', [
            'categories' => $categories,
        ]);
    }


    public function store(Request $request)
    {
        // Validate user input
        $request->validate([
            'selected_components' => 'required|array|min:3|max:10', // At least CPU, RAM, and Storage
            'selected_components.*' => 'exists:products,id',
            'budget' => 'required|numeric|min:500|max:500000',
        ], [
            'selected_components.required' => 'You must select at least 3 components (CPU, RAM, and Storage).',
            'selected_components.min' => 'A PC build requires at least a CPU, RAM, and storage.',
            'budget.required' => 'Please enter a budget.',
            'budget.min' => 'Budget must be at least $500.',
            'budget.max' => 'Budget cannot exceed $500,000.',
        ]);
    
        // Fetch all selected components
        $selectedComponents = Product::whereIn('id', $request->selected_components)->with('category')->get();
        
        // Debug each component's compatibility data
        foreach ($selectedComponents as $component) {
            Log::debug("Component: {$component->name} (Category: {$component->category->name})");
            Log::debug("Compatibility data:", [
                'type' => gettype($component->compatibility_data),
                'raw' => $component->compatibility_data,
                'decoded' => is_string($component->compatibility_data) ? json_decode($component->compatibility_data, true) : $component->compatibility_data
            ]);
        }
        
        // Extract category IDs for validation
        $categoryIds = $selectedComponents->pluck('category_id')->toArray();
    
        // **1️⃣ Check if the build includes essential components**
        $requiredCategories = [1, 3, 4]; // CPU, RAM, Storage
        if (array_diff($requiredCategories, $categoryIds)) {
            return back()->withInput()
                ->withErrors(['selected_components' => 'A PC build must include at least a CPU, RAM, and storage.']);
        }
    
        // **2️⃣ Prevent duplicate category selection (e.g., two CPUs)**
        $categoryCounts = $selectedComponents->groupBy('category_id')->map->count();
        foreach ($categoryCounts as $categoryId => $count) {
            if ($count > 1) {
                $categoryName = Category::find($categoryId)->name ?? 'Unknown';
                return back()->withInput()
                    ->withErrors(['selected_components' => "You have selected multiple {$categoryName} components. Please choose only one."]);
            }
        }
    
        // **3️⃣ Calculate total cost**
        $totalCost = $selectedComponents->sum('price');
    
        // **4️⃣ Ensure total cost does not exceed budget**
        if ($totalCost > $request->budget) {
            return back()->withInput()
                ->withErrors(['budget' => 'Total component cost exceeds your budget.']);
        }
    
        // **5️⃣ Check compatibility of selected components**
        Log::debug("Starting compatibility checks for build with " . count($selectedComponents) . " components");
        $compatibilityErrors = [];
    
        foreach ($selectedComponents as $selectedComponent) {
            $result = $this->checkCompatibility($selectedComponent, $selectedComponents);
            Log::debug("Compatibility check for {$selectedComponent->name} returned status: {$result['status']}");
            
            if ($result['status'] === 'error') {
                $compatibilityErrors = array_merge($compatibilityErrors, $result['messages']);
            }
        }
    
        Log::debug("Total compatibility errors found: " . count($compatibilityErrors));
        Log::debug("Errors:", $compatibilityErrors);
    
        if (!empty($compatibilityErrors)) {
            Log::debug("Redirecting back with compatibility errors");
            return back()->withInput()
                ->withErrors(['selected_components' => $compatibilityErrors]);
        }
    
        // **6️⃣ Store PC Build Configuration**
        Log::debug("No compatibility errors found, proceeding to save build");
        $pcBuild = PcBuildConfiguration::create([
            'user_id' => Auth::id(),
            'selected_components' => json_encode($request->selected_components), // Store as JSON array
            'budget' => $request->budget,
            'total_cost' => $totalCost,
        ]);
    
        return redirect()
            ->route('pc-builder.show', $pcBuild->id)
            ->with('success', 'PC Build saved successfully!');
    }
    
    private function checkCompatibility($selectedComponent, $allComponents)
    {
        // Ensure we have proper access to compatibility data
        $compatibilityIssues = [];
        $selectedData = [];
        
        // Handle different possible formats of compatibility_data
        if (is_string($selectedComponent->compatibility_data)) {
            $selectedData = json_decode($selectedComponent->compatibility_data, true) ?: [];
        } elseif (is_array($selectedComponent->compatibility_data)) {
            $selectedData = $selectedComponent->compatibility_data;
        } elseif (is_object($selectedComponent->compatibility_data)) {
            $selectedData = (array)$selectedComponent->compatibility_data;
        }
        
        Log::debug("Checking compatibility for: {$selectedComponent->name}");
        Log::debug("Selected component data:", $selectedData);
        
        // Check each component against the selected one
        foreach ($allComponents as $component) {
            // Skip checking against itself
            if ($component->id === $selectedComponent->id) continue;
            
            $componentData = [];
            // Handle different possible formats of compatibility_data
            if (is_string($component->compatibility_data)) {
                $componentData = json_decode($component->compatibility_data, true) ?: [];
            } elseif (is_array($component->compatibility_data)) {
                $componentData = $component->compatibility_data;
            } elseif (is_object($component->compatibility_data)) {
                $componentData = (array)$component->compatibility_data;
            }
            
            Log::debug("Against component: {$component->name}");
            Log::debug("Component data:", $componentData);
            
            // CPU + Motherboard compatibility check
            if (
                ($selectedComponent->category->name === 'CPU' && $component->category->name === 'Motherboard') ||
                ($selectedComponent->category->name === 'Motherboard' && $component->category->name === 'CPU')
            ) {
                $cpu = $selectedComponent->category->name === 'CPU' ? $selectedComponent : $component;
                $motherboard = $selectedComponent->category->name === 'Motherboard' ? $selectedComponent : $component;
                
                $cpuData = is_string($cpu->compatibility_data) ? 
                           json_decode($cpu->compatibility_data, true) : 
                           (array)$cpu->compatibility_data;
                           
                $motherboardData = is_string($motherboard->compatibility_data) ? 
                                  json_decode($motherboard->compatibility_data, true) : 
                                  (array)$motherboard->compatibility_data;
                
                $cpuSocket = $cpuData['socket_type'] ?? '';
                $mbSocket = $motherboardData['socket_type'] ?? '';
                
                Log::debug("CPU Socket: {$cpuSocket}, Motherboard Socket: {$mbSocket}");
                
                if ($cpuSocket && $mbSocket && $cpuSocket !== $mbSocket) {
                    $compatibilityIssues[] = "⚠️ CPU socket mismatch: {$cpu->name} uses {$cpuSocket} socket but {$motherboard->name} has {$mbSocket} socket";
                    Log::debug("COMPATIBILITY ISSUE FOUND: Socket mismatch between CPU and Motherboard");
                }
            }
            
            // RAM & Motherboard compatibility check
            if (
                ($selectedComponent->category->name === 'RAM' && $component->category->name === 'Motherboard') ||
                ($selectedComponent->category->name === 'Motherboard' && $component->category->name === 'RAM')
            ) {
                $ram = $selectedComponent->category->name === 'RAM' ? $selectedComponent : $component;
                $motherboard = $selectedComponent->category->name === 'Motherboard' ? $selectedComponent : $component;
                
                $ramData = is_string($ram->compatibility_data) ? 
                          json_decode($ram->compatibility_data, true) : 
                          (array)$ram->compatibility_data;
                          
                $motherboardData = is_string($motherboard->compatibility_data) ? 
                                  json_decode($motherboard->compatibility_data, true) : 
                                  (array)$motherboard->compatibility_data;
                
                $ramType = $ramData['ram_type'] ?? '';
                $mbRamType = $motherboardData['ram_type'] ?? '';
                
                Log::debug("RAM Type: {$ramType}, Motherboard RAM Type: {$mbRamType}");
                
                if ($ramType && $mbRamType && $ramType !== $mbRamType) {
                    $compatibilityIssues[] = "⚠️ RAM type mismatch: {$ram->name} uses {$ramType} memory but {$motherboard->name} supports {$mbRamType}";
                    Log::debug("COMPATIBILITY ISSUE FOUND: RAM type mismatch");
                }
            }
            
            // GPU & Motherboard compatibility check
            if (
                ($selectedComponent->category->name === 'GPU' && $component->category->name === 'Motherboard') ||
                ($selectedComponent->category->name === 'Motherboard' && $component->category->name === 'GPU')
            ) {
                $gpu = $selectedComponent->category->name === 'GPU' ? $selectedComponent : $component;
                $motherboard = $selectedComponent->category->name === 'Motherboard' ? $selectedComponent : $component;
                
                $gpuData = is_string($gpu->compatibility_data) ? 
                          json_decode($gpu->compatibility_data, true) : 
                          (array)$gpu->compatibility_data;
                          
                $motherboardData = is_string($motherboard->compatibility_data) ? 
                                  json_decode($motherboard->compatibility_data, true) : 
                                  (array)$motherboard->compatibility_data;
                
                $gpuSlot = $gpuData['gpu_pcie_slot'] ?? '';
                $mbGpuSlot = $motherboardData['gpu_pcie_slot'] ?? '';
                
                Log::debug("GPU PCIe Slot: {$gpuSlot}, Motherboard PCIe Slot: {$mbGpuSlot}");
                
                if ($gpuSlot && $mbGpuSlot && $gpuSlot !== $mbGpuSlot) {
                    $compatibilityIssues[] = "⚠️ GPU PCIe slot mismatch: {$gpu->name} requires {$gpuSlot} but {$motherboard->name} provides {$mbGpuSlot}";
                    Log::debug("COMPATIBILITY ISSUE FOUND: GPU PCIe slot mismatch");
                }
            }
            
            // Storage & Motherboard compatibility check
            if (
                ($selectedComponent->category->name === 'Storage' && $component->category->name === 'Motherboard') ||
                ($selectedComponent->category->name === 'Motherboard' && $component->category->name === 'Storage')
            ) {
                $storage = $selectedComponent->category->name === 'Storage' ? $selectedComponent : $component;
                $motherboard = $selectedComponent->category->name === 'Motherboard' ? $selectedComponent : $component;
                
                $storageData = is_string($storage->compatibility_data) ? 
                              json_decode($storage->compatibility_data, true) : 
                              (array)$storage->compatibility_data;
                              
                $motherboardData = is_string($motherboard->compatibility_data) ? 
                                  json_decode($motherboard->compatibility_data, true) : 
                                  (array)$motherboard->compatibility_data;
                
                $storageType = $storageData['storage_type'] ?? '';
                $mbStorageType = $motherboardData['storage_type'] ?? '';
                
                Log::debug("Storage Type: {$storageType}, Motherboard Storage Type: {$mbStorageType}");
                
                if ($storageType && $mbStorageType && $storageType !== $mbStorageType) {
                    $compatibilityIssues[] = "⚠️ Storage type mismatch: {$storage->name} uses {$storageType} but {$motherboard->name} supports {$mbStorageType}";
                    Log::debug("COMPATIBILITY ISSUE FOUND: Storage type mismatch");
                }
            }
        }
        
        Log::debug("Compatibility check complete. Issues found: " . count($compatibilityIssues));
        
        return [
            'status' => count($compatibilityIssues) > 0 ? 'error' : 'success',
            'messages' => $compatibilityIssues
        ];
    }
    // Show a specific PC Build Configuration
    public function show($id)
{
    $pcBuild = PcBuildConfiguration::with('user')->findOrFail($id);

    // Ensure selected_components is an array
    $selectedComponents = is_array($pcBuild->selected_components) 
        ? $pcBuild->selected_components 
        : json_decode($pcBuild->selected_components, true);

    $selectedProducts = Product::whereIn('id', $selectedComponents ?? [])->get();

    return view('customer.pc_builder_show', [
        'pcBuild' => $pcBuild,
        'selectedProducts' => $selectedProducts
    ]);
}


public function list()
    {
        $user = Auth::user();
    $pcBuilds = PcBuildConfiguration::with('user')
        ->where('user_id', $user->id)
        ->get();

    return view('customer.pc_builder_list', [
        'pcBuilds' => $pcBuilds
    ]);
    }

    // Delete a saved PC build
    public function destroy($id)
    {
        $pcBuild = PcBuildConfiguration::findOrFail($id);

        // Ensure the PC build belongs to the authenticated user before deleting
        if ($pcBuild->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pcBuild->delete();

        return redirect()
            ->route('pc-builder.list')
            ->with('success', 'PC Build deleted successfully.');
    }
}
