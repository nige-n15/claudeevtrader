<script setup lang="ts">
import { computed, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';

const page = usePage();
const auth = computed(() => page.props.auth);
const isAdmin = computed(() => auth.value.user?.is_admin);
const activeDealer = computed(() => auth.value.active_dealer);

const dealers = ref<any[]>([]);
const loading = ref(false);

// Load dealers for admin
const loadDealers = async () => {
    if (!isAdmin.value || dealers.value.length > 0) return;

    loading.value = true;
    try {
        const response = await fetch('/dealer/dealers');
        const data = await response.json();
        dealers.value = data.dealers || [];
    } catch (error) {
        console.error('Failed to load dealers:', error);
    } finally {
        loading.value = false;
    }
};

const switchDealer = (dealerId: number | null) => {
    router.post('/admin/switch-dealer', {
        dealer_id: dealerId,
    }, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Dropdown v-if="isAdmin" align="right" width="48" @click="loadDealers">
        <template #trigger>
            <button
                type="button"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                <svg
                    class="-ml-0.5 mr-2 h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                    />
                </svg>
                {{ activeDealer ? activeDealer.name : 'Select Dealer' }}
                <svg
                    class="ml-2 -mr-0.5 h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>
        </template>

        <template #content>
            <div class="py-1">
                <div class="px-4 py-2 text-xs text-gray-400 border-b">
                    Switch Dealer (Admin)
                </div>

                <div v-if="loading" class="px-4 py-3 text-sm text-gray-700">
                    Loading dealers...
                </div>

                <template v-else>
                    <button
                        v-if="activeDealer"
                        @click="switchDealer(null)"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 transition duration-150 ease-in-out hover:bg-red-50 focus:bg-red-100 focus:outline-none"
                    >
                        Clear Selection
                    </button>

                    <button
                        v-for="dealer in dealers"
                        :key="dealer.id"
                        @click="switchDealer(dealer.id)"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                        :class="{
                            'bg-indigo-50 text-indigo-700': activeDealer?.id === dealer.id
                        }"
                    >
                        <div class="flex flex-col">
                            <span class="font-medium">{{ dealer.name }}</span>
                            <span class="text-xs text-gray-500">
                                {{ dealer.vehicles_count }} vehicles, {{ dealer.leads_count }} leads
                            </span>
                        </div>
                    </button>
                </template>
            </div>
        </template>
    </Dropdown>
</template>
