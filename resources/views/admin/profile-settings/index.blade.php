@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Update Profile
                            <a href="{{ url('/home') }}"
                                class="btn btn-primary btn-sm text-white float-end">Back</a>
                                <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                    Refresh
                                </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    alertify.set('notifier', 'position', 'top-right');
                                    alertify.success("{{ session('success') }}");
                                });
                            </script>
                        @endif

                        <form action="{{ route('admin.profile-settings.update', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Employee Type</label>
                                    <input type="text" name="role" value="{{ $user->role }}" class="form-control"
                                        disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Status</label>
                                    <input type="text" name="status" value="{{ $user->status }}" class="form-control"
                                        disabled>
                                </div>
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
