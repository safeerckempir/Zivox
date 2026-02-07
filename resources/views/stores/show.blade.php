@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">{{ $store->name }}</h2>
                    <div>
                        <a href="{{ route('stores.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Back to Stores</a>
                        <a href="{{ route('stores.edit', $store->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Edit Store
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Store Information</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Address:</span> {{ $store->address_line1 }}</p>
                            @if($store->address_line2)
                                <p class="ml-16">{{ $store->address_line2 }}</p>
                            @endif
                            <p><span class="font-medium">City:</span> {{ $store->city }}</p>
                            <p><span class="font-medium">State:</span> {{ $store->state }}</p>
                            <p><span class="font-medium">Postcode:</span> {{ $store->postcode }}</p>
                            <p><span class="font-medium">Country:</span> {{ $store->country }}</p>
                            <p><span class="font-medium">Currency:</span> {{ $store->currency }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Phone:</span> {{ $store->contact_number }}</p>
                            <p><span class="font-medium">Email:</span> {{ $store->contact_email }}</p>
                        </div>

                        <h3 class="text-lg font-semibold mt-6 mb-4">Account Summary</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Total Accounts:</span> {{ $accountsCount }}</p>
                            <p><span class="font-medium">Total Balance:</span> <span class="text-green-600 font-semibold">{{ $store->currency }} {{ number_format($totalBalance, 2) }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('accounts.index', $store->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            View Accounts
                        </a>
                        <a href="{{ route('transactions.index', $store->id) }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            View Transactions
                        </a>
                        <a href="{{ route('accounts.create', $store->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Create Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
