
@if ($leaveRequests->isEmpty())
<p>No leave requests at the time.</p>
@else
<table class="min-w-full bg-white border border-gray-300">
    <thead>
        <tr>
            <th class="px-4 py-2 border-b text-start">Employee Name</th>
            <th class="px-4 py-2 border-b text-start">Start Date</th>
            <th class="px-4 py-2 border-b text-start">End Date</th>
            <th class="px-4 py-2 border-b text-start">Reason</th>
            <th class="px-4 py-2 border-b text-start">Status</th>
            <th class="px-4 py-2 border-b text-start">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaveRequests as $request)
            <tr>
                <td class="px-4 py-2 border-b text-start">{{ $request->user->name }}</td>
                <td class="px-4 py-2 border-b text-start">{{ $request->start_date }}</td>
                <td class="px-4 py-2 border-b text-start">{{ $request->end_date }}</td>
                <td class="px-4 py-2 border-b text-start">{{ $request->reason }}</td>
                <td class="px-4 py-2 border-b text-start">{{ Str::ucfirst($request->status) }}
                </td>
                <td class="px-4 py-2 border-b">
                    <div class="flex space-x-2">
                        @if ($request->status === 'pending')
                            <form action="{{ route('admin.leave.approve', $request->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <x-secondary-button
                                    type="submit" class="bg-green-500 hover:bg-green-600" title="Approve"><i class="fa-solid fa-check"></i></x-secondary-button>
                            </form>
                            <form action="{{ route('admin.leave.reject', $request->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <x-secondary-button type="submit" title="Reject"><i class="fa-solid fa-x"></i></x-secondary-button>
                            </form> 
                        @else
                            <form action="{{ route('admin.leave.delete', $request->id) }}"
                                method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" title="Delete"><i class="fa-solid fa-trash"></i></x-danger-button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user? This action cannot be undone.');
    }
</script>
