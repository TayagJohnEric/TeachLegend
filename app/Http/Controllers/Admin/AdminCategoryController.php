<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class AdminCategoryController extends Controller
{
    //This only for storinbg a category

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function destroy($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['success' => false, 'message' => 'Category not found'], 404);
    }

    $category->delete();
    
    return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
}

}
