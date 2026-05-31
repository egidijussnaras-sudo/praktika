<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 1. Rodyti visų kategorijų sąrašą
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // 2. Rodyti naujos kategorijos kūrimo formą
    public function create()
    {
        return view('categories.create');
    }

    // 3. Išsaugoti naują kategoriją į DB
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategorija pridėta!');
    }

    // 4. Rodyti kategorijos redagavimo formą
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 5. Atnaujinti kategorijos duomenis DB
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategorija atnaujinta!');
    }

    // 6. Ištrinti kategoriją iš DB
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategorija ištrinta!');
    }
}