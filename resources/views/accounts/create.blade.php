@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6">Create Account - {{ $store->name }}</h2>

                <form id="account-form" method="POST" action="{{ route('accounts.store', $store->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Account Name</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <p id="name-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Account Type</label>
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Type</option>
                            <option value="asset">Asset</option>
                            <option value="liability">Liability</option>
                            <option value="equity">Equity</option>
                            <option value="revenue">Revenue</option>
                            <option value="expense">Expense</option>
                        </select>
                        <p id="type-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <div class="mb-4">
                        <label for="balance" class="block text-sm font-medium text-gray-700">Opening Balance</label>
                        <input type="number" name="balance" id="balance" step="0.01" value="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <p id="balance-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('accounts.index', $store->id) }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" id="submit-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('account-form').addEventListener('submit', function(e) {
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
        submitBtn.textContent = 'Create Account';
    });
});
</script>
@endsection
