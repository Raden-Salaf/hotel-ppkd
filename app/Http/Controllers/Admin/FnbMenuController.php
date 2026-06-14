<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FnbCategory;
use App\Models\FnbMenu;
use Illuminate\Http\Request;

class FnbMenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = FnbMenu::with('category')
            ->when($request->category, fn($q) => $q->where('fnb_category_id', $request->category))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(12);

        $categories = FnbCategory::all();

        return view('admin.fnb.menus.index', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'fnb_category_id' => 'required|exists:fnb_categories,id',
            'price'           => 'required|numeric|min:0',
            'image'           => 'nullable|image|max:2048',
            'status'          => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fnb', 'public');
        }

        FnbMenu::create([...$validated, 'created_by' => auth()->id()]);

        return back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, FnbMenu $fnbMenu)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'fnb_category_id' => 'required|exists:fnb_categories,id',
            'price'           => 'required|numeric|min:0',
            'image'           => 'nullable|image|max:2048',
            'status'          => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fnb', 'public');
        }

        $fnbMenu->update($validated);

        return back()->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(FnbMenu $fnbMenu)
    {
        $fnbMenu->delete();
        return back()->with('success', 'Menu berhasil dihapus.');
    }
}