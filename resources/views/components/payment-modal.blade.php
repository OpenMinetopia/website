@props(['instance', 'title' => 'Betaling', 'show' => false])

<div x-show="showPaymentModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Modal backdrop -->
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

                <!-- Payment Details Content -->
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                        {{ $title }}
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
                                    <button onclick="copyToClipboard('{{ config('instances.payment_methods.bank_transfer.account') }}', 'bank-copy')"
                                        class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                        id="bank-copy">
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
                                    <button onclick="copyToClipboard('INV-{{ $instance->id }}', 'ref-copy')"
                                        class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                        id="ref-copy">
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
                                <button onclick="copyToClipboard('{{ config('instances.payment_methods.paypal.email') }}', 'paypal-copy')"
                                    class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-500"
                                    id="paypal-copy">
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
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:col-start-2"
                        @click="showPaymentModal = false">
                        Begrepen
                    </button>
                    <button type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:col-start-1 sm:mt-0"
                        @click="showPaymentModal = false">
                        Sluit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> 