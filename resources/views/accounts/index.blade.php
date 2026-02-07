@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Accounts - {{ $store->name }}</h2>
                    <div>
                        <a href="{{ route('stores.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Back to Stores</a>
                        <a href="{{ route('accounts.create', $store->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Create Account
                        </a>
                    </div>
                </div>

                <div id="accounts-container">
                    <p class="text-gray-500 text-center py-8">Loading accounts...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
fetch('{{ route('accounts.index', $store->id) }}', {
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    const container = document.getElementById('accounts-container');
    
    if (data.accounts.length > 0) {
        let html = '<table class="w-full"><thead><tr class="border-b"><th class="text-left py-2">Name</th><th class="text-left py-2">Type</th><th class="text-right py-2">Balance</th></tr></thead><tbody>';
        data.accounts.forEach(account => {
            html += `<tr class="border-b"><td class="py-2">${account.name}</td><td class="py-2">${account.type}</td><td class="text-right py-2">$${parseFloat(account.balance).toFixed(2)}</td></tr>`;
        });
        html += '</tbody></table>';
        container.innerHTML = html;
    } else {
        container.innerHTML = '<p class="text-gray-500 text-center py-8">No accounts yet. Create your first account!</p>';
    }
});
</script>
@endsection
