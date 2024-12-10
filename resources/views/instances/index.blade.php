<x-app-layout>
    <div class="mb-8 sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Your Instances</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage your OpenMinetopia instances
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('instances.create') }}" 
                class="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Create New Instance
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 rounded-md bg-green-50 dark:bg-green-900/50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($instances as $instance)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white font-mono">
                                {{ $instance->hostname }}
                            </h3>
                            <div class="mt-2 flex items-center gap-2">
                                <span @class([
                                    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                    'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' => $instance->status === 'active',
                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' => $instance->status === 'pending',
                                    'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' => $instance->status === 'suspended',
                                    'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-200' => $instance->status === 'removed'
                                ])>
                                    <svg @class([
                                        'mr-1.5 h-3 w-3',
                                        'text-green-400' => $instance->status === 'active',
                                        'text-yellow-400' => $instance->status === 'pending',
                                        'text-red-400' => $instance->status === 'suspended',
                                        'text-gray-400' => $instance->status === 'removed'
                                    ]) fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    {{ ucfirst($instance->status) }}
                                </span>
                                @if($instance->is_beta)
                                    <span class="inline-flex items-center rounded-full bg-purple-100 dark:bg-purple-900/50 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:text-purple-200">
                                        <svg class="mr-1.5 h-3 w-3 text-purple-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Beta
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-sm text-gray-500 dark:text-gray-400">v{{ $instance->version }}</span>
                            @if($instance->activeSubscription())
                                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Expires {{ $instance->activeSubscription()->ends_at->format('M j, Y') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DNS Status</dt>
                            <dd class="mt-1">
                                @if($instance->dns_verified)
                                    <span class="inline-flex items-center text-sm text-green-700 dark:text-green-400">
                                        <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-sm text-yellow-700 dark:text-yellow-400">
                                        <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        Pending verification
                                    </span>
                                @endif
                            </dd>
                        </div>
                        @if($instance->deployment_status !== 'completed')
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deployment</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center text-sm text-blue-700 dark:text-blue-400">
                                        <svg class="mr-1.5 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        In Progress
                                    </span>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                    <a href="{{ route('instances.show', $instance) }}" 
                        class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                        Manage Instance
                        <svg class="ml-1.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    @if($instance->status === 'active')
                        <a href="https://{{ $instance->hostname }}" target="_blank" rel="noopener"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Open Portal
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No instances</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new instance.</p>
                    <div class="mt-6">
                        <a href="{{ route('instances.create') }}" 
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Create Instance
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout> 