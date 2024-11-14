<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">    
                    <h3 class="text-lg font-semibold mb-4">Employees</h3>
                   
                    <x-confirm-alert />
                   
                    <a href="{{ route('admin.user.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4 inline-block">Add New Employee</a>

                    {{-- all employees --}}
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-start">Name</th>
                                <th class="px-4 py-2 border-b text-start">Email</th>
                                <th class="px-4 py-2 border-b text-start">Role</th>
                                <th class="px-4 py-2 border-b text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-2 border-b text-start">{{ $user->name }}</td>
                                    <td class="px-4 py-2 border-b text-start">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border-b text-start">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600" title="edit"><i class="fa-solid fa-pencil"></i></a>
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600" title="delete"><i class="fa-solid fa-trash"></i></x-danger-button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this leave request? This action cannot be undone.');
        }
    </script>

</x-app-layout>
