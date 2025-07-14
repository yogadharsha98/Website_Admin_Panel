@extends('layouts.admin')

@section('title', 'Admin Setting')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">
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
            <form action="{{ route('admin.website_settings.store') }}" method="POST">
                @csrf

                <div class="card mb-3">
                    <div class="card-header bg-primary">
                        <h3 class="text-white mb-0">Website Setting</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Website Name</label>
                                <input type="text" value="{{ $setting->website_name ?? '' }}" name="website_name"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Website URL</label>
                                <input type="text" value="{{ $setting->website_url ?? '' }}" name="website_url"
                                    class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Page Title</label>
                                <input type="text" value="{{ $setting->page_title ?? '' }}" name="page_title"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Meta Keywords</label>
                                <textarea name="meta_keyword" class="form-control" rows="3">{{ $setting->meta_keyword ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3">{{ $setting->meta_description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary">
                        <h3 class="text-white mb-0">Website Information</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ $setting->address ?? '' }}</textarea>
                            </div>
                            <!-- Add Latitude input -->
                            <div class="col-md-6 mb-3">
                                <label for="latitude">Store Latitude</label>
                                <input type="text" value="{{ $setting->latitude ?? '' }}" name="latitude" id="latitude"
                                    class="form-control" placeholder="e.g. 6.9271" />
                            </div>

                            <!-- Add Longitude input -->
                            <div class="col-md-6 mb-3">
                                <label for="longitude">Store Longitude</label>
                                <input type="text" value="{{ $setting->longitude ?? '' }}" name="longitude"
                                    id="longitude" class="form-control" placeholder="e.g. 79.8612" />
                            </div>

                            <!-- Or optionally Google Maps embed URL -->

                            <div class="col-md-12 mb-3">
                                <label for="google_map_url">Google Maps Embed URL</label>
                                <input type="text" value="{{ $setting->google_map_url ?? '' }}" name="google_map_url"
                                    id="google_map_url" class="form-control"
                                    placeholder="Paste Google Maps embed URL here" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Phone 1</label>
                                <input type="text" value="{{ $setting->phone1 ?? '' }}" name="phone1"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone 1</label>
                                <input type="text" value="{{ $setting->phone2 ?? '' }}" name="phone2"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email ID 1</label>
                                <input type="text" value="{{ $setting->email1 ?? '' }}" name="email1"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email ID 2</label>
                                <input type="text" value="{{ $setting->email2 ?? '' }}" name="email2"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary">
                        <h3 class="text-white mb-0">Website Social Media</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Facebook</label>
                                <input type="text" name="facebook" value="{{ $setting->facebook ?? '' }}"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Twitter</label>
                                <input type="text" name="twitter" value="{{ $setting->twitter ?? '' }}"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Instagram</label>
                                <input type="text" name="instagram" value="{{ $setting->instagram ?? '' }}"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Youtube</label>
                                <input type="text" name="youtube" value="{{ $setting->youtube ?? '' }}"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary">
                        <h3 class="text-white mb-0">Website Footer</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Additional Information</label>
                                <textarea name="add_info" class="form-control" rows="3">{{ $setting->add_info ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Copyright Text</label>
                                <input type="text" value="{{ $setting->copy_right_txt ?? '' }}" name="copy_right_txt"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Copyright Date </label>
                                <input type="date" value="{{ $setting->copyright_date ?? '' }}" name="copyright_date"
                                    class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Footer URL</label>
                                <textarea name="footer_url" class="form-control" rows="3">{{ $setting->footer_url ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image 1</label>
                                <input type="file" name="footer_img_1" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image 1</label>
                                <input type="file" name="footer_img_2" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image 1</label>
                                <input type="file" name="footer_img_3" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image 1</label>
                                <input type="file" name="footer_img_4" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image 1</label>
                                <input type="file" name="footer_img_5" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary text-white">Save Setting</button>
                </div>

            </form>
        </div>
    </div>

@endsection
@section('alertify-script')
    <script>
        @if (session('success'))
            alertify.success("{{ session('success') }}");
        @elseif (session('failure'))
            alertify.error("{{ session('failure') }}");
        @endif
    </script>
@endsection

