<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\orders;
use App\Models\recipients;
use App\Models\customer_profiles;
use App\Models\customer_address;
use App\Models\postalcodes;
use App\Models\orderstatus;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OrderController extends Controller
{
    //
    public function create()
    {
        return view('orders.create');
    }

    public function details($orderId)
    {
        $orders = orders::with('recipients', 'orderstatus')->find($orderId);
        return view('orders.details', compact('orders'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            //'recipients_first_name' => ['required', 'string', 'max:255'],
            // Add validation rules for each form field
        ]);

        // Create a new order
        $orders = orders::create([
            'descriptions' => $request->input('descriptions'),
            'parcel_weight' => $request->input('parcel_weight'),
            'parcel_length' => $request->input('parcel_length'),
            'parcel_height' => $request->input('parcel_height'),
            'parcel_width' => $request->input('parcel_width'),
            'order_date' => now(),
            
            // Add other order fields
        ]);
        $orders->save();

        // Update recipient with order_id
        $orders->recipients()->create([
            'recipient_first_name' => $request->input('recipient_first_name'),
            'recipient_last_name' => $request->input('recipient_last_name'),
            'recipient_phone_number' => $request->input('recipient_phone_number'),
            'recipient_address_line1' => $request->input('recipient_address_line1'),
            'recipient_address_line2' => $request->input('recipient_address_line2'),
            'recipient_postal_code' => $request->input('recipient_postal_code'),
            'recipient_city' => $request->input('recipient_city'),
            'recipient_state' => $request->input('recipient_state'),
            'recipient_country' => $request->input('recipient_country'),
        ]);

        //$recipients->save();

        $user = auth()->user();
        // Update customer_id and hub_id in the order
        //$customer_profiles = customer_profiles::where('user_id', auth()->id())->first();
        
               
        $orders->customer_id = $user->customer_profiles->customer_address->customer_id;
        
        $postalcodes = postalcodes::where('postal_code', $user->customer_profiles->customer_address->postal_code)->first();
        $orders->start_hub_id = $postalcodes->hub_id;
        $orders->next_hub_id = $postalcodes->hub_id;

        $postalcodes = postalcodes::where('postal_code', $orders->recipients->recipient_postal_code)->first();
        $orders->end_hub_id = $postalcodes->hub_id;


        $orders->save();

        // Call the assignCourier method from the DeliveryController
        $deliveryController = new DeliveryController();
        $deliveryController->assignPickupCourier($orders);

        // Redirect to a success page or do whatever is necessary
        return redirect()->route('dashboard')->with('success', 'Order created successfully');
    }

    // To display customer orders
    public function recentOrders()
    {
        
        //$customerOrders = orders::join('orderstatus', 'orders.order_id', '=', 'orderstatus.order_id')
        //  ->where('orders.customer_id', auth()->user()->customer_profiles->user_id)
            //->where('status','!=', 'delivered')
        // ->take(5) // Limit to the latest 10 orders
        // ->orderBy('orders.order_id', 'desc')
        // ->select('orders.order_id','orderstatus.status', 'orderstatus.created_at', 'orderstatus.updated_at as updated_date')
        // ->get();

        $recentOrders = orders::select(
            'orders.order_id',
            'orderstatus.created_at',
            'orderstatus.updated_at',
            'orderstatus.status'
        )
        ->leftJoin('orderstatus', function ($join) {
            $join->on('orders.order_id', '=', 'orderstatus.order_id')
                ->where('orderstatus.status_id', '=', function ($query) {
                    $query->select('status_id')
                        ->from('orderstatus')
                        ->whereColumn('order_id', 'orders.order_id')
                        ->orderByDesc('status_id')
                        ->limit(1);
                });
        })
        ->where('orders.customer_id', auth()->user()->customer_profiles->customer_id)
        ->orderBy('orders.order_id', 'desc')
        ->take(10)
        ->get();

        return view('dashboard', compact('recentOrders'));
    }

    public function allCustomerOrders()
    {
        $allCustomerOrders = orders::select(
            'orders.order_id',
            'orderstatus.created_at',
            'orderstatus.updated_at',
            'orderstatus.status'
        )
        ->leftJoin('orderstatus', function ($join) {
            $join->on('orders.order_id', '=', 'orderstatus.order_id')
                ->where('orderstatus.status_id', '=', function ($query) {
                    $query->select('status_id')
                        ->from('orderstatus')
                        ->whereColumn('order_id', 'orders.order_id')
                        ->orderByDesc('status_id')
                        ->limit(1);
                });
        })
        ->where('orders.customer_id', auth()->user()->customer_profiles->user_id)
        ->orderBy('orders.order_id', 'desc')
        ->get();

        return view('/orders/allcustomerorders', compact('allCustomerOrders'));
    }
}
