<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

interface Props {
    dealers: any[];
}

defineProps<Props>();

const selectDealer = (dealerId: number) => {
    router.post('/admin/switch-dealer', {
        dealer_id: dealerId,
    });
};
</script>

<template>
    <Head title="Select Dealer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Select a Dealer
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">
                                Choose a dealer to manage
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                As an administrator, you can switch between different dealers to manage their accounts.
                            </p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div
                                v-for="dealer in dealers"
                                :key="dealer.id"
                                class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm transition hover:border-indigo-500 hover:shadow-md"
                            >
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900">
                                        {{ dealer.name }}
                                    </h4>
                                    <p v-if="dealer.trading_name" class="text-sm text-gray-600">
                                        {{ dealer.trading_name }}
                                    </p>
                                </div>

                                <div class="mb-4 space-y-1 text-sm text-gray-600">
                                    <p v-if="dealer.city">
                                        <span class="font-medium">Location:</span> {{ dealer.city }}, {{ dealer.county }}
                                    </p>
                                    <p v-if="dealer.email">
                                        <span class="font-medium">Email:</span> {{ dealer.email }}
                                    </p>
                                    <p v-if="dealer.phone">
                                        <span class="font-medium">Phone:</span> {{ dealer.phone }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <span
                                        class="inline-flex rounded-full px-2 py-1 text-xs font-semibold leading-5"
                                        :class="dealer.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                    >
                                        {{ dealer.status }}
                                    </span>
                                </div>

                                <PrimaryButton
                                    @click="selectDealer(dealer.id)"
                                    class="w-full justify-center"
                                >
                                    Select This Dealer
                                </PrimaryButton>
                            </div>

                            <div
                                v-if="dealers.length === 0"
                                class="col-span-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center"
                            >
                                <p class="text-gray-500">No dealers available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
