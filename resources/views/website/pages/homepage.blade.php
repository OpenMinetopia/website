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
                            <span class="block text-gray-900 dark:text-white">De Ultieme</span>
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
                            <div class="text-sm text-gray-600 dark:text-gray-400">Actieve Servers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['discord_members'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Discord Leden</div>
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

    <!-- Features Grid Section -->
    <section class="relative py-24 bg-gradient-to-b from-gray-50 via-gray-50 to-white dark:from-gray-800 dark:via-gray-800/80 dark:to-gray-900">
        <!-- Add decorative top border -->
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-amber-500/20 to-transparent"></div>
        
        <!-- Add subtle wave pattern -->
        <div class="absolute inset-0 bg-[url('/images/patterns/grid.svg')] opacity-[0.02]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="font-minecraft text-4xl font-bold">
                    <span class="block text-gray-900 dark:text-white">Alles wat je nodig hebt</span>
                    <span class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text text-transparent animate-gradient">
                        Voor jouw Minetopia server
                    </span>
                </h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
                    OpenMinetopia komt met alle features die je verwacht van een Minetopia server, en meer!
                </p>
            </div>

            <div class="mt-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Economy System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                            Economie Systeem
                        </h3>

                        <p class="mt-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                            Een volledig economie systeem met:
                        </p>

                        <ul class="mt-4 space-y-3">
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Bankrekeningen & spaarrekeningen
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                ATM's voor transacties
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Transactiegeschiedenis
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Jobs System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                            Beroepen Systeem
                        </h3>

                        <p class="mt-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                            Uitgebreid beroepen systeem met:
                        </p>

                        <ul class="mt-4 space-y-3">
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Diverse beroepen & functies
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Werkuren & salaris systeem
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Carrière progressie
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Level System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                            Level Systeem
                        </h3>

                        <p class="mt-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                            Geavanceerd level systeem met:
                        </p>

                        <ul class="mt-4 space-y-3">
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Experience systeem
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Rank progressie
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Unieke beloningen
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Continue with more features... -->
            </div>

            <!-- View All Features Button -->
            <div class="mt-16 text-center">
                <a href="{{ route('website.features') }}"
                   class="inline-flex items-center px-8 py-4 text-lg font-medium text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/25">
                    <span>Bekijk alle features</span>
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Portal Section -->
    <section class="py-24 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900">
            <div class="absolute inset-0 bg-[radial-gradient(#ffd700_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-200 mb-4">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                    </svg>
                    Nu in Beta
                </span>
                <h2 class="font-minecraft text-4xl font-bold">
                    <span class="block text-gray-900 dark:text-white">De Eerste Open-Source</span>
                    <span class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text text-transparent animate-gradient">
                        Minetopia Portal
                    </span>
                </h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
                    Een complete web-portal voor je Minetopia server.
                    <span class="text-amber-600 dark:text-amber-400">100% open-source</span>, zonder verborgen kosten.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Portal Screenshot with Floating Elements -->
                <div class="relative group">
                    <!-- Glowing Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-yellow-500 rounded-xl blur-lg opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>

                    <!-- Main Image Container -->
                    <div class="relative rounded-xl overflow-hidden shadow-2xl">
                        <img src="/images/portal/portal-1.png" alt="OpenMinetopia Portal Dashboard"
                             class="w-full transform group-hover:scale-[1.02] transition-transform duration-500">
                    </div>
                </div>

                <!-- Portal Features -->
                <div class="space-y-8">
                    <!-- Feature Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([
                            [
                                'title' => 'Fitheid Systeem',
                                'description' => 'Beheer je conditie en gezondheid',
                                'icon' => 'heroicon-o-heart',
                                'color' => 'from-red-500 to-pink-500'
                            ],
                            [
                                'title' => 'Bankrekeningen',
                                'description' => 'Volledig banksysteem met transacties',
                                'icon' => 'heroicon-o-banknotes',
                                'color' => 'from-green-500 to-emerald-500'
                            ],
                            [
                                'title' => 'Strafblad',
                                'description' => 'Politie database met overtredingen',
                                'icon' => 'heroicon-o-document-text',
                                'color' => 'from-blue-500 to-indigo-500'
                            ],
                            [
                                'title' => 'Vergunningen',
                                'description' => 'Beheer vergunningen en certificaten',
                                'icon' => 'heroicon-o-document-check',
                                'color' => 'from-purple-500 to-violet-500'
                            ],
                            [
                                'title' => 'Bedrijven',
                                'description' => 'Registreer en beheer bedrijven',
                                'icon' => 'heroicon-o-building-office',
                                'color' => 'from-amber-500 to-yellow-500'
                            ],
                            [
                                'title' => 'Makelaar',
                                'description' => 'Koop en verkoop huizen en kavels',
                                'icon' => 'heroicon-o-home',
                                'color' => 'from-teal-500 to-cyan-500'
                            ],
                        ] as $feature)
                            <div class="group relative bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                <!-- Hover Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-br {{ $feature['color'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>

                                <div class="relative flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r {{ $feature['color'] }} flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                            @svg($feature['icon'], 'w-5 h-5 text-white')
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $feature['title'] }}
                                        </h4>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $feature['description'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Hosting Options -->
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <a href="{{ route('login') }}"
                           class="group relative bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                            <div class="relative">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Managed Hosting</h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Wij regelen alles voor je</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">€7,50/mnd</span>
                                </div>
                            </div>
                        </a>

                        <a href="https://github.com/OpenMinetopia/portal" target="_blank" rel="noopener"
                           class="group relative bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                            <div class="relative">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Self Hosting</h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Host het zelf, 100% gratis</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">€0/mnd</span>
                                    <span class="inline-flex items-center text-sm text-gray-500">
                                        Open Source
                                        <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
