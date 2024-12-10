@extends('website.layouts.app')

@section('title', 'Features - OpenMinetopia')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900">
            <div class="absolute inset-0 bg-[radial-gradient(#ffd700_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="font-minecraft text-4xl sm:text-5xl font-bold">
                    <span class="block text-gray-900 dark:text-white">Alle Features van</span>
                    <span class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text text-transparent animate-gradient">
                        OpenMinetopia
                    </span>
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Ontdek alle mogelijkheden die OpenMinetopia te bieden heeft voor jouw server.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="relative py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Economy System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 dark:from-green-500/5 dark:to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">Economie Systeem</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Een volledig economie systeem met bankrekeningen, spaarrekeningen, en ATM's.</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Meerdere bankrekeningen per speler</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Rente op spaarrekeningen</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Transactiegeschiedenis & overschrijvingen</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Jobs System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 dark:from-blue-500/5 dark:to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">Beroepen Systeem</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Uitgebreid beroepen systeem met levels, salaris en meer.</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">20+ verschillende beroepen</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Level systeem per beroep</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Automatisch salaris systeem</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Housing System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 dark:from-purple-500/5 dark:to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">Huizen Systeem</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Compleet huizen systeem met huur en koop opties.</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Huizen kopen en verkopen</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Huur systeem met automatische afschrijving</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Deurbeleid & sleutels systeem</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Police System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-orange-500/10 dark:from-red-500/5 dark:to-orange-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-red-500 to-orange-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">Politie Systeem</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Uitgebreid politie systeem met boetes en arrestaties.</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Boete systeem met historie</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Arrestatie systeem met celstraffen</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Strafblad & politie database</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Company System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">Bedrijven Systeem</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Start en beheer je eigen bedrijf.</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-amber-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Bedrijf registratie systeem</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-amber-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Werknemers management</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-amber-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Bedrijfsfinanciën & boekhouding</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Permit System -->
                <div class="group relative bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-500/10 to-cyan-500/10 dark:from-teal-500/5 dark:to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">Vergunningen Systeem</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Beheer vergunningen en certificaten.</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Verschillende type vergunningen</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Automatische verloopdatum</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Vergunning aanvraag systeem</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Download CTA -->
            <div class="mt-16 text-center">
                <a href="https://modrinth.com/plugin/openminetopia" target="_blank"
                   class="inline-flex items-center px-8 py-4 text-lg font-medium text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/25">
                    <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download OpenMinetopia
                </a>
            </div>
        </div>
    </section>
@endsection
