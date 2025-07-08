<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::all();
        return view('admin.employee.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employee.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email', // Add 'unique' rule
            'password' => 'required|min:8', // Add 'min' rule
            'role' => 'required|in:worker,supervisor,manager',
            'status' => 'required|in:active,inactive',
        ], [
            'email.unique' => 'This email is already registered.',
            'password.min' => 'The password must be at least 8 characters long.',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->role = $validatedData['role'];
        $user->status = $validatedData['status'];
        $user->save();

        return redirect()->route('admin.employee.index')->with('message', 'Employee Added Successfully');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $options = [
            'roles' => ['worker', 'supervisor', 'manager'],
            'statuses' => ['active' => 'Active', 'inactive' => 'Inactive'],
        ];

        return view('admin.employee.edit', compact('employee', 'options'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:worker,supervisor,manager',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->status = $validatedData['status'];
        $user->save();

        return redirect()->route('admin.employee.index')->with('message', 'Employee Updated Successfully');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employee.index')->with('message', 'Employee Deleted Successfully');
    }


}
