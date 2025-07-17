@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h4>
                            Update Slider
                            <a href="{{ route('admin.slider.index') }}"
                                class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/slider/' . $slider->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $slider->title }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Slug</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ $slider->slug }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Content Title</label>
                                    <input type="text" name="content_title" class="form-control"
                                        value="{{ $slider->content_title }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Content_Title Main </label>
                                    <textarea name="content_title_main" class="form-control">{{ $slider->content_title_main }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label>Content Description</label>
                                    <textarea name="content_description" class="form-control">{{ $slider->content_description }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" />
                                    @if ($slider->image)
                                        <img src="{{ asset($slider->image) }}" alt="Main Image" width="60"
                                            class="mt-2">
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label><br>
                                    <input type="checkbox" name="is_active" style="width: 25px; height: 25px;"
                                        {{ $slider->is_active ? 'checked' : '' }}>
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