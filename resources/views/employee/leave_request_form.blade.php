<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for Leave') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Submit Your Leave Request</h3>
                    <form action="{{ route('leave.store') }}" method="POST">
                        @csrf
                        
                        {{-- Leave start date --}}
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" class="mt-2"/>
                            <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required/>
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                         {{-- Leave end date --}}
                        <div>
                            <x-input-label for="end_date" :value="__('End Date')" class="mt-2"/>
                            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required/>
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>

                        {{-- Leave reason --}}
                        <div>
                            <x-input-label for="reason" :value="__('Reason')" class="mt-2"/>
                            <x-text-area id="reason" class="block mt-1 w-full" type="date" name="reason" :value="old('reason')" required/>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>

                        <x-primary-button class="mt-5 bg-blue-500 hover:bg-blue-600">
                            {{ __('Submit Request') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
