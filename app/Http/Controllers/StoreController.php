<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Account;
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

    public function dashboardWidgets(Request $request)
    {
        $stores = Store::where('user_id', auth()->id())->get();
        
        $storesData = $stores->map(function($store) {
            $accountsCount = Account::where('store_id', $store->id)->count();
            $totalBalance = Account::where('store_id', $store->id)->sum('balance');
            return [
                'id' => $store->id,
                'name' => $store->name,
                'currency' => $store->currency,
                'accounts_count' => $accountsCount,
                'total_balance' => $totalBalance
            ];
        });
        
        return response()->json(['success' => true, 'stores' => $storesData]);
    }

    public function create()
    {
        return view('stores.create');
    }

    public function show($id)
    {
        $store = Store::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $accountsCount = Account::where('store_id', $id)->count();
        $totalBalance = Account::where('store_id', $id)->sum('balance');
        return view('stores.show', compact('store', 'accountsCount', 'totalBalance'));
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

    public function edit($id)
    {
        $store = Store::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
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

        $store->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Store updated successfully!',
                'redirect' => route('stores.index')
            ]);
        }

        return redirect()->route('stores.index')->with('success', 'Store updated successfully!');
    }
}
