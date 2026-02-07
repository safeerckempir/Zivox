<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        return view('stores.index');
    }

    public function list(Request $request)
    {
        $stores = Store::where('user_id', auth()->id())->latest()->get();
        return response()->json(['success' => true, 'stores' => $stores]);
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'currency' => 'required|string|max:10',
            'contact_number' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
        ]);

        Store::create(array_merge($validated, ['user_id' => auth()->id()]));

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
