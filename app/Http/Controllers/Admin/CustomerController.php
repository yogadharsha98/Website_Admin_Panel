<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function updateStatus(Request $request, $id)
    {
        $customer = Customer::findOrFail($id); // Find the customer by ID
        $customer->status = $request->status; // Update the status
        $customer->save(); // Save changes to the database

        return response()->json(['success' => 'Status updated successfully']);
    }
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id); // Fetch the customer
            $customer->delete(); // Delete the customer

            return response()->json(['message' => 'Customer deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete customer'], 500);
        }
    }

}
