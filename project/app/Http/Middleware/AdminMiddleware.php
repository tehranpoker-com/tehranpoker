<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Themearabia\LaravelInstaller\Helpers\LicenseManager;

class AdminMiddleware
{
    
    private $LicenseManager;

    public function __construct(LicenseManager $LicenseManager)
    {
        $this->LicenseManager = $LicenseManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->userlevel, ['admin', 'supervisor'])) {
            if(!$this->LicenseManager->verify_license_status($request, true)) {
                return redirect(url('license/verify'));
            }
            else {
                return $next($request);
            }
        } else {
            return redirect(get_admin_url('login'));
        }
    }

}
