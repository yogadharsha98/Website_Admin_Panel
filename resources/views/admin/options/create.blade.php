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
                            Add Options -> Features
                            <a href="{{ route('admin.options.index', $field->id) }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.options.store', $field->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="value">Value</label>
                                    <input type="text" name="value" id="value" class="form-control" required />
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
