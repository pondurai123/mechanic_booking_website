<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index()
    {
        $mechanics = Mechanic::where('is_active', true)->get();
        return view('admin.mechanics.index', compact('mechanics'));
    }

    public function create()
    {
        return view('admin.mechanics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
        ]);

        Mechanic::create($request->all());

        return redirect()->route('admin.mechanics.index')
                         ->with('success', 'Mechanic added successfully!');
    }

    public function edit(Mechanic $mechanic)
    {
        return view('admin.mechanics.edit', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
        ]);

        $mechanic->update($request->all());

        return redirect()->route('admin.mechanics.index')
                         ->with('success', 'Mechanic updated successfully!');
    }

    public function destroy(Mechanic $mechanic)
    {
        $mechanic->update(['is_active' => false]);
        
        return redirect()->route('admin.mechanics.index')
                         ->with('success', 'Mechanic deactivated successfully!');
    }
}