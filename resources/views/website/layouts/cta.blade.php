<!-- CTA Section -->
<section class="relative py-24 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-yellow-500/5 dark:from-amber-500/10 dark:to-yellow-500/10">
        <div class="absolute inset-0 bg-[radial-gradient(#ffd700_0.5px,transparent_0.5px)] [background-size:16px_16px] opacity-50"></div>
    </div>

    <!-- Animated Shapes -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-amber-400/10 dark:bg-amber-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-400/10 dark:bg-yellow-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-gold-400/10 dark:bg-gold-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-white/50 dark:bg-gray-900/50 backdrop-blur-lg rounded-3xl overflow-hidden">
            <!-- Content Container -->
            <div class="relative p-8 sm:p-12">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-full opacity-20 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-full opacity-20 blur-2xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                    <!-- Text Content -->
                    <div class="text-center lg:text-left max-w-2xl">
                        <h2 class="font-minecraft text-3xl sm:text-4xl font-bold">
                            <span class="block text-gray-900 dark:text-white">Klaar om te beginnen met</span>
                            <span class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text text-transparent animate-gradient">
                                    jouw Minetopia server?
                                </span>
                        </h2>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            Start vandaag nog met OpenMinetopia en creëer de ultieme Minetopia ervaring voor jouw spelers.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <a href="https://modrinth.com/plugin/openminetopia" target="_blank"
                           class="group relative inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/25">
                                <span class="relative flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </span>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 group-hover:ring-4 group-hover:ring-amber-500/30"></div>
                        </a>

                        <a href="https://github.com/OpenMinetopia/plugin" target="_blank" rel="noopener"
                           class="group relative inline-flex items-center justify-center px-8 py-3 text-base font-medium border-2 border-amber-500/20 hover:border-amber-500/40 text-gray-900 dark:text-white bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <span class="relative flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                    </svg>
                                    Source Code
                                </span>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 group-hover:ring-4 group-hover:ring-amber-500/10"></div>
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="mt-12 pt-8 border-t border-gray-200/20 dark:border-gray-700/20">
                    <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="text-center">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Downloads</dt>
                            <dd class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['download_count'] }}+</dd>
                        </div>
                        <div class="text-center">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Discord Leden</dt>
                            <dd class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['discord_members'] }}</dd>
                        </div>
                        <div class="text-center">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">GitHub Stars</dt>
                            <dd class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">5+</dd>
                        </div>
                        <div class="text-center">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Open Source</dt>
                            <dd class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">100%</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>
