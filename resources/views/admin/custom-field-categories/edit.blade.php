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
                            Edit Custom Field for Category
                            <a href=""
                               class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">Refresh</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.custom-field-categories.update', $field->id) }}" method="POST">
                            @csrf
                            @method('PUT')
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
                                                <option value="{{ $category->id . ':' . $subCategory->id }}"
                                                        @if($category->id == $field->category_id && $subCategory->id == $field->sub_category_id) selected @endif>
                                                    {{ $category->title }} - {{ $subCategory->title }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-success float-end">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
