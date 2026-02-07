<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, $storeId)
    {
        $store = Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        
        if ($request->ajax()) {
            $transactions = Transaction::with('account')->where('store_id', $storeId)->latest()->get();
            return response()->json(['success' => true, 'transactions' => $transactions]);
        }
        
        return view('transactions.index', compact('store'));
    }

    public function create($storeId)
    {
        $store = Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        $accounts = Account::where('store_id', $storeId)->get();
        return view('transactions.create', compact('store', 'accounts'));
    }

    public function store(Request $request, $storeId)
    {
        Store::where('id', $storeId)->where('user_id', auth()->id())->firstOrFail();
        
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date'
        ]);

        $transaction = Transaction::create([
            'store_id' => $storeId,
            'account_id' => $validated['account_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'transaction_date' => $validated['transaction_date']
        ]);

        $account = Account::find($validated['account_id']);
        if ($validated['type'] === 'debit') {
            $account->balance += $validated['amount'];
        } else {
            $account->balance -= $validated['amount'];
        }
        $account->save();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'redirect' => route('transactions.index', $storeId)]);
        }

        return redirect()->route('transactions.index', $storeId);
    }
}
