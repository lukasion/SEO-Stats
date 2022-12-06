<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Phrase;
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

    public function phraseAdd(Request $request, ?int $customerID)
    {
        $phrase = null;

        if (!empty($request->name) && !empty($customerID)) {
            $phrase              = new Phrase();
            $phrase->name        = $request->name;
            $phrase->customer_id = $customerID;
            $phrase->save();
        }

        return $phrase;
    }
}
