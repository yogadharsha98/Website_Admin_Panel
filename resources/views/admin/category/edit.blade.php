@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h4>
                            Update Category
                            <a href="{{ route('admin.category.index') }}"
                                class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/category/' . $category->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Product Name</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $category->title }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Category Slug</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ $category->slug }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        value="{{ $category->meta_title }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" class="form-control">{{ $category->meta_description }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label>Meta Keyword</label>
                                    <textarea name="meta_keyword" class="form-control">{{ $category->meta_keyword }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" />
                                    @if ($category->image)
                                        <img src="{{ asset($category->image) }}" alt="Main Image" width="60"
                                            class="mt-2">
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label><br>
                                    <input type="checkbox" name="is_active" style="width: 25px; height: 25px;"
                                        {{ $category->is_active ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-success float-end">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection