<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Country\Country;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Requests\Customer\CreateCustomerRequest;

use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = auth()->user()->customers()->get();

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();    

        return view('customer.factory', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        try {
            auth()->user()->customers()->create($request->validated());
            
            return redirect()->route('customer.index')->with('success', 'Customer created successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('customer.index')->with('error', 'Customer could not be created');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        if ($customer->is_archived) {
            return redirect()->route('customer.index')
                    ->with('error', 'That customer has been archived. Please restore it before editing.');
        }
        
        $countries = Country::all();

        return view('customer.factory', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCustomerRequest  $request
     * @param  \App\Models\Invoice\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            $customer->update($request->validated());
        
            return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('customer.index')->with('error', 'Customer could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->update(['is_archived' => true]);

            return redirect()->route('customer.index')->with('success', 'Customer deleted successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('customer.index')->with('error', 'Customer could not be deleted');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \App\Models\Invoice\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function unarchive(Customer $customer)
    {
        try {
            $customer->update(['is_archived' => false]);

            return redirect()->route('customer.index')->with('success', 'Customer restored successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('customer.index')->with('error', 'Customer could not be restored');
        }
    }
}
