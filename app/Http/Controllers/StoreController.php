<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stores = Store::where('user_id', auth()->id())->latest()->get();
            return response()->json([
                'success' => true,
                'stores' => $stores
            ]);
        }
        return view('stores.index');
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $store = Store::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'user_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Store created successfully!',
                'redirect' => route('stores.index')
            ]);
        }

        return redirect()->route('stores.index')->with('success', 'Store created successfully!');
    }
}
