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
                            Add Employee
                            <a href="{{ route('admin.employee.index') }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.employee.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Employee Type</label>
                                    <select name="role" class="form-select" aria-label="Default select example">
                                        <option value="worker">Worker</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control" />
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Status</label>
                                    <select name="status" class="form-select" aria-label="Default select example">
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
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
