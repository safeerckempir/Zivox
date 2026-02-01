<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            try {
                $request->authenticate();

                $request->session()->regenerate();

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('dashboard', absolute: false)
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login failed. Please check your credentials.'
                ], 401);
            }
        }

        // Handle traditional form submission (fallback)
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse|RedirectResponse
    {
        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            try {
                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully!',
                    'redirect' => route('home', absolute: false)
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logout failed. Please try again.'
                ], 500);
            }
        }

        // Handle traditional form submission (fallback)
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home', absolute: false));
    }
}
