<?php

namespace App\Http\Controllers\VATRule;

use App\Http\Controllers\Controller;
use App\Models\VATRule\VATRule;
use Illuminate\Http\Request;

use App\Http\Requests\VATRule\CreateVATRuleRequest;
use App\Http\Requests\VATRule\UpdateVATRuleRequest;

class VATRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vatRules = auth()->user()->vatRules()->get();

        return view('vatrule.index', compact('vatRules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vatrule.factory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateVATRuleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVATRuleRequest $request)
    {
        try {
            auth()->user()->vatRules()->create($request->validated());

            return redirect()->route('vatrule.index')->with('success', 'VAT Rule created successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('vatrule.index')->with('error', 'VAT Rule could not be created');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VATRule\VATRule  $vatRule
     * @return \Illuminate\Http\Response
     */
    public function edit($vatRuleId)
    {
        $vatRule = VATRule::findOrFail($vatRuleId);

        return view('vatrule.factory', compact('vatRule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VATRule\VATRule  $vatRule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVATRuleRequest $request, $vatRuleId)
    {
        try {
            VATRule::findOrFail($vatRuleId)->update($request->validated());

            return redirect()->route('vatrule.index')->with('success', 'VAT Rule updated successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('vatrule.index')->with('error', 'VAT Rule could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VATRule\VATRule  $vatRule
     * @return \Illuminate\Http\Response
     */
    public function destroy($vatRuleId)
    {
        try {
            VATRule::findOrFail($vatRuleId)->update(['is_archived' => true]);

            return redirect()->route('vatrule.index')->with('success', 'VAT Rule deleted successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('vatrule.index')->with('error', 'VAT Rule could not be deleted');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \App\Models\VATRule\VATRule  $vatRule
     * @return \Illuminate\Http\Response
     */
    public function unarchive($vatRuleId)
    {
        try {
            VATRule::findOrFail($vatRuleId)->update(['is_archived' => false]);

            return redirect()->route('vatrule.index')->with('success', 'VAT Rule restored successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('vatrule.index')->with('error', 'VAT Rule could not be restored');
        }
    }
}
