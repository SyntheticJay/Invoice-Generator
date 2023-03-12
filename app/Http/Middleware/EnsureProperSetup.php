<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Currency\Currency;
use App\Models\Customer\Customer;
use App\Models\VATRule\VATRule;
use App\Models\Invoice\Invoice;

class EnsureProperSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {        
        $currencies = auth()->user()->currencies()->where('is_archived', false)->get();
        $customers  = auth()->user()->customers()->where('is_archived', false)->get();
        $vatRules   = auth()->user()->vatRules()->where('is_archived', false)->get(); 
        $invalid    = $currencies->count() === 0 || $customers->count() === 0 || $vatRules->count() === 0;

        if ($invalid) {
            return redirect()->route('home')->with('error', 'The system is not properly set up. Please ensure you have created essential data such as currencies and customers.');
        }

        return $next($request);
    }
}
