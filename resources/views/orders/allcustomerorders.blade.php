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
       <div class="container">
            <h1 class="mb-2">All Orders</h1>
            <div class="table-responsive">
            <table class="table table-striped table-bordered">
            <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Updated Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allCustomerOrders as $order)
                        <tr onclick="window.location='{{ route('orders.details', ['orderId' => $order->order_id]) }}';" style="cursor: pointer;">
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
        </div>
    </div>
</x-customer-layout>