<x-app-layout>
    <div class="mb-8">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('instances.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Nieuw portal aanmaken</h1>
        </div>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Stel jouw OpenMinetopia portal in
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Form Column -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('instances.store') }}" method="POST" class="space-y-6" x-data="{ selectedDuration: '{{ old('duration') }}', selectedPayment: '{{ old('payment_method') }}' }">
                @csrf

                <!-- Hostname Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Domeinconfiguratie</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="hostname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Hostname
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="hostname" id="hostname"
                                        class="appearance-none block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                                        placeholder="portal.yourdomain.com"
                                        value="{{ old('hostname') }}"
                                        required>
                                </div>
                                @error('hostname')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Kies een subdomein voor je portal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subscription Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Abonnement</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach($durations as $duration)
                                <label class="relative flex cursor-pointer rounded-lg border-2 transition-colors duration-150 ease-in-out"
                                    :class="{
                                        'border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-indigo-900/50': selectedDuration === '{{ $duration }}',
                                        'border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500': selectedDuration !== '{{ $duration }}'
                                    }">
                                    <input type="radio" name="duration" value="{{ $duration }}"
                                        class="sr-only"
                                        x-model="selectedDuration"
                                        required>
                                    <div class="flex flex-1 flex-col p-4">
                                        <span class="block text-sm font-medium"
                                            :class="{
                                                'text-indigo-900 dark:text-indigo-200': selectedDuration === '{{ $duration }}',
                                                'text-gray-900 dark:text-white': selectedDuration !== '{{ $duration }}'
                                            }">
                                            {{ ucfirst(str_replace('_', ' ', $duration)) }}
                                        </span>
                                        <span class="mt-1 flex items-center text-sm"
                                            :class="{
                                                'text-indigo-700 dark:text-indigo-300': selectedDuration === '{{ $duration }}',
                                                'text-gray-500 dark:text-gray-400': selectedDuration !== '{{ $duration }}'
                                            }">
                                            €{{ number_format(config('instances.pricing')[$duration], 2) }}
                                        </span>
                                    </div>
                                    <svg class="absolute top-4 right-4 h-5 w-5 text-indigo-600 dark:text-indigo-400"
                                        x-show="selectedDuration === '{{ $duration }}'"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </label>
                            @endforeach
                        </div>
                        @error('duration')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Betaalmethode</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach($payment_methods as $method)
                                <label class="relative flex cursor-pointer rounded-lg border-2 transition-colors duration-150 ease-in-out"
                                    :class="{
                                        'border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-indigo-900/50': selectedPayment === '{{ $method }}',
                                        'border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500': selectedPayment !== '{{ $method }}'
                                    }">
                                    <input type="radio" name="payment_method" value="{{ $method }}"
                                        class="sr-only"
                                        x-model="selectedPayment"
                                        required>
                                    <div class="flex flex-1 flex-col p-4">
                                        <span class="block text-sm font-medium"
                                            :class="{
                                                'text-indigo-900 dark:text-indigo-200': selectedPayment === '{{ $method }}',
                                                'text-gray-900 dark:text-white': selectedPayment !== '{{ $method }}'
                                            }">
                                            {{ ucfirst(str_replace('_', ' ', $method)) }}
                                        </span>
                                    </div>
                                    <svg class="absolute top-4 right-4 h-5 w-5 text-indigo-600 dark:text-indigo-400"
                                        x-show="selectedPayment === '{{ $method }}'"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </label>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Minecraft Configuration Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Minecraft Server Configuratie</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="minecraft_server_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Server Host
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="minecraft_server_host" id="minecraft_server_host"
                                        class="appearance-none block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                                        placeholder="play.openminetopia.nl"
                                        value="{{ old('minecraft_server_host') }}"
                                        required>
                                </div>
                                @error('minecraft_server_host')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    De hostname waarop je Minecraft server draait (bijv. play.openminetopia.nl)
                                </p>
                            </div>

                            <div>
                                <label for="minecraft_plugin_ip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Plugin API Adres
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="minecraft_plugin_ip" id="minecraft_plugin_ip"
                                        class="appearance-none block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                                        placeholder="127.0.0.1:25570"
                                        value="{{ old('minecraft_plugin_ip') }}"
                                        required>
                                </div>
                                @error('minecraft_plugin_ip')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Het IP-adres en poort waar de plugin API op draait. Let op: dit is een andere poort dan je Minecraft server.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Portal aanmaken
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column - Information -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Belangrijke informatie</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Betaling verificatie</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Nadat jouw betaling binnen is, is je portaal binnen 24 uur te gebruiken.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">SSL inbegrepen</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Wij stellen een SSL-certificaat in voor je portal.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Altijd opzegbaar</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Geen contracten, geen onnozel gedoe.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vereisten</h2>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                                Publiekelijk domeinnaam
                            </p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                                Geldige betaalmethode
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
