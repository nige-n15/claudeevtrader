<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
        <div class="max-w-2xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                N1g3 EV Trader
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                The Dealer-First Marketplace - Coming Soon
            </p>
            <div class="bg-white rounded-lg shadow p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                    Why Dealers Choose Us
                </h2>
                <div class="space-y-4 text-left">
                    <div class="flex items-start">
                        <svg
                            class="w-6 h-6 text-green-500 mr-3 mt-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                You Control the Customer Journey
                            </h3>
                            <p class="text-gray-600">
                                No forced workflows. Choose how buyers contact
                                you.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg
                            class="w-6 h-6 text-green-500 mr-3 mt-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                Transparent Pricing
                            </h3>
                            <p class="text-gray-600">
                                Simple subscription tiers. No hidden fees or
                                per-lead charges.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg
                            class="w-6 h-6 text-green-500 mr-3 mt-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                DMS Integration
                            </h3>
                            <p class="text-gray-600">
                                Sync with Kerridge, CDK, and more. Your data
                                stays in your system.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
