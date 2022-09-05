<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;

class Domain
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
        $domain = $request->getHost();

        if (in_array($domain, config('app.root_domains'))) {
            $request->merge([
                'isRoot' => true,
            ]);
        } else {
            $customer = Customer::where('subdomain', $domain)
                ->orWhere('custom_domain', $domain)
                ->first();

            $request->merge([
                'domain' => $domain,
                'customer' => $customer,
            ]);
        }

        return $next($request);
    }
}
