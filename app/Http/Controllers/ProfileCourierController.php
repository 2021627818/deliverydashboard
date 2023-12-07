<?php

namespace App\Http\Controllers;

use App\Models\couriers;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileCourierController extends Controller
{
    /**
     * Display the Courier profile form.
     */
    public function edit(Request $request): View
    {
        
        return view('profileCourier.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = auth()->user();

    $this->validate($request, [
        'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'vehicle_number' => ['required', 'string', 'max:20'],
        // Add validation for new fields
    ]);

    $user->update($request->only('name', 'email'));

    // Create customer_profiles Informations if null
    if ($user->couriers == null){
        $user->couriers()->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'vehicle_number' => $request->input('vehicle_number'),
        ]);
    }

    // Update customer_profiles Informations
    if ($user->couriers) {
        $user->couriers->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'vehicle_number' => $request->input('vehicle_number'),
            'hub_id' => $request->input('hub_id'),
        ]);
    }

        return Redirect::route('profilecourier.edit')->with('status', 'profile-updated');
    }

    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
