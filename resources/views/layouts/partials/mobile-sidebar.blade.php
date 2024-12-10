<div class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-data="{ open: false }" x-show="open">
    <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true" x-show="open"></div>

    <div class="fixed inset-0 flex" x-show="open">
        <div class="relative mr-16 flex w-full max-w-xs flex-1">
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                <button type="button" class="-m-2.5 p-2.5" @click="open = false">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                <div class="flex h-16 shrink-0 items-center">
                    <span class="text-xl font-bold text-white">{{ config('app.name') }}</span>
                </div>
                @include('layouts.partials.sidebar-content')
            </div>
        </div>
    </div>
</div> 