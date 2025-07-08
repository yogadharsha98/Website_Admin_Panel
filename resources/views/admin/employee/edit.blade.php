@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h4>
                            Update Employee
                            <a href="{{ route('admin.employee.index') }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/employee/'.$employee->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Employee Type</label>
                                    <select name="role" class="form-select" aria-label="Default select example">
                                        @foreach ($options['roles'] as $role)
                                            <option value="{{ $role }}" {{ $employee->role == $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="name" value="{{$employee->name}}" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{ $employee->email }}" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Password</label>
                                    <input type="password" name="password" value="{{ $employee->password }}"  class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Status</label>
                                    <select name="status" class="form-select" aria-label="Default select example">
                                        @foreach ($options['statuses'] as $value => $label)
                                            <option value="{{ $value }}" {{ $employee->status == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
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
