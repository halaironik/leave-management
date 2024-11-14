<!-- Form for editing user -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Update Employee Details</h3>
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="p-4 space-y-4">

                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Name')" class="mt-2" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="$user->name" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="mt-2" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="$user->email" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Role Select -->
                            <div class="mt-4">
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                <x-input-label for="role" :value="__('Role')" />

                                <x-select-input id="role" name="role">
                                    <option value="admin" @if ($user->role === 'admin') selected @endif>Admin</option>
                                    <option value="employee" @if ($user->role === 'employee') selected @endif>Employee</option>
                                </x-select-input>
                            </div>

                            <div class="flex justify-end">
                                <x-primary-button>Update</x-primary-button>
                                <a href="{{ route('admin.user.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




