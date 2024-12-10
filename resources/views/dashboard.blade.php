<x-app-layout>
    <div class="mb-8 sm:flex sm:items-center sm:justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
            Jouw portals
        </h1>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('instances.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Nieuw portal aanmaken
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
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($instances as $instance)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ $instance->hostname }}
                    </h3>
                    <div class="mt-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $instance->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' }}">
                            {{ ucfirst($instance->status) }}
                        </span>
                    </div>
                </div>
                <div class="px-4 py-4 sm:px-6">
                    <a href="{{ route('instances.show', $instance) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                        Beheer portaal →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Je hebt nog geen portals.</p>
                    <a href="{{ route('instances.create') }}" class="mt-3 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                        Portal aanmaken →
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
