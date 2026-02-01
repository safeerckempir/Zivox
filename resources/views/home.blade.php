@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Welcome to Zivox
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Your modern web application built with Laravel
        </p>
        
        @guest
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    Sign Up
                </a>
            </div>
        @endguest
        
        @auth
            <div class="space-x-4">
                <a href="{{ route('dashboard') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                    Go to Dashboard
                </a>
            </div>
        @endauth
    </div>

    <!-- Features Section -->
    <div class="grid md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-blue-600 mb-4">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 016 0v2h2V7a5 5 0 00-5-5z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Secure Authentication</h3>
            <p class="text-gray-600">Built-in login and registration system with Laravel Breeze for secure user management.</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-green-600 mb-4">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Modern Dashboard</h3>
            <p class="text-gray-600">Clean and intuitive dashboard interface for managing your account and settings.</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-purple-600 mb-4">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">User Profiles</h3>
            <p class="text-gray-600">Complete profile management system with customizable settings and preferences.</p>
        </div>
    </div>

    <!-- User Status Section -->
    @auth
    <div class="bg-gray-100 p-6 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Welcome back, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-600 mb-4">You are successfully logged in to your Zivox account.</p>
        <div class="space-x-4">
            <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
                Dashboard
            </a>
            <a href="{{ route('profile.edit') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Edit Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
    @endguest

    @guest
    <div class="bg-blue-50 p-6 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Get Started Today</h2>
        <p class="text-gray-600 mb-4">Join our community and unlock all features. Create your free account now!</p>
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Create Account
            </a>
            <a href="{{ route('login') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Sign In
            </a>
        </div>
    </div>
    @endguest
</div>
@endsection
