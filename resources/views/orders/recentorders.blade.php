    <div class="container">
        <h1 class="mb-2">Recent Orders</h1>
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
                @foreach($recentOrders as $order)
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
    