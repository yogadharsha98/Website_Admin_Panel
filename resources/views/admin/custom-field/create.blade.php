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
                            Add Custom Field
                            <a href="" class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.custom-field.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="" selected disabled>Select Field Type</option>
                                        @foreach($fieldTypes as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Field Length -->
                                <div class="col-md-6 mb-3">
                                    <label for="field_length">Field Length</label>
                                    <input type="text" name="max" id="max" class="form-control" />
                                </div>

                                <!-- Default Value -->
                                <div class="col-md-6 mb-3">
                                    <label for="default_value">Default Value</label>
                                    <input type="text" name="default_value" id="default_value" class="form-control" />
                                </div>

                                <!-- Active Toggle -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" />
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>
                                </div>

                                <!-- Required Toggle -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="required" name="required" value="1" />
                                        <label class="form-check-label" for="is_required">Required</label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-success float-end">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
