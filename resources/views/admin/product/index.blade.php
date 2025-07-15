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
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>SubCategory</th>
                                        <th>Original Price</th>
                                        <th>Starting Price</th>
                                        <th>Ending Price</th>
                                        <th>Quantity</th>
                                        <th>Main Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category?->title ?? 'N/A' }}</td>
                                            <td>{{ $product->subCategory?->title ?? 'N/A' }}</td>
                                            <td>{{ $product->original_price }}</td>
                                            <td>{{ $product->starting_price }}</td>
                                            <td>{{ $product->ending_price }}</td>
                                            <td>{{ $product->total_quantity }}</td>
                                            <td>
                                                @if($product->main_image)
                                                    <img src="{{ asset($product->main_image) }}" alt="Main Image" width="60" height="60">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Non Active</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ url('admin/product/' . $product->id . '/edit') }}"
                                                        class="btn btn-link btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ url('admin/product/' . $product->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link btn-sm text-danger"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this Product?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
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
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#options_table').DataTable();
        });
    </script>
@endsection
