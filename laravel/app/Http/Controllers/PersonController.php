<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    public function index()
    {
        $people = \App\Models\people::with("creator")->get();
        return view("people.index", compact("people"));
    }

    public function show($id)
    {
        $person = \App\Models\People::with(['children.child', 'parents.parent'])->find($id);
        if (!$person) {
            abort(404, 'Person not found');
        }
        return view('people.show', compact('person'));
    }

    public function create()
    {
        return view("people.create");
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);
    
        // Apply formatting
        $validated['first_name'] = ucfirst(strtolower($validated['first_name']));
        $validated['middle_names'] = $validated['middle_names'] 
            ? collect(explode(',', $validated['middle_names']))
                ->map(fn($name) => ucfirst(strtolower(trim($name))))
                ->implode(', ')
            : null;
        $validated['last_name'] = strtoupper($validated['last_name']);
        $validated['birth_name'] = $validated['birth_name'] 
            ? strtoupper($validated['birth_name'])
            : $validated['last_name'];
    
        $validated['created_by'] = Auth::id(); // Default to 1 if no auth system yet
    
        \App\Models\People::create($validated);
    
        return redirect()->route('people.index')->with('success', 'Person created successfully!');
    }
}
