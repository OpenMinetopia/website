@extends('layouts.auth')

@section('title', 'Register - ' . config('app.name'))
@section('header', 'Create your account')
@section('subheader', 'Join OpenMinetopia Portal to manage your instances')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Full name
            </label>
            <div class="mt-1">
                <input id="name" name="name" type="text" required autocomplete="name"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                    value="{{ old('name') }}"
                    placeholder="John Doe">
            </div>
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email address
            </label>
            <div class="mt-1">
                <input id="email" name="email" type="email" required autocomplete="email"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                    value="{{ old('email') }}"
                    placeholder="john@example.com">
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
            </label>
            <div class="mt-1">
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                    placeholder="••••••••">
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Confirm password
            </label>
            <div class="mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                    placeholder="••••••••">
            </div>
        </div>

        <div class="flex items-center">
            <input id="terms" name="terms" type="checkbox" required
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700">
            <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                I agree to the
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Terms of Service</a>
                and
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Privacy Policy</a>
            </label>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                Create account
            </button>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Already have an account?
                </span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('login') }}"
                class="w-full flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                Sign in instead
            </a>
        </div>
    </div>
@endsection 