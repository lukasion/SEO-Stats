<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function list(Request $request)
    {
        return Customer::all();
    }

    public function detail(Request $request, int $customerID)
    {
        return Customer::with('phrases.position')->find($customerID);
    }
}
