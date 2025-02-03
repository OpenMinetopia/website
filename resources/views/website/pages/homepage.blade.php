@extends('website.layouts.app')

@section('title', 'Open Source Minetopia')

@section('content')

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center bg-gradient-to-b from-white via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
        <!-- Updated background pattern -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-[radial-gradient(#ffd700_1px,transparent_1px)] [background-size:16px_16px] opacity-[0.08] dark:opacity-[0.04]"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h1 class="font-minecraft text-4xl sm:text-5xl lg:text-6xl font-bold">
                            <span class="block text-gray-900 dark:text-white">De ultieme</span>
                            <span class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text text-transparent animate-gradient">
                                Minetopia Plugin
                            </span>
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-xl">
                            Een open-source Minecraft plugin die zich focust op het namaken van het Minetopia concept.
                            <span class="text-amber-600 dark:text-amber-400">Gratis</span>,
                            <span class="text-amber-600 dark:text-amber-400">open-source</span> en
                            <span class="text-amber-600 dark:text-amber-400">gemaakt voor de community</span>.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="https://modrinth.com/plugin/openminetopia" target="_blank"
                           class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/25">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Plugin
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50 rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 border-2 border-amber-500/20 hover:border-amber-500/40">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            Portal Dashboard
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['download_count'] }}+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Plugin downloads</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['discord_members'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Discord leden</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">100%</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Open Source</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Animation -->
                <div class="relative hidden lg:block">
                    <div class="relative w-full aspect-square">
                        <!-- Animated Minecraft Items -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="relative w-96 h-96">
                                <!-- Floating Items Animation -->
                                <div class="absolute inset-0 animate-float-slow">
                                    <img src="{{ asset('images/hero/diamond.svg') }}" alt="Diamond" class="absolute top-0 left-1/4 w-16 h-16 animate-spin-slow">
                                    <img src="{{ asset('images/hero/gold_ingot.svg') }}" alt="Gold Ingot" class="absolute top-1/4 right-0 w-16 h-16 animate-bounce-slow">
                                    <img src="{{ asset('images/hero/emerald.svg') }}" alt="Emerald" class="absolute bottom-0 right-1/4 w-16 h-16 animate-spin-slow">
                                    <img src="{{ asset('images/hero/money.svg') }}" alt="Money" class="absolute bottom-1/4 left-0 w-16 h-16 animate-bounce-slow">
                                </div>
                                <!-- Center Logo -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.svg') }}" alt="OpenMinetopia Logo" class="w-48 h-48 animate-pulse-slow">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    @include('website.components.features')

    @include('website.components.portal')

@endsection
