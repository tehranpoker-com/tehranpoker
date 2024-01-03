<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AdminPinMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*
    public function handle($request, Closure $next)
    {

        if (Auth::check() && in_array(Auth::user()->userlevel, ['admin'])) {
            return $next($request);
        } else {
            return redirect(get_admin_url('confirm/pincode'));
        }
    }
    */


    /**
     * The response factory instance.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $responseFactory;

    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $urlGenerator;

    /**
     * The password timeout.
     *
     * @var int
     */
    protected $pincodeTimeout;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Routing\ResponseFactory  $responseFactory
     * @param  \Illuminate\Contracts\Routing\UrlGenerator  $urlGenerator
     * @param  int|null  $pincodeTimeout
     * @return void
     */
    public function __construct(ResponseFactory $responseFactory, UrlGenerator $urlGenerator, $pincodeTimeout = null)
    {
        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
        $this->pincodeTimeout = $pincodeTimeout ?: 38800;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if(get_option('confirm_pincode')){
            if ($this->shouldConfirmPassword($request)) {
                Session::put('adminredirecturl', URL::current());
                if ($request->expectsJson()) {
                    return $this->responseFactory->json([
                        'message' => 'Pin Code confirmation required.',
                    ], 423);
                }
    
                return $this->responseFactory->redirectGuest(
                    $this->urlGenerator->route($redirectToRoute ?? 'pincode.confirm')
                );
            }
    
            return $next($request);
        }
        else {
            return $next($request);
        }
    }
    
    /**
     * Determine if the confirmation timeout has expired.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldConfirmPassword($request)
    {
        $confirmedAt = time() - $request->session()->get('auth.pincode_confirmed_at', 0);
        return $confirmedAt > $this->pincodeTimeout;
    }


}