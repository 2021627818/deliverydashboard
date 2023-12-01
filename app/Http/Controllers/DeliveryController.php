<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\orders;
use App\Models\recipients;
use App\Models\customer_profiles;
use App\Models\customer_address;
use App\Models\postalcodes;
use App\Models\couriers;
use App\Model\orderstatus;
use App\Http\Controllers\OrderController;

class DeliveryController extends Controller
{
    public function assignCourier(orders $orders)
    {
        // Logic to assign courier based on conditions
        if ($orders->start_hub_id === $orders->end_hub_id) {
            // Condition 1: Same start_hub_id and end_hub_id
            $couriers = couriers::where('hub_id', $orders->start_hub_id)->firstOrFail();
            $totalCouriers = couriers::where('hub_id', $orders->start_hub_id)->count();

            // Get the next run number and update the database
            $runNumber = $couriers->getNextRunNumber();

            // Calculate the index of the record to retrieve
            $index = ($runNumber - 1) % $totalCouriers;

            // Retrieve the courier based on the calculated index
            $couriers = couriers::where('hub_id', $orders->start_hub_id)->skip($index)->take(1)->first();

            // Assign the courier to the order and update other order details
            $orders->courier_id = $couriers->courier_id;
            //$orders->status = $orders->start_hub_id === $orders->end_hub_id ? 'In Transit' : 'At Sorting Center';
            $orders->save();

        }

        else {

            $couriers = couriers::where('hub_id', 9999)->first();

            // Assign the courier to the order and update other order details
            $orders->courier_id = $couriers->courier_id;
            $orders->save();

        }

        $orders->orderstatus()->create([
            'status' => 'Order Created',
            'order_id' => $orders->order_id
        ]);


        // Redirect to a success page or do whatever is necessary
        return redirect()->route('dashboard')->with('success', 'Order created successfully');

        
        // Logic to assign a courier to the order
        // You can reuse the existing logic from the assignCourier method
        //$this->assignCourier($order);
    }
}
