<?php

namespace App\Http\Controllers\Currency;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Currency\Currency;
use App\Http\Requests\Currency\CreateCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = auth()->user()->currencies()->get();

        return view('currency.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currency.factory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateCurrencyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCurrencyRequest $request)
    {
        try {
            auth()->user()->currencies()->create($request->validated());

            return redirect()->route('currency.index')->with('success', 'Currency created successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('currency.index')->with('error', 'Currency could not be created');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('currency.factory', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCurrencyRequest  $request
     * @param  \App\Models\Currency\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        try {
            $currency->update($request->validated());

            return redirect()->route('currency.index')->with('success', 'Currency updated successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('currency.index')->with('error', 'Currency could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        try {
            $currency->update(['is_archived' => true]);

            return redirect()->route('currency.index')->with('success', 'Currency deleted successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('currency.index')->with('error', 'Currency could not be deleted');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \App\Models\Currency\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function unarchive(Currency $currency)
    {
        try {
            $currency->update(['is_archived' => false]);

            return redirect()->route('currency.index')->with('success', 'Currency restored successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('currency.index')->with('error', 'Currency could not be restored');
        }
    }
}
