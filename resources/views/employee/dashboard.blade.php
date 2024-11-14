<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Your Leave Requests</h3>
                    <div id="leaveRequestsTable"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function fetchLeaveRequests() {
            $.ajax({
                url: "{{ route('leave-requests.data') }}",
                method: 'GET',
                success: function(response) {
                    $('#leaveRequestsTable').html(response);
                },
                error: function(xhr) {
                    console.error('Error fetching leave requests:', xhr);
                }
            });
        }

            // Fetch initially
            fetchLeaveRequests();

            // Refresh every 30 seconds
            setInterval(fetchLeaveRequests, 3000);
        </script>
    @endpush
</x-app-layout>