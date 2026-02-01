<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <!-- Alpine.js for basic interactivity -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <script>
            function handleLogout() {
                // Show confirmation dialog
                if (confirm('{{ __("Are you sure you want to logout?") }}')) {
                    // Get the form (could be desktop, mobile, home page, or header)
                    const form = document.getElementById('ajax-logout-form') || 
                                document.getElementById('ajax-logout-form-mobile') ||
                                document.getElementById('ajax-logout-form-home') ||
                                document.getElementById('ajax-logout-form-header');
                    
                    if (form) {
                        // Send AJAX request
                        fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message briefly
                                showNotification('{{ __("Logging out...") }}', 'success');
                                
                                // Redirect to home page after short delay
                                setTimeout(() => {
                                    window.location.href = data.redirect || '{{ route("home") }}';
                                }, 500);
                            } else {
                                // Show error message
                                showNotification(data.message || '{{ __("Logout failed. Please try again.") }}', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Logout error:', error);
                            showNotification('{{ __("An error occurred during logout.") }}', 'error');
                            
                            // Fallback: traditional form submission
                            form.submit();
                        });
                    }
                }
            }
            
            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                    type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                    type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                    'bg-blue-100 border border-blue-400 text-blue-700'
                }`;
                notification.textContent = message;
                
                // Add to page
                document.body.appendChild(notification);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 3000);
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
