@extends('layouts.admin')

@section('content')
    <div class="content-wrapper" style="padding: 20px;">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    @section('alertify-script')
                        <script>
                            alertify.success("{{ session('success') }}");
                        </script>
                    @show
                @elseif (session('failure'))
                    @section('alertify-script')
                        <script>
                            alertify.error("{{ session('failure') }}");
                        </script>
                    @show
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Custom Fields
                            <a href="{{ route('admin.custom-field.create') }}"
                                class="btn btn-success btn-sm text-white float-end">
                                Add Custom Field
                            </a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered table-striped" id="custom_field_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fields as $field)
                                        <tr>
                                            <td>{{ $field->id }}</td>
                                            <td>{{ $field->name }}</td>
                                            <td>{{ $field->type }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status-toggle"
                                                        data-id="{{ $field->id }}" {{ $field->active ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <style>
                                                /* Toggle switch */
                                                .switch {
                                                    position: relative;
                                                    display: inline-block;
                                                    width: 34px;
                                                    height: 20px;
                                                }

                                                .switch input {
                                                    opacity: 0;
                                                    width: 0;
                                                    height: 0;
                                                }

                                                .slider {
                                                    position: absolute;
                                                    cursor: pointer;
                                                    top: 0;
                                                    left: 0;
                                                    right: 0;
                                                    bottom: 0;
                                                    background-color: #ccc;
                                                    transition: 0.4s;
                                                    border-radius: 34px;
                                                }

                                                .slider:before {
                                                    position: absolute;
                                                    content: "";
                                                    height: 12px;
                                                    width: 12px;
                                                    border-radius: 50%;
                                                    left: 4px;
                                                    bottom: 4px;
                                                    background-color: white;
                                                    transition: 0.4s;
                                                }

                                                input:checked+.slider {
                                                    background-color: #4CAF50;
                                                }

                                                input:checked+.slider:before {
                                                    transform: translateX(14px);
                                                }
                                            </style>
                                            <td>
                                                <a href="{{ url('admin/custom-field/' . $field->id . '/edit') }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('custom-field.destroy', $field->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ url('admin/custom_fields/' . $field->id . '/categories/create') }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-plus"></i> Add to Sub-category
                                                </a>

                                                @if (in_array($field->type, ['checkbox', 'radio', 'select', 'checkbox_multiple']))
                                                    <a href="{{ route('admin.options.index', $field->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-cogs"></i> Options
                                                    </a>
                                                @endif
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
            $('#custom_field_table').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#custom_field_table').DataTable();

            // Toggle active status
            $('.status-toggle').on('change', function() {
                let fieldId = $(this).data('id');
                let isActive = $(this).prop('checked') ? 1 : 0;

                // Send AJAX request to update the active status
                $.ajax({
                    url: '/admin/custom-field/' + fieldId +
                    '/update-status', // Ensure this URL matches the route defined
                    type: 'PUT', // Ensure it's a PUT request
                    data: {
                        _token: '{{ csrf_token() }}',
                        active: isActive
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success('Status updated successfully!');
                        } else {
                            alertify.error('Failed to update status!');
                        }
                    },
                    error: function() {
                        alertify.error('Error occurred while updating status!');
                    }
                });

            });
        });
    </script>
@endsection
