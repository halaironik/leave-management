<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Leave Requests</h3>

                    <x-confirm-alert />

                    <div id="adminLeaveRequestsTable"></div>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function fetchAdminLeaveRequests() {
                $.ajax({
                    url: "{{ route('admin.leave-requests.data') }}",
                    method: 'GET',
                    success: function(response) {
                        $('#adminLeaveRequestsTable').html(response);
                    },
                    error: function(xhr) {
                        console.error('Error fetching leave requests:', xhr);
                    }
                });
            }

            $(document).ready(function() {
                fetchAdminLeaveRequests();
                setInterval(fetchAdminLeaveRequests, 3000);

                // Handle approve/reject/delete actions via Ajax
                $(document).on('submit', '.leave-action-form', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            fetchAdminLeaveRequests(); // Refresh table after action
                            if(response.message) {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error processing action:', xhr);
                        }
                    });
                });
            });

        </script>
    @endpush

</x-app-layout>
