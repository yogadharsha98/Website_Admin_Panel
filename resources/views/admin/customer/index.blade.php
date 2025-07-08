@extends('layouts.admin')

@section('content')
    <div class="content-wrapper" style="padding: 20px;">
        <div class="row">
            <div class="col-md-12">
                @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="card">

                    <div class="card-header">
                        <h4>
                            Customer
                            <a href="{{ '/home'}}" class="btn btn-success btn-sm text-white float-end">
                                Back
                            </a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered table-striped" id="customer_table">
                                <thead>
                                    <tr>
                                        <th style="width: 25px;">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone NUmber </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone_number }}</td>
                                        <td>
                                            <select class="form-select status-dropdown" data-id="{{ $customer->id }}">
                                                <option value="Active" {{ $customer->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ $customer->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="Suspended" {{ $customer->status == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button
                                                    type="button"
                                                    class="btn btn-link btn-sm text-danger delete-customer"
                                                    title="Delete"
                                                    data-id="{{ $customer->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
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
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#customer_table').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#customer_table').DataTable();

            // AJAX call to update status
            $('.status-dropdown').change(function() {
                let customerId = $(this).data('id');
                let newStatus = $(this).val();

                $.ajax({
                    url: `/admin/customer/${customerId}/update-status`, // Endpoint to update status
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                        status: newStatus
                    },
                    success: function(response) {
                        alertify.success('Status updated successfully');
                    },
                    error: function() {
                        alertify.error('Failed to update status');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
    $('.delete-customer').on('click', function () {
        var customerId = $(this).data('id'); // Get the customer ID from data-id attribute

        alertify.confirm(
            'Delete Customer', // Title of the confirm dialog
            'Are you sure you want to delete this customer?', // Message to display
            function () {
                // If confirmed, proceed with AJAX request to delete
                $.ajax({
                    url: `/admin/customer/${customerId}`, // Delete route
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}' // CSRF token
                    },
                    success: function (response) {
                        alertify.success('Customer deleted successfully');
                        // Optionally, remove the customer row from the table
                        $(`button[data-id='${customerId}']`).closest('tr').remove();
                    },
                    error: function () {
                        alertify.error('Failed to delete customer');
                    }
                });
            },
            function () {
                // If canceled, display cancellation message (optional)
                alertify.message('Delete action canceled');
            }
        ).set('labels', { ok: 'Yes', cancel: 'No' }); // Customize button labels
    });
});

    </script>

@endsection
