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
use App\Models\courierhubs;
use App\Model\orderstatus;
use App\Http\Controllers\OrderController;

class DeliveryController extends Controller
{
    public function assignPickupCourier(orders $orders)
    {
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

        $courierHub = courierhubs::find($orders->next_hub_id);
        $orders->orderstatus()->create([
            'status' => 'Order Created',
            'next_stop' => $courierHub->hub_city. ' HUB',
            'order_id' => $orders->order_id
        ]);
    }

    public function updateStatus(Request $request, $orderID)
    {

        $orders = orders::with('recipients', 'orderstatus')->find($orderID);
        $selectedOption = $request->input('dropdown');


        switch ($selectedOption) {
            case 'one':
                $courierHub = courierhubs::find($orders->next_hub_id);
                $orders->orderstatus()->create([
                'status' => 'Order Picked Up by Courier',
                'next_stop' => $courierHub->hub_city. ' HUB',
                'order_id' => $orderID
                ]);
                break;

            case 'two':

                $courierHub = courierhubs::find($orders->next_hub_id); // Assuming hub_id is the foreign key in the orders table

                if ($courierHub) {
                    $hubCity = $courierHub->hub_city;
                    $status = "Order Arrived at $hubCity HUB";
                
                    $this->assignHubCourier($orders);
                    
                    if ($orders->next_hub_id === $orders->end_hub_id){
                        $orders->orderstatus()->create([
                        'status' => $status,
                        'next_stop' => 'Deliver to Recipient',
                        'order_id' => $orderID
                        ]);
                    }

                    else {
                        $orders->orderstatus()->create([
                            'status' => $status,
                            'next_stop' => 'Sorting Center',
                            'order_id' => $orderID
                            ]);
                    }    
                }
                
                $orders->next_hub_id = $orders->end_hub_id;
                $orders->save();
                break;

            case 'three':
                //$courierHub = courierhubs::find($orders->next_hub_id);
                $orders->orderstatus()->create([
                'status' => 'Order Out For Delivery',
                'next_stop' => 'Deliver to Recipient',
                'order_id' => $orderID
                ]);
                break;

            case 'four':
                //$courierHub = courierhubs::find($orders->next_hub_id);
                $orders->orderstatus()->create([
                'status' => 'In Transit',
                'next_stop' => 'Sorting Center',
                'order_id' => $orderID
                ]);
                break;
                
            case 'five':
                $courierHub = courierhubs::find($orders->next_hub_id);
                $orders->orderstatus()->create([
                'status' => 'Order Arrived at Sorting Center',
                'next_stop' => $courierHub->hub_city. ' HUB',
                'order_id' => $orderID
                ]);

                $orders->next_hub_id = $orders->start_hub_id;
                $this->assignHubCourier($orders);
                $orders->next_hub_id = $orders->end_hub_id;
                $orders->save();
                break;

            case 'six':
                $courierHub = courierhubs::find($orders->next_hub_id);
                $orders->orderstatus()->create([
                'status' => 'In Transit',
                'next_stop' => $courierHub->hub_city. ' HUB',
                'order_id' => $orderID
                ]);
                break;

            case 'seven':
                $orders->orderstatus()->create([
                    'status' => 'Delivered',
                    'next_stop' => null,
                    'order_id' => $orderID
                ]);
                break;

            case 'eight':
                $courierHub = courierhubs::find($orders->next_hub_id);
                $orders->orderstatus()->create([
                    'status' => 'Delivery attemp was unsuccessful',
                    'next_stop' => $courierHub->hub_city. ' HUB',
                    'order_id' => $orderID
                ]);
                break;
            // Add more cases if needed
    
            default:
                // Default case, do nothing or handle as needed
                break;
        }
        

        return redirect()->route('dashboardcourier');
    }

    private function courierRotation(orders $orders)
    {
        $couriers = couriers::where('hub_id', $orders->end_hub_id)->firstOrFail();
        $totalCouriers = couriers::where('hub_id', $orders->end_hub_id)->count();

        // Get the next run number and update the database
        $runNumber = $couriers->getNextRunNumber();

        // Calculate the index of the record to retrieve
        $index = ($runNumber - 1) % $totalCouriers;

        // Retrieve the courier based on the calculated index
        $couriers = couriers::where('hub_id', $orders->end_hub_id)->skip($index)->take(1)->first();

        // Assign the courier to the order and update other order details
        $orders->courier_id = $couriers->courier_id;
        //$orders->status = $orders->start_hub_id === $orders->end_hub_id ? 'In Transit' : 'At Sorting Center';
        $orders->save();
    }

    private function courierRotation2(orders $orders)
    {
        $couriers = couriers::where('hub_id', '9999')->firstOrFail();
        $totalCouriers = couriers::where('hub_id', '9999')->count();

        // Get the next run number and update the database
        $runNumber = $couriers->getNextRunNumber();

        // Calculate the index of the record to retrieve
        $index = ($runNumber - 1) % $totalCouriers;

        // Retrieve the courier based on the calculated index
        $couriers = couriers::where('hub_id', '9999')->skip($index)->take(1)->first();

        // Assign the courier to the order and update other order details
        $orders->courier_id = $couriers->courier_id;
        //$orders->status = $orders->start_hub_id === $orders->end_hub_id ? 'In Transit' : 'At Sorting Center';
        $orders->save();
    }

    private function assignHubCourier(orders $orders)
    {
        //$courierHub = courierhubs::find($orders->start_hub_id); // Assuming hub_id is the foreign key in the orders table

        if ($orders->end_hub_id === $orders->next_hub_id){
            $this->courierRotation($orders);
        }

        else{
            $this->courierRotation2($orders);
        }
    }

    private function assignHubCourier2(orders $orders)
    {
        // Logic to assign courier based on conditions
        if ($orders->start_hub_id === $orders->end_hub_id) {
            // Condition 1: Same start_hub_id and end_hub_id
            $couriers = couriers::where('hub_id', $orders->end_hub_id)->firstOrFail();
            $totalCouriers = couriers::where('hub_id', $orders->end_hub_id)->count();

            // Get the next run number and update the database
            $runNumber = $couriers->getNextRunNumber();

            // Calculate the index of the record to retrieve
            $index = ($runNumber - 1) % $totalCouriers;

            // Retrieve the courier based on the calculated index
            $couriers = couriers::where('hub_id', $orders->end_hub_id)->skip($index)->take(1)->first();

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
