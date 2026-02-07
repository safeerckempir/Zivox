@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6">New Transaction - {{ $store->name }}</h2>

                <form id="transaction-form" method="POST" action="{{ route('transactions.store', $store->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="account_id" class="block text-sm font-medium text-gray-700">Account</label>
                        <select name="account_id" id="account_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Type</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" name="amount" id="amount" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="transaction_date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="transaction_date" id="transaction_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('transactions.index', $store->id) }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" id="submit-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Create Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('transaction-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const submitBtn = document.getElementById('submit-btn');
    const formData = new FormData(form);
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Creating...';
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
    })
    .then(response => response.ok ? response.json() : response.json().then(err => Promise.reject(err)))
    .then(data => data.success && (window.location.href = data.redirect))
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create Transaction';
    });
});
</script>
@endsection
