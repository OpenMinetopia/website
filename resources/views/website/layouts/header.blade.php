<header class="fixed w-full z-50" x-data="{ isOpen: false }">
    <nav class="max-w-7xl mx-auto mt-4">
        <div class="relative mx-4">
            <!-- Floating Navigation Bar -->
            <div class="absolute inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl border border-gray-200/20 dark:border-gray-700/20 shadow-lg"></div>

            <!-- Desktop Navigation -->
            <div class="relative flex justify-between h-14 px-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center group">
                        <span class="text-xl font-bold text-gray-900 dark:text-white relative">
                            OpenMinetopia
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-gold-600 to-gold-400 transition-all duration-200 group-hover:w-full"></span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                @click.away="open = false"
                                class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-800/50">
                            Features
                            <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-48 rounded-xl bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5">
                            <a href="{{ route('website.features') }}"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Alle Features
                            </a>
                            <a href="{{ route('website.download') }}"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Download Plugin
                            </a>
                        </div>
                    </div>

                    <a href="https://wiki.openminetopia.nl" target="_blank" rel="noopener"
                       class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-800/50">
                        Documentation
                    </a>

                    <div class="w-px h-5 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                    <!-- Theme Toggle -->
                    <button @click="darkMode = !darkMode"
                            class="p-1.5 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-colors">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                        </svg>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="ml-2 px-3 py-1.5 text-sm font-medium rounded-lg text-white bg-gradient-to-r from-gold-600 to-gold-500 hover:from-gold-700 hover:to-gold-600 transition-all duration-200 shadow-sm shadow-gold-500/20 hover:shadow-md hover:shadow-gold-500/25">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="ml-2 px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors">
                            Inloggen
                        </a>
                        <a href="{{ route('register') }}"
                           class="ml-2 px-3 py-1.5 text-sm font-medium rounded-lg text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 transition-all duration-200 shadow-sm shadow-amber-500/20 hover:shadow-md hover:shadow-amber-500/25">
                            Registreren
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center">
                    <button @click="isOpen = !isOpen"
                            class="relative w-10 h-10 focus:outline-none"
                            aria-label="Toggle Menu">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-6 transform transition-all duration-300">
                                <span class="block h-0.5 w-6 bg-gradient-to-r from-gold-600 to-gold-500 transform transition-all duration-300 ease-in-out"
                                      :class="{'rotate-45 translate-y-1.5': isOpen, '': !isOpen }"></span>
                                <span class="block h-0.5 w-6 bg-gradient-to-r from-gold-600 to-gold-500 my-1.5 transform transition-all duration-300 ease-in-out"
                                      :class="{'opacity-0': isOpen }"></span>
                                <span class="block h-0.5 w-6 bg-gradient-to-r from-gold-600 to-gold-500 transform transition-all duration-300 ease-in-out"
                                      :class="{'-rotate-45 -translate-y-1.5': isOpen, '': !isOpen }"></span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="absolute inset-x-0 top-full mt-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200/20 dark:border-gray-700/20 overflow-hidden"
                 @click.away="isOpen = false">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('website.features') }}"
                       class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        Features
                    </a>
                    <a href="https://modrinth.com/plugin/openminetopia"  target="_blank"
                       class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        Download
                    </a>
                    <a href="https://wiki.openminetopia.nl"
                       class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        Documentation
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="block px-3 py-2 text-base font-medium text-white bg-gradient-to-r from-gold-600 to-gold-500 hover:from-gold-700 hover:to-gold-600 rounded-lg transition-all duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            Inloggen
                        </a>
                        <a href="{{ route('register') }}"
                           class="block px-3 py-2 text-base font-medium text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 rounded-lg transition-all duration-200">
                            Registreren
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
