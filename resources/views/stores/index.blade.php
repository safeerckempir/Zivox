@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">My Stores</h2>
                    <a href="{{ route('stores.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Create New Store
                    </a>
                </div>

                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 hidden"></div>

                <div id="stores-container">
                    <p class="text-gray-500 text-center py-8">Loading stores...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadStores() {
    fetch('{{ route('api.stores.list') }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('stores-container');
        
        if (data.stores.length > 0) {
            let html = '<div class="space-y-4">';
            data.stores.forEach(store => {
                const date = new Date(store.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                
                html += `
                    <div class="border border-gray-200 rounded-lg p-4">
                        <a href="/stores/${store.id}" class="text-xl font-semibold mb-2 text-blue-600 hover:text-blue-800">${store.name}</a>
                        <p class="text-gray-600">${store.address_line1}, ${store.city}, ${store.state} ${store.postcode}</p>
                        <p class="text-gray-600">${store.country} | ${store.currency}</p>
                        <p class="text-sm text-gray-500 mt-2">Contact: ${store.contact_number} | ${store.contact_email}</p>
                        <p class="text-sm text-gray-500">Created: ${formattedDate}</p>
                        <div class="mt-4 space-x-2">
                            <a href="/stores/${store.id}/edit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Edit</a>
                            <a href="/stores/${store.id}/accounts" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Accounts</a>
                            <a href="/stores/${store.id}/transactions" class="bg-purple-600 text-white px-3 py-1 rounded text-sm hover:bg-purple-700">Transactions</a>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<p class="text-gray-500 text-center py-8">No stores yet. Create your first store!</p>';
        }
    });
}

window.addEventListener('DOMContentLoaded', loadStores);

const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('success')) {
    const msg = document.getElementById('success-message');
    msg.textContent = 'Store created successfully!';
    msg.classList.remove('hidden');
    setTimeout(() => msg.classList.add('hidden'), 3000);
}
</script>
@endsection
