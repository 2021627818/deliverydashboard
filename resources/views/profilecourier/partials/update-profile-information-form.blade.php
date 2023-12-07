<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profileCourier.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', optional($user->couriers)->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', optional($user->couriers)->last_name)" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', optional($user->couriers)->phone_number)" required autofocus autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="vehicle_number" :value="__('Vehicle Number')" />
            <x-text-input id="vehicle_number" name="vehicle_number" type="text" class="mt-1 block w-full" :value="old('vehicle_number', optional($user->couriers)->vehicle_number)" required autofocus autocomplete="vehicle_number" />
            <x-input-error class="mt-2" :messages="$errors->get('vehicle_number')" />
        </div>

        <div>
            <x-input-label for="hub_id" :value="__('Select Hub Location')" />
            <select name="hub_id" id="hub_id" required >
                <option value="1" {{ old('hub_id', optional($user->couriers)->hub_id) == 1 ? 'selected' : ''}}>Shah Alam</option>
                <option value="2" {{ old('hub_id', optional($user->couriers)->hub_id) == 2 ? 'selected' : ''}}>Klang</option>
                <option value="3" {{ old('hub_id', optional($user->couriers)->hub_id) == 3 ? 'selected' : ''}}>Banting</option>
                <option value="4" {{ old('hub_id', optional($user->couriers)->hub_id) == 4 ? 'selected' : ''}}>Kajang</option>
                <option value="5" {{ old('hub_id', optional($user->couriers)->hub_id) == 5 ? 'selected' : ''}}>Bangi</option>
                <option value="6" {{ old('hub_id', optional($user->couriers)->hub_id) == 6 ? 'selected' : ''}}>Sepang</option>
                <option value="7" {{ old('hub_id', optional($user->couriers)->hub_id) == 7 ? 'selected' : ''}}>Sabak Bernam</option>
                <option value="8" {{ old('hub_id', optional($user->couriers)->hub_id) == 8 ? 'selected' : ''}}>Petaling Jaya</option>
                <option value="9" {{ old('hub_id', optional($user->couriers)->hub_id) == 9 ? 'selected' : ''}}>Subang Jaya</option>
                <option value="10" {{ old('hub_id', optional($user->couriers)->hub_id) == 10 ? 'selected' : ''}}>Rawang</option>
                <option value="11" {{ old('hub_id', optional($user->couriers)->hub_id) == 11 ? 'selected' : ''}}>Cyberjaya</option>
                <option value="9999" {{ old('hub_id', optional($user->couriers)->hub_id) == 9999 ? 'selected' : ''}}>Selangor Sorting Center</option>
            </select>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
