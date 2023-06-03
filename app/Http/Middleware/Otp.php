<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class Otp
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
        if (auth()->user()->phone_num_verified_at === null) {
            // abort(403);
            if (auth()->user()->otp_expires_at >= Carbon::now()) {
                return redirect(route('verification.otp'));
            }
            return redirect(route('otp.resend'));
        }
        return $next($request);
    }
}