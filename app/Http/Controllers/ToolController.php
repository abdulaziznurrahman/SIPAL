<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $query = Tool::with('category');

        // Filter search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tools = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('tools.index', compact('tools', 'categories'));
    }

    public function show(Tool $tool)
    {
        $tool->load('category');
        return view('tools.show', compact('tool'));
    }
}