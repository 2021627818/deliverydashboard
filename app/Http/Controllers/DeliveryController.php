<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\orders;
use App\Models\recipients;
use App\Models\customer_profiles;
use App\Models\customer_address;
use App\Models\postal_codes;
use App\Models\couriers;
use App\Models\courier_hubs;
use App\Models\order_status;
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
        
        $orders->save();

        $courierHub = courier_hubs::find($orders->next_hub_id);
        $orders->order_status()->create([
            'status' => 'Order Created',
            'next_stop' => $courierHub->hub_city. ' HUB',
            'order_id' => $orders->order_id
        ]);
    }

    public function updateStatus(Request $request, $orderID)
    {

        $orders = orders::with('recipients', 'order_status')->find($orderID);
        $selectedOption = $request->input('dropdown');


        switch ($selectedOption) {
            case 'one':
                $courierHub = courier_hubs::find($orders->next_hub_id);
                $orders->order_status()->create([
                'status' => 'Order Picked Up by Courier',
                'next_stop' => $courierHub->hub_city. ' HUB',
                'order_id' => $orderID
                ]);
                break;

            case 'two':

                $courierHub = courier_hubs::find($orders->next_hub_id); // Assuming hub_id is the foreign key in the orders table

                if ($courierHub) {
                    $hubCity = $courierHub->hub_city;
                    $status = "Order Arrived at $hubCity HUB";
                
                    $this->assignHubCourier($orders);
                    
                    if ($orders->next_hub_id === $orders->end_hub_id){
                        $orders->order_status()->create([
                        'status' => $status,
                        'next_stop' => 'Deliver to Recipient',
                        'order_id' => $orderID
                        ]);
                    }

                    else {
                        $orders->order_status()->create([
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
                $orders->order_status()->create([
                'status' => 'Order Out For Delivery',
                'next_stop' => 'Deliver to Recipient',
                'order_id' => $orderID
                ]);
                break;

            case 'four':
                $orders->order_status()->create([
                'status' => 'In Transit',
                'next_stop' => 'Sorting Center',
                'order_id' => $orderID
                ]);
                break;
                
            case 'five':
                $courierHub = courier_hubs::find($orders->next_hub_id);
                $orders->order_status()->create([
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
                $courierHub = courier_hubs::find($orders->next_hub_id);
                $orders->order_status()->create([
                'status' => 'In Transit',
                'next_stop' => $courierHub->hub_city. ' HUB',
                'order_id' => $orderID
                ]);
                break;

            case 'seven':
                $orders->order_status()->create([
                    'status' => 'Delivered',
                    'next_stop' => null,
                    'order_id' => $orderID
                ]);
                break;

            case 'eight':
                $courierHub = courier_hubs::find($orders->next_hub_id);
                $orders->order_status()->create([
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
        

        return redirect()->route('dashboardCourier');
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
        // Logic to assign courier based on conditions
        if ($orders->end_hub_id === $orders->next_hub_id){
            $this->courierRotation($orders);
        }

        else{
            $this->courierRotation2($orders);
        }
    }
}
