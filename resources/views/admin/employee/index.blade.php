@extends('layouts.admin')

@section('content')
    <div class="content-wrapper" style="padding: 20px;">
        <div class="row">
            <div class="col-md-12">
                @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="card">

                    <div class="card-header">
                        <h4>
                            Employee
                            <a href="{{ route('admin.employee.create') }}" class="btn btn-success btn-sm text-white float-end">
                                Add Employee
                            </a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered table-striped" id="employee_table">
                                <thead>
                                    <tr>
                                        <th style="width: 25px;">ID</th>
                                        <th>First Name</th>
                                        <th>Email</th>
                                        <th>Password </th>
                                        <th>Role </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->password }}</td>
                                        <td>{{ $employee->role }}</td>
                                        <td>{{ $employee->status }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ url('admin/employee/' . $employee->id . '/edit') }}" class="btn btn-link btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ url('admin/employee/' . $employee->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-sm text-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this Employee?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
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
            $('#employee_table').DataTable();
        });
    </script>
@endsection
