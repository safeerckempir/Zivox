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
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_line1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                        <input type="text" name="address_line1" id="address_line1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_line2" class="block text-sm font-medium text-gray-700">Address Line 2</label>
                        <input type="text" name="address_line2" id="address_line2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" id="city" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                        <input type="text" name="state" id="state" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="postcode" class="block text-sm font-medium text-gray-700">Postcode</label>
                        <input type="text" name="postcode" id="postcode" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                        <select name="country" id="country" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Country</option>
                            <option value="United States" data-currency="USD">United States</option>
                            <option value="United Kingdom" data-currency="GBP">United Kingdom</option>
                            <option value="UAE" data-currency="AED">UAE</option>
                            <option value="Qatar" data-currency="QAR">Qatar</option>
                            <option value="India" data-currency="INR">India</option>
                            <option value="Oman" data-currency="OMR">Oman</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                        <input type="text" name="currency" id="currency" required readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                    </div>

                    <div class="mb-4">
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
document.getElementById('country').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const currency = selectedOption.getAttribute('data-currency');
    document.getElementById('currency').value = currency || '';
});

document.getElementById('store-form').addEventListener('submit', function(e) {
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
    .then(data => data.success && (window.location.href = data.redirect + '?success=1'))
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create Store';
    });
});
</script>
@endsection
