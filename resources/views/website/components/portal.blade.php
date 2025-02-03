<section class="py-24 relative overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900">
        <div
            class="absolute inset-0 bg-[radial-gradient(#ffd700_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
                <span
                    class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-200 mb-4">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                    </svg>
                    Nu in beta
                </span>
            <h2 class="font-minecraft text-4xl font-bold">
                <span class="block text-gray-900 dark:text-white">De eerste open-source</span>
                <span
                    class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text text-transparent animate-gradient">
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
                <div
                    class="absolute -inset-1  from-amber-500 to-yellow-500 rounded-xl blur-lg opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>

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
                            'title' => 'Fitheid systeem',
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
                        <div
                            class="group relative bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <!-- Hover Gradient -->
                            <div
                                class="absolute inset-0 bg-gradient-to-br {{ $feature['color'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>

                            <div class="relative flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gradient-to-r {{ $feature['color'] }} flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
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
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                        <div class="relative">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Managed Hosting</h3>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Volledige ontzorging</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">€ 7,50 /mnd</span>
                            </div>
                        </div>
                    </a>

                    <a href="https://github.com/OpenMinetopia/portal" target="_blank" rel="noopener"
                       class="group relative bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 dark:from-amber-500/5 dark:to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                        <div class="relative">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Self-hosted</h3>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Host het zelf, 100% gratis</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">Gratis</span>
                                <span class="inline-flex items-center text-sm text-gray-500">
                                        Open Source
                                        <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
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
