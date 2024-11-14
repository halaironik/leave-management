@if ($leaveRequests->isEmpty())
<p>You have no leave requests.</p>

@else
<table class="min-w-full bg-white border border-gray-200">
    <thead>
        <tr>
            <th class="px-4 py-2 border-b-2 text-start">Start Date</th>
            <th class="px-4 py-2 border-b-2 text-start">End Date</th>
            <th class="px-4 py-2 border-b-2 text-start">Reason</th>
            <th class="px-4 py-2 border-b-2 text-start">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaveRequests as $request)
            <tr>
                <td class="px-4 py-2 border-b-2 text-start">{{ $request->start_date }}</td>
                <td class="px-4 py-2 border-b-2 text-start">{{ $request->end_date }}</td>
                <td class="px-4 py-2 border-b-2 text-start">{{ $request->reason }}</td>
                <td class="px-4 py-2 border-b-2 text-start">
                    <span class="px-2 py-1 rounded-full {{ $request->status === 'approved' ? 'bg-green-200 text-green-800' : ($request->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                        {{ Str::ucfirst($request->status) }}
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>  
@endif
