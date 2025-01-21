<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('instances.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white font-mono">
                    {{ $instance->hostname }}
                </h1>
                <div class="flex items-center gap-2">
                    <span @class([
                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                        'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' => $instance->status === 'active',
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' => $instance->status === 'pending',
                        'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' => $instance->status === 'suspended'
                    ])>
                        <svg @class([
                            'mr-1.5 h-3 w-3',
                            'text-green-400' => $instance->status === 'active',
                            'text-yellow-400' => $instance->status === 'pending',
                            'text-red-400' => $instance->status === 'suspended'
                        ]) fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        {{ ucfirst($instance->status) }}
                    </span>
                    @if($instance->is_beta)
                        <span class="inline-flex items-center rounded-full bg-purple-100 dark:bg-purple-900/50 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:text-purple-200">
                            Beta
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Primary Information Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="p-6">
                    @if($instance->status === 'active')
                        <!-- Active Instance Information -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Portal Status</h2>
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                    <svg class="mr-1.5 h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actief
                                </span>
                            </div>

                            <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Portal URL</p>
                                        <a href="https://{{ $instance->hostname }}" target="_blank" rel="noopener"
                                            class="mt-1 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                            https://{{ $instance->hostname }}
                                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                    <a href="https://{{ $instance->hostname }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                        Portal openen
                                    </a>
                                </div>
                            </div>

                            <!-- Subscription Summary for Active Instance -->
                            @if($instance->subscriptions->isNotEmpty())
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <dl class="grid grid-cols-2 gap-4">
                                        @if($instance->subscriptions->first()->is_trial)
                                            <div class="col-span-2">
                                                <div class="rounded-lg bg-indigo-50 dark:bg-indigo-900/50 p-3">
                                                    <div class="flex">
                                                        <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <p class="ml-2 text-sm text-indigo-700 dark:text-indigo-300">
                                                            Proefperiode actief tot {{ $instance->subscriptions->first()->ends_at->format('j F Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Abonnement</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ ucfirst(str_replace('_', ' ', $instance->subscriptions->first()->duration)) }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Verloopt op</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ $instance->subscriptions->first()->ends_at->format('j F Y') }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            @endif
                        </div>

                    @else
                        <!-- Pending Instance Setup Progress -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Setup Voortgang</h2>
                                @if($instance->deployment_status === 'in_progress')
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                                        <svg class="mr-1.5 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Bezig met setup
                                    </span>
                                @endif
                            </div>

                            <!-- Setup Progress Steps -->
                            <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                                <ul class="space-y-3">
                                    @if(!$instance->subscriptions->first()->is_trial)
                                        <li class="flex items-center">
                                            <div @class([
                                                'flex-shrink-0 h-5 w-5 rounded-full border-2 flex items-center justify-center',
                                                'border-green-500 bg-green-100 dark:bg-green-900/50' => $instance->is_paid,
                                                'border-gray-300 dark:border-gray-600' => !$instance->is_paid
                                            ])>
                                                @if($instance->is_paid)
                                                    <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">Betaling verwerkt</p>
                                        </li>
                                    @endif

                                    <li class="flex items-center">
                                        <div @class([
                                            'flex-shrink-0 h-5 w-5 rounded-full border-2 flex items-center justify-center',
                                            'border-green-500 bg-green-100 dark:bg-green-900/50' => $dnsVerified,
                                            'border-gray-300 dark:border-gray-600' => !$dnsVerified
                                        ])>
                                            @if($dnsVerified)
                                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">DNS configuratie</p>
                                    </li>

                                    <li class="flex items-center">
                                        <div @class([
                                            'flex-shrink-0 h-5 w-5 rounded-full border-2 flex items-center justify-center',
                                            'border-green-500 bg-green-100 dark:bg-green-900/50' => $instance->has_set_api_tokens,
                                            'border-gray-300 dark:border-gray-600' => !$instance->has_set_api_tokens
                                        ])>
                                            @if($instance->has_set_api_tokens)
                                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">Plugin configuratie</p>
                                    </li>

                                    <li class="flex items-center">
                                        <div @class([
                                            'flex-shrink-0 h-5 w-5 rounded-full border-2 flex items-center justify-center',
                                            'border-green-500 bg-green-100 dark:bg-green-900/50' => $instance->deployment_status === 'completed',
                                            'border-blue-500 bg-blue-100 dark:bg-blue-900/50' => $instance->deployment_status === 'in_progress',
                                            'border-gray-300 dark:border-gray-600' => $instance->deployment_status === 'uncompleted'
                                        ])>
                                            @if($instance->deployment_status === 'completed')
                                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                            @elseif($instance->deployment_status === 'in_progress')
                                                <svg class="h-3 w-3 text-blue-500 animate-pulse" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">Portal deployment</p>
                                    </li>
                                </ul>
                            </div>

                            @if($instance->deployment_status === 'in_progress')
                                <div class="rounded-lg bg-blue-50 dark:bg-blue-900/50 p-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                                We zijn bezig met het opzetten van je portal. Dit kan enkele minuten duren.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($instance->deployment_status === 'failed')
                                <div class="rounded-lg bg-red-50 dark:bg-red-900/50 p-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700 dark:text-red-300">
                                                Er is iets misgegaan bij het opzetten van je portal. Ons team is op de hoogte gebracht en zal dit zo snel mogelijk oplossen.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Collapsible Configuration Sections -->
            <div x-data="{ activeSection: null }" class="space-y-4">
                <!-- DNS Configuration -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <button @click="activeSection = (activeSection === 'dns') ? null : 'dns'"
                        class="w-full p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">DNS Configuratie</h2>
                            @if($dnsVerified)
                                <span class="ml-3 inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                    Geverifieerd
                                </span>
                            @endif
                        </div>
                        <svg class="h-5 w-5 transform transition-transform duration-200"
                            :class="{ 'rotate-180': activeSection === 'dns' }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="activeSection === 'dns'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="px-6 pb-6">
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Voeg de volgende DNS record toe aan je domein:
                            </p>
                            <div class="mt-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Type</span>
                                    <span class="font-mono text-gray-900 dark:text-white">A</span>
                                </div>
                                <div class="mt-2 flex items-center justify-between text-sm">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Hostname</span>
                                    <span class="font-mono text-gray-900 dark:text-white">{{ $instance->hostname }}</span>
                                </div>
                                <div class="mt-2 flex items-center justify-between text-sm">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">IP Adres</span>
                                    <div class="flex items-center">
                                        <span class="font-mono text-gray-900 dark:text-white">{{ $serverIp }}</span>
                                        <button onclick="copyToClipboard('{{ $serverIp }}', 'ip-copy')"
                                            class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                            id="ip-copy">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <form action="{{ route('instances.verify-dns', $instance) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        DNS verificeren
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plugin Configuration -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <button @click="activeSection = (activeSection === 'plugin') ? null : 'plugin'"
                        class="w-full p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Plugin Configuratie</h2>
                            @if($instance->has_set_api_tokens)
                                <span class="ml-3 inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                    Geconfigureerd
                                </span>
                            @endif
                        </div>
                        <svg class="h-5 w-5 transform transition-transform duration-200"
                            :class="{ 'rotate-180': activeSection === 'plugin' }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="activeSection === 'plugin'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="px-6 pb-6">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Download de <a href="https://modrinth.com/plugin/openminetopia" target="_blank" rel="noopener" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">OpenMinetopia plugin</a> en voeg deze velden toe aan je <code class="text-xs bg-gray-100 dark:bg-gray-900 rounded px-1 py-0.5">config.yml</code>:
                        </p>

                        <div class="mt-4 space-y-4">
                            <div x-data="{ shown: false }">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">rest-api.api-key</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                        <input type="text" :type="shown ? 'text' : 'password'" value="{{ $instance->plugin_api_token }}" readonly
                                            class="block w-full rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">
                                    </div>
                                    <button type="button" @click="shown = !shown"
                                        class="relative -ml-px inline-flex items-center px-3 border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        :aria-label="shown ? 'Hide token' : 'Show token'">
                                        <svg x-show="!shown" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="shown" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="copyToClipboard('{{ $instance->plugin_api_token }}', 'plugin-token-button')"
                                        class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        id="plugin-token-button">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                        </svg>
                                        Kopieer
                                    </button>
                                </div>
                            </div>

                            <div x-data="{ shown: false }">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">portal.token</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                        <input type="text" :type="shown ? 'text' : 'password'" value="{{ $instance->instance_api_token }}" readonly
                                            class="block w-full rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">
                                    </div>
                                    <button type="button" @click="shown = !shown"
                                        class="relative -ml-px inline-flex items-center px-3 border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        :aria-label="shown ? 'Hide token' : 'Show token'">
                                        <svg x-show="!shown" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="shown" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="copyToClipboard('{{ $instance->instance_api_token }}', 'instance-token-button')"
                                        class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        id="instance-token-button">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                        </svg>
                                        Kopieer
                                    </button>
                                </div>
                            </div>

                            @if(!$instance->has_set_api_tokens)
                                <form action="{{ route('instances.mark-api-tokens-set', $instance) }}" method="POST" class="mt-6">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Markeren als afgehandeld
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Subscription Details -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <button @click="activeSection = (activeSection === 'subscription') ? null : 'subscription'"
                        class="w-full p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Abonnement Details</h2>
                            @if($instance->subscriptions->first()->is_trial)
                                <span class="ml-3 inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
                                    Proefperiode
                                </span>
                            @endif
                        </div>
                        <svg class="h-5 w-5 transform transition-transform duration-200"
                            :class="{ 'rotate-180': activeSection === 'subscription' }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="activeSection === 'subscription'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="px-6 pb-6">

                        @if($instance->subscriptions->isNotEmpty())
                            <div class="space-y-6">
                                <!-- Current Subscription -->
                                <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Huidig abonnement</h4>
                                    <dl class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ ucfirst(str_replace('_', ' ', $instance->subscriptions->first()->duration)) }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                            <dd class="mt-1 text-sm">
                                                @if($instance->subscriptions->first()->is_trial)
                                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
                                                        Proefperiode
                                                    </span>
                                                @else
                                                    <span @class([
                                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                                        'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' => $instance->subscriptions->first()->status === 'paid',
                                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' => $instance->subscriptions->first()->status === 'pending',
                                                        'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' => $instance->subscriptions->first()->status === 'failed'
                                                    ])>
                                                        {{ ucfirst($instance->subscriptions->first()->status) }}
                                                    </span>
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bedrag</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                €{{ number_format($instance->subscriptions->first()->amount, 2) }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Betaalmethode</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ $instance->subscriptions->first()->payment_method === 'bank_transfer' ? 'Bankoverschrijving' : 'PayPal' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Start datum</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ $instance->subscriptions->first()->starts_at->format('j F Y') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Verloop datum</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ $instance->subscriptions->first()->ends_at->format('j F Y') }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Renewal Section -->
                                @if($instance->activeSubscription() &&
                                    $instance->activeSubscription()->ends_at->isFuture() &&
                                    $instance->activeSubscription()->ends_at->diffInDays(now()) <= 14)
                                    <div class="rounded-lg bg-yellow-50 dark:bg-yellow-900/50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Abonnement verloopt binnenkort</h3>
                                                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                                    <p>Je abonnement verloopt over {{ ceil(abs($instance->activeSubscription()->ends_at->diffInDays(now()))) }} dagen. Verleng nu om ononderbroken gebruik te garanderen.</p>
                                                    <div class="mt-4">
                                                        <button type="button" @click="showPaymentModal = true"
                                                            class="inline-flex items-center rounded-md bg-yellow-800 dark:bg-yellow-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-700 dark:hover:bg-yellow-600">
                                                            Nu verlengen
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Payment Information -->
                                @if($instance->subscriptions->first()->status === 'pending')
                                    <div class="rounded-lg bg-blue-50 dark:bg-blue-900/50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Betaling in afwachting</h3>
                                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                                    <p>Je betaling wordt verwerkt. Dit kan tot 24 uur duren.</p>
                                                    <button type="button" @click="showPaymentModal = true"
                                                        class="mt-3 text-sm font-medium text-blue-800 dark:text-blue-300 hover:text-blue-700">
                                                        Bekijk betalingsgegevens →
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Geen abonnement informatie beschikbaar.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Quick Actions -->
        <div class="space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Snelle acties</h2>
                    <div class="space-y-3">
                        @if($instance->status === 'active')
                            <a href="https://{{ $instance->hostname }}" target="_blank" rel="noopener"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Portal openen
                            </a>
                        @endif

                        <button type="button" onclick="window.location.reload()"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Status verversen
                        </button>
                    </div>
                </div>
            </div>

            <!-- Trial Conversion Card (if applicable) -->
            @if($instance->subscriptions->first()->is_trial && !$instance->subscriptions->first()->trial_converted)
                <div x-data="{ showPaymentModal: false }" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="sm:flex sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                    Proefperiode actief
                                </h3>
                                <div class="mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-400">
                                    <p>Je proefperiode verloopt op {{ $instance->subscriptions->first()->ends_at->format('j F Y') }}.</p>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex sm:flex-shrink-0 sm:items-center">
                                <button type="button" @click="showPaymentModal = true"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Proefperiode omzetten
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Modal -->
                    <div x-show="showPaymentModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div x-show="showPaymentModal"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"></div>

                        <div class="fixed inset-0 z-50 overflow-y-auto">
                            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                <div x-show="showPaymentModal"
                                    x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

                                    <div class="mt-3 text-center sm:mt-5">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                            Proefperiode omzetten
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Te betalen: €{{ number_format($instance->subscriptions->first()->amount, 2) }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Payment Methods -->
                                    <div class="mt-6 space-y-6">
                                        <!-- Bank Transfer Details -->
                                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Bankoverschrijving</h4>
                                            <dl class="space-y-2">
                                                <div class="flex justify-between">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Rekeningnummer (IBAN)</dt>
                                                    <dd class="text-sm font-mono text-gray-900 dark:text-white">
                                                        {{ config('instances.payment_methods.bank_transfer.account') }}
                                                        <button onclick="copyToClipboard('{{ config('instances.payment_methods.bank_transfer.account') }}', 'bank-copy-trial')"
                                                            class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                                            id="bank-copy-trial">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                            </svg>
                                                        </button>
                                                    </dd>
                                                </div>
                                                <div class="flex justify-between">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Rekeninghouder</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-white">{{ config('instances.payment_methods.bank_transfer.name') }}</dd>
                                                </div>
                                                <div class="flex justify-between">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Referentie</dt>
                                                    <dd class="text-sm font-mono text-gray-900 dark:text-white">
                                                        INV-{{ $instance->id }}
                                                        <button onclick="copyToClipboard('INV-{{ $instance->id }}', 'ref-copy-trial')"
                                                            class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                                            id="ref-copy-trial">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                            </svg>
                                                        </button>
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>

                                        <!-- PayPal Details -->
                                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">PayPal</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Stuur de betaling naar:
                                                <span class="font-mono text-gray-900 dark:text-white">
                                                    {{ config('instances.payment_methods.paypal.email') }}
                                                    <button onclick="copyToClipboard('{{ config('instances.payment_methods.paypal.email') }}', 'paypal-copy-trial')"
                                                        class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                                        id="paypal-copy-trial">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            </p>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                Gelieve de referentie <span class="font-mono">INV-{{ $instance->id }}</span> in de omschrijving te zetten.
                                            </p>
                                        </div>

                                        <!-- Important Notes -->
                                        <div class="rounded-lg bg-yellow-50 dark:bg-yellow-900/50 p-4">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Belangrijke informatie</h3>
                                                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                                        <ul class="list-disc space-y-1 pl-5">
                                                            <li>Het kan tot 24 uur duren voordat je betaling is verwerkt</li>
                                                            <li>Je krijgt een e-mail zodra je betaling is verwerkt</li>
                                                            <li>Vergeet niet de referentie erbij te zetten</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <form action="{{ route('instances.convert-trial', $instance) }}" method="POST" class="sm:col-start-2">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                                Bevestigen
                                            </button>
                                        </form>
                                        <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:col-start-1 sm:mt-0"
                                            @click="showPaymentModal = false">
                                            Annuleren
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
function copyToClipboard(text, buttonId) {
    navigator.clipboard.writeText(text).then(() => {
        const button = document.getElementById(buttonId);
        const originalHTML = button.innerHTML;

        button.innerHTML = `
            <svg class="h-4 w-4 mr-1.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Copied!</span>
        `;

        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    });
}
</script>
