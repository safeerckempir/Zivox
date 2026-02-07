<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Store;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request, $storeId)
    {
        $store = Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        return view('accounts.index', compact('store'));
    }

    public function list(Request $request, $storeId)
    {
        Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        $accounts = Account::where('store_id', $storeId)->get();
        return response()->json(['success' => true, 'accounts' => $accounts]);
    }

    public function create($storeId)
    {
        $store = Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        return view('accounts.create', compact('store'));
    }

    public function store(Request $request, $storeId)
    {
        Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
            'balance' => 'required|numeric|min:0'
        ]);

        Account::create([
            'store_id' => $storeId,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'balance' => $validated['balance']
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'redirect' => route('accounts.index', $storeId)]);
        }

        return redirect()->route('accounts.index', $storeId);
    }
}
