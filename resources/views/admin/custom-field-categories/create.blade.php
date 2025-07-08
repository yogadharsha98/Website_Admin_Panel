@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
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
                            alertify.danger("{{ session('failure') }}");
                        </script>
                    @show
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Add a New {{ $field->name }} Custom Field -> Category
                            <a href="{{ route('admin.custom-field.index', $field->id) }}"
                                class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">Refresh</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category-field.store', $field->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Access field ID -->
                                <p @readonly(true)>Field ID: {{ $field->id }}</p>

                                <!-- Hidden input for field_id -->
                                <input type="hidden" name="field_id" value="{{ $field->id }}">

                                <!-- Category Selection Field -->
                                <div class="col-md-12 mb-3">
                                    <label for="category">Select a Category and Sub-category</label>
                                    <select name="category_sub_category" id="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            @foreach ($category->subCategories as $subCategory)
                                                <option value="{{ $category->id . ':' . $subCategory->id }}">
                                                    {{ $category->title }} - {{ $subCategory->title }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-success float-end">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <h4>
                            Assigning Custom Fields  {{ $field->name }} for Category
                            <a href="{{ route('admin.options.index', $field->id) }}"
                                class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">Refresh</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered table-striped" id="custom_field_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Field</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoryFields as $categoryField)
                                        <tr>
                                            <td>{{ $categoryField->id }}</td>
                                            <td>{{ $categoryField->category->title }}</td>
                                            <td>{{ $categoryField->category->subCategories->firstWhere('id', $categoryField->sub_category_id)->title }}</td>
                                            <td>{{ $categoryField->field->name }}</td>
                                            <td>
                                                <!-- Edit and Delete Icons -->
                                                <a href="{{ route('category-field.edit', $categoryField->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="delete-form-{{ $categoryField->id }}" action="{{ route('category-field.delete', $categoryField->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault(); alertify.confirm('Are you sure you want to delete this item?', function(){
                                                           document.getElementById('delete-form-{{ $categoryField->id }}').submit();  // Submit the form
                                                       }, function(){
                                                           alertify.error('Cancelled');  // Show a cancellation message
                                                       });">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </form>


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
@endsection
