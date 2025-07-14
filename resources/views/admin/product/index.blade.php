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
                            Products
                            <a href="{{ route('admin.product.create') }}" class="btn btn-success btn-sm text-white float-end">
                                Add Products
                            </a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered table-striped" id="options_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($options as $option)
                                    <tr>
                                        <td>{{ $option->id }}</td>
                                        <td>{{ $option->value }}</td>
                                        <td>
                                            <!-- Edit button -->
                                            <a href="{{ route('admin.options.edit', [$field->id, $option->id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete form -->
                                            <form action="{{ route('admin.options.destroy', [$field->id, $option->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach --}}
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
            $('#options_table').DataTable();
        });
    </script>
@endsection
