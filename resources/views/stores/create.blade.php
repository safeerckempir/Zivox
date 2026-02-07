@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6">Create New Store</h2>

                <form id="store-form" method="POST" action="{{ route('stores.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Store Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p id="name-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                        <p id="address-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('stores.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" id="submit-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Create Store
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('store-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('submit-btn');
    const formData = new FormData(form);
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Creating...';
    
    document.getElementById('name-error').classList.add('hidden');
    document.getElementById('address-error').classList.add('hidden');
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect + '?success=1';
        }
    })
    .catch(error => {
        if (error.errors) {
            if (error.errors.name) {
                document.getElementById('name-error').textContent = error.errors.name[0];
                document.getElementById('name-error').classList.remove('hidden');
            }
            if (error.errors.address) {
                document.getElementById('address-error').textContent = error.errors.address[0];
                document.getElementById('address-error').classList.remove('hidden');
            }
        }
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create Store';
    });
});
</script>
@endsection
