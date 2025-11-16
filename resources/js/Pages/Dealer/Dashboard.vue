<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

interface Props {
    dealer: any;
    stats: {
        total_vehicles: number;
        active_vehicles: number;
        reserved_vehicles: number;
        sold_vehicles: number;
        total_leads: number;
        new_leads: number;
        contacted_leads: number;
        won_leads: number;
        total_views: number;
    };
    recentLeads: any[];
    featuredVehicles: any[];
    subscription: any;
}

defineProps<Props>();

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'GBP',
        minimumFractionDigits: 0,
    }).format(value);
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
};

const getLeadStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        new: 'bg-blue-100 text-blue-800',
        contacted: 'bg-yellow-100 text-yellow-800',
        qualified: 'bg-purple-100 text-purple-800',
        won: 'bg-green-100 text-green-800',
        lost: 'bg-red-100 text-red-800',
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <Head title="Dealer Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ dealer.name }} - Dashboard
                </h2>
                <div v-if="subscription" class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        {{ subscription.plan_name }} Plan
                    </span>
                    <span
                        class="rounded-full px-3 py-1 text-xs font-medium"
                        :class="subscription.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                    >
                        {{ subscription.status }}
                    </span>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div class="mb-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Vehicles -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-indigo-500 p-3">
                                    <svg
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-gray-500">
                                            Total Vehicles
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total_vehicles }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between text-sm text-gray-600">
                                <span>Active: {{ stats.active_vehicles }}</span>
                                <span>Reserved: {{ stats.reserved_vehicles }}</span>
                                <span>Sold: {{ stats.sold_vehicles }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Leads -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-green-500 p-3">
                                    <svg
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-gray-500">
                                            Total Leads
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total_leads }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between text-sm text-gray-600">
                                <span>New: {{ stats.new_leads }}</span>
                                <span>Contacted: {{ stats.contacted_leads }}</span>
                                <span>Won: {{ stats.won_leads }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Views -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-yellow-500 p-3">
                                    <svg
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-gray-500">
                                            Total Views
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total_views.toLocaleString() }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Status -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-purple-500 p-3">
                                    <svg
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-gray-500">
                                            Vehicle Limit
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ subscription?.vehicle_limit || 'Unlimited' }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4 text-sm text-gray-600">
                                {{ stats.active_vehicles }} /
                                {{ subscription?.vehicle_limit || '∞' }} used
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Leads -->
                <div class="mb-8 overflow-hidden rounded-lg bg-white shadow">
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Recent Leads
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Customer
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Vehicle
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Type
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Status
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="lead in recentLeads"
                                    :key="lead.id"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ lead.customer_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ lead.customer_email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ lead.vehicle?.full_title }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="text-sm capitalize text-gray-900">
                                            {{ lead.type }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                            :class="getLeadStatusColor(lead.status)"
                                        >
                                            {{ lead.status }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ formatDate(lead.created_at) }}
                                    </td>
                                </tr>
                                <tr v-if="recentLeads.length === 0">
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No leads yet
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid gap-6 md:grid-cols-3">
                    <a
                        href="#"
                        class="flex items-center justify-between rounded-lg border border-gray-300 bg-white p-6 shadow-sm transition hover:border-indigo-500 hover:shadow-md"
                    >
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">
                                Manage Vehicles
                            </h4>
                            <p class="mt-1 text-sm text-gray-500">
                                Add, edit, or remove vehicles from your inventory
                            </p>
                        </div>
                        <svg
                            class="h-8 w-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </a>

                    <a
                        href="#"
                        class="flex items-center justify-between rounded-lg border border-gray-300 bg-white p-6 shadow-sm transition hover:border-indigo-500 hover:shadow-md"
                    >
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">
                                Manage Leads
                            </h4>
                            <p class="mt-1 text-sm text-gray-500">
                                View and manage customer inquiries
                            </p>
                        </div>
                        <svg
                            class="h-8 w-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </a>

                    <a
                        href="#"
                        class="flex items-center justify-between rounded-lg border border-gray-300 bg-white p-6 shadow-sm transition hover:border-indigo-500 hover:shadow-md"
                    >
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">
                                Buyer Journey Settings
                            </h4>
                            <p class="mt-1 text-sm text-gray-500">
                                Customize your customer contact preferences
                            </p>
                        </div>
                        <svg
                            class="h-8 w-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
