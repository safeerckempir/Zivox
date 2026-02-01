<x-guest-layout>
    <div id="login-form">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Success Message (hidden by default) -->
        <div id="success-message" class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ __('Login successful! Redirecting to dashboard...') }}
        </div>

        <!-- Error Message (hidden by default) -->
        <div id="error-message" class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul id="error-list"></ul>
        </div>

        <form id="ajax-login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" id="login-button" class="ms-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <span id="button-text">{{ __('Log in') }}</span>
                    <span id="loading-spinner" class="hidden ml-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('ajax-login-form');
            const submitButton = document.getElementById('login-button');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            const errorList = document.getElementById('error-list');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                submitButton.disabled = true;
                buttonText.textContent = '{{ __('Logging in...') }}';
                loadingSpinner.classList.remove('hidden');
                
                // Hide previous messages
                successMessage.classList.add('hidden');
                errorMessage.classList.add('hidden');
                
                // Get form data
                const formData = new FormData(form);
                
                // Send AJAX request
                fetch('{{ route('login') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        successMessage.classList.remove('hidden');
                        
                        // Clear form
                        form.reset();
                        
                        // Redirect to dashboard after delay
                        setTimeout(() => {
                            window.location.href = data.redirect || '{{ route('dashboard') }}';
                        }, 1500);
                    } else {
                        // Show validation errors
                        if (data.errors) {
                            errorList.innerHTML = '';
                            Object.keys(data.errors).forEach(key => {
                                data.errors[key].forEach(error => {
                                    const li = document.createElement('li');
                                    li.textContent = error;
                                    errorList.appendChild(li);
                                });
                            });
                            errorMessage.classList.remove('hidden');
                        } else {
                            // Show general error
                            errorList.innerHTML = '<li>' + (data.message || '{{ __('Login failed. Please try again.') }}') + '</li>';
                            errorMessage.classList.remove('hidden');
                        }
                        
                        // Reset button state
                        submitButton.disabled = false;
                        buttonText.textContent = '{{ __('Log in') }}';
                        loadingSpinner.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Login error:', error);
                    
                    // Show error message
                    errorList.innerHTML = '<li>{{ __('An error occurred. Please try again.') }}</li>';
                    errorMessage.classList.remove('hidden');
                    
                    // Reset button state
                    submitButton.disabled = false;
                    buttonText.textContent = '{{ __('Log in') }}';
                    loadingSpinner.classList.add('hidden');
                });
            });
        });
    </script>
</x-guest-layout>
