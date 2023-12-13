<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customer Dashboard') }}
            <x-primary-button style="float: right;"><a href="{{ route('orders.create') }}">Create New Order</a></x-primary-button>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('orders.recent-orders')
                    <a href="{{ route('orders.allOrders') }}" class="font-bold">See All Orders</a>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
