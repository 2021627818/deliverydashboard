<?php

namespace App\Http\Controllers;

use App\Models\customer_profiles;
use App\Models\customer_address;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        
        return view('profile.edit', [
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
        // Add validation for new fields
    ]);

    $user->update($request->only('name', 'email'));

    // Create customer_profiles informations if null
    if ($user->customer_profiles == null){
        $user->customer_profiles()->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
        ]);
    }

    // Update customer_profiles informations
    if ($user->customer_profiles) {
        $user->customer_profiles->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
        ]);
    }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function addressUpdate(Request $request)
{
    $user = auth()->user();

    $this->validate($request, [
        'address_line1' => ['required', 'string', 'max:255'],
        'address_line2' => ['required', 'string', 'max:255'],
        'postal_code' => ['required', 'string', 'max:6'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'country' => ['required', 'string', 'max:255'],
        // Add validation for new fields
    ]);

    // Create customer_address Informations if null
    if ($user->customer_profiles->customer_address == null){
        $user->customer_profiles->customer_address()->create([
            'address_line1' => $request->input('address_line1'),
            'address_line2' => $request->input('address_line2'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
        ]);
    }

    // Update customer_address Informations
    if ($user->customer_profiles->customer_address) {
        $user->customer_profiles->customer_address->update([
            'address_line1' => $request->input('address_line1'),
            'address_line2' => $request->input('address_line2'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
        ]);
    }

        return Redirect::route('profile.edit')->with('status', 'address-updated');
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
