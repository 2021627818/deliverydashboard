<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Informations') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex space-x-6">
            <!-- Order Details (Left) -->
            <div class="flex-1">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100"><strong>Order Details</strong></h1>
                        <table class="table table-striped table-bordered">
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Order ID:</strong></td>
                                <td> {{ $orders->order_id }}</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Description:</strong></td>
                                <td> {{ $orders->descriptions }}</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Description:</strong></td>
                                <td> {{ $orders->descriptions }}</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Parcel Weight:</strong></td>
                                <td> {{ $orders->parcel_weight }} KG</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Parcel Height:</strong></td>
                                <td> {{ $orders->parcel_height }} mm</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Parcel Length:</strong></td>
                                <td> {{ $orders->parcel_length }} mm</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Parcel Width:</strong></td>
                                <td> {{ $orders->parcel_width }} mm</p></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recipient Information (Right) -->
            <div class="flex-1">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100"><strong>Recipient Information</strong></h1>
                        <table class="table table-striped table-bordered">
                            <tr><td colspan="1"><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>First Name:</strong></td>
                            <td> {{ $orders->recipients->recipient_first_name }}</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Last Name:</strong></td>
                            <td> {{ $orders->recipients->recipient_last_name }}</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Phone Number:</strong></td>
                            <td> {{ $orders->recipients->recipient_phone_number }}</p></td></tr>
                            <tr><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400"><strong>Address:</strong></p></td>
                            <td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400">{{ $orders->recipients->recipient_address_line1 }},</p>
                            <tr><td></td><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400">{{ $orders->recipients->recipient_address_line2 }},</p>
                            <tr><td></td><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400">{{ $orders->recipients->recipient_postal_code }}, {{ $orders->recipients->recipient_city }}</p>
                            <tr><td></td><td><p class="mt-1 text-mm text-gray-600 dark:text-gray-400">{{ $orders->recipients->recipient_state }}, {{ $orders->recipients->recipient_country }}</p>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order Status (Below) -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="container">
                <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100"><strong>Order Status</strong></h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Updated</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->orderstatus as $status)
                                <tr>
                                    <td>{{ $status->updated_at }}</td>
                                    <td>{{ $status->status }}</td>
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