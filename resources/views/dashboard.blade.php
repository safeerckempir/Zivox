@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="text-xl font-semibold mb-4">Welcome back!</h3>
                <p class="text-gray-600">Here's an overview of your stores and accounts.</p>
            </div>
        </div>

        <div id="widgets-container">
            <p class="text-gray-500 text-center py-8">Loading dashboard...</p>
        </div>
    </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route('api.dashboard.widgets') }}', {
        headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('widgets-container');
        
        if (data.stores.length > 0) {
            let html = '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';
            data.stores.forEach(store => {
                html += `
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">${store.name}</h4>
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Total Accounts:</span>
                                    <span class="font-semibold">${store.accounts_count}</span>
                                </div>
                                <div class="flex justify-between mb-4">
                                    <span class="text-gray-600">Total Balance:</span>
                                    <span class="font-semibold text-green-600">${store.currency} ${parseFloat(store.total_balance).toFixed(2)}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="/stores/${store.id}/accounts" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 flex-1 text-center">
                                        Accounts
                                    </a>
                                    <a href="/stores/${store.id}/transactions" class="bg-purple-600 text-white px-3 py-1 rounded text-sm hover:bg-purple-700 flex-1 text-center">
                                        Transactions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = `
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500 mb-4">You don't have any stores yet.</p>
                        <a href="/stores/create" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Create Your First Store
                        </a>
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading dashboard:', error);
        document.getElementById('widgets-container').innerHTML = '<p class="text-red-500 text-center py-8">Error loading dashboard data.</p>';
    });
});
</script>
@endsection
