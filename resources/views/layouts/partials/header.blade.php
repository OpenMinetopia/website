<div class="flex w-full items-center justify-between">
    <!-- Left side -->
    <div class="flex items-center gap-x-4">
        <!-- Mobile menu button -->
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 dark:text-gray-200 lg:hidden" @click="mobileMenuOpen = true">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Page title (if needed) -->
        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ $title ?? 'Dashboard' }}
        </h1>
    </div>

    <!-- Right side -->
    <div class="flex items-center gap-x-4 lg:gap-x-6">
        <!-- Theme Toggle -->
        <button id="theme-toggle" 
                class="rounded-lg p-2.5 text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
            <span class="sr-only">Toggle theme</span>
            <svg id="theme-toggle-dark-icon" class="hidden size-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden size-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
            </svg>
        </button>

        <!-- Separator -->
        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10 dark:lg:bg-gray-700"></div>

        <!-- Profile dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" @click="open = !open">
                <span class="sr-only">Open user menu</span>
                <span class="inline-block size-8 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700">
                    <svg class="size-full text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
                <span class="hidden lg:flex lg:items-center">
                    <span class="ml-4 text-sm font-semibold text-gray-900 dark:text-white" aria-hidden="true">
                        {{ auth()->user()->name }}
                    </span>
                    <svg class="ml-2 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </span>
            </button>

            <!-- Dropdown menu -->
            <div x-show="open"
                @click.away="open = false"
                class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white dark:bg-gray-800 py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu-button"
                tabindex="-1">
                <a href="{{ route('profile.edit') }}" 
                   class="block px-3 py-1 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700" 
                   role="menuitem" 
                   tabindex="-1">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="block w-full text-left px-3 py-1 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700" 
                            role="menuitem" 
                            tabindex="-1">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
