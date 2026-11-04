<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with('category')->latest()->paginate(10);
        return view('admin.tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'specification' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tools', 'public');
        }

        Tool::create($data);

        return redirect('/admin/tools')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Tool $tool)
    {
        $categories = Category::all();
        return view('admin.tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'specification' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($tool->image) {
                Storage::disk('public')->delete($tool->image);
            }
            $data['image'] = $request->file('image')->store('tools', 'public');
        }

        $tool->update($data);

        return redirect('/admin/tools')->with('success', 'Alat berhasil diupdate.');
    }

    public function destroy(Tool $tool)
    {
        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }
        $tool->delete();
        return back()->with('success', 'Alat berhasil dihapus.');
    }
}