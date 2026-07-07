<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomerActive
{
    public function handle(Request $request, Closure $next)
    {
        // Check both customer guard and default web guard
        $guards = ['customer', 'web'];
        
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Only act if the user model is Customer
                if ($user instanceof \App\Models\Customer) {
                    $freshUser = $user->fresh();
                    
                    // If user is deactivated (status 0 or '0' or empty)
                    if (!$freshUser || empty($freshUser->status) || $freshUser->status == 0 || $freshUser->status === '0') {
                        \Log::warning("Deactivated customer attempted access: " . $user->email);
                        
                        Auth::guard($guard)->logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();

                        return redirect()->route('login')
                            ->with('error', 'Your account has been deactivated. Please contact support.');
                    }
                }
            }
        }

        return $next($request);
    }
}
