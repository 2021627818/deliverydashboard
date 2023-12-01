<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('orders.store') }}" method="post" class="mt-6 space-y-6">
                        @csrf
                        <!-- Add form fields for recipient information, order details, etc. -->

                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Recipient Information') }}
                        </h2>

                            <div>
                                <x-input-label for="recipient_first_name" :value="__('First Name')" />
                                <x-text-input id="recipient_first_name" name="recipient_first_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_first_name')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_last_name" :value="__('Last Name')" />
                                <x-text-input id="recipient_last_name" name="recipient_last_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_last_name')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_phone_number" :value="__('Phone Number')" />
                                <x-text-input id="recipient_phone_number" name="recipient_phone_number" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_phone_number')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_address_line1" :value="__('Address Line 1')" />
                                <x-text-input id="recipient_address_line1" name="recipient_address_line1" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_address_line1')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_address_line2" :value="__('Address Line 2')" />
                                <x-text-input id="recipient_address_line2" name="recipient_address_line2" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_address_line2')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_postal_code" :value="__('Postal Code')" />
                                <x-text-input id="recipient_postal_code" name="recipient_postal_code" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_postal_code')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_city" :value="__('City')" />
                                <x-text-input id="recipient_city" name="recipient_city" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_city')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_state" :value="__('State')" />
                                <x-text-input id="recipient_state" name="recipient_state" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_state')" />
                            </div>

                            <div>
                                <x-input-label for="recipient_country" :value="__('Country')" />
                                <x-text-input id="recipient_country" name="recipient_country" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_country')" />
                            </div>

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Parcel Information') }}
                            </h2>

                            <div>
                                <x-input-label for="descriptions" :value="__('Parcel Descriptions')" />
                                <x-text-input id="descriptions" name="descriptions" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('descriptions')" />
                            </div>

                            <div>
                                <x-input-label for="parcel_weight" :value="__('Weight (kg)')" />
                                <x-text-input id="parcel_weight" name="parcel_weight" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('parcel_weight')" />
                            </div>

                            <div>
                                <x-input-label for="parcel_length" :value="__('Length (mm)')" />
                                <x-text-input id="parcel_length" name="parcel_length" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('parcel_length')" />
                            </div>

                            <div>
                                <x-input-label for="parcel_width" :value="__('Width (mm)')" />
                                <x-text-input id="parcel_width" name="parcel_width" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('parcel_width')" />
                            </div>

                            <div>
                                <x-input-label for="parcel_height" :value="__('Height (mm)')" />
                                <x-text-input id="parcel_height" name="parcel_height" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('parcel_height')" />
                            </div>
 
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Submit') }}</x-primary-button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>