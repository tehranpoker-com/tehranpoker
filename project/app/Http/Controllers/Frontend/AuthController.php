<?php
/**
 * Project: Basma - Resume / CV CMS
 * @link http://themearabia.net
 * @copyright 2022
 * @author Hossam Hamed <themearabia@gmail.com> <0201094140448>
 * @version 1.0
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use hisorange\BrowserDetect\Parser as Browser;

class AuthController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * admin login
     */
    public function adminlogin(Request $request)
    {
        if (Auth::check() && Auth::user()->userlevel == 'admin') {
            return redirect(get_admin_url());
        }

        if ($request->has('email') && $request->has('password')) {

            $rules = [
                'email'         => 'required|email',
                'password'      => 'required',
            ];
    
            $message = [
                'email.required'    => admin_lang('email_required'),
                'email.email'       => admin_lang('email_correct'),
                'password.required' => admin_lang('password_required'),
            ];

            if(get_option('confirm_pincode')){
                $rules['pincode'] = 'required';
                $message['pincode.required'] = admin_lang('pincode_required');
            }

            $this->validate($request, $rules, $message);
            if(get_option('confirm_pincode')){
                $credentials = ['email' => $request->get('email'), 'password' => $request->get('password'), 'pincode' => md5($request->get('pincode')), 'userlevel' => ['admin', 'supervisor']];
            }
            else {
                $credentials = ['email' => $request->get('email'), 'password' => $request->get('password'), 'userlevel' => ['admin', 'supervisor']];
            }
            
            if (Auth::attempt($credentials, $request->has('remember'))) {
                $browser_detect = parent::browser_detect();
                update_user_meta('browser_detect', maybe_serialize($browser_detect), Auth::user()->id);
                update_user_meta('platformname', Browser::platformName(), Auth::user()->id);
                update_user_meta('browserfamily', Browser::browserFamily(), Auth::user()->id);
                update_user_meta('signintime', time(), Auth::user()->id);
                if(get_option('confirm_pincode')){
                    $request->session()->put('auth.pincode_confirmed_at', time());
                }
                return redirect(get_admin_url());
            } else {
                return redirect()->back()->with('errorlogin', 'true');
            }
        } else {
            $data['page_title'] = admin_lang('login');
            return get_admin_view('dashboard_login', $data);
        }
    }
    
    /**
     * index admin pincode confirm
     */
    public function admin_pincode_confirm(Request $request)
    {
        $confirmedAt = time() - $request->session()->get('auth.pincode_confirmed_at', 0);
        $pincodeTimeout = 38800;
        $adminredirecturl = $request->session()->get('adminredirecturl');
        if(!$adminredirecturl) {
            $request->session()->put('adminredirecturl', get_admin_url());
        }
        if(Auth::check() && $confirmedAt > $pincodeTimeout) {
            $data['page_title'] = admin_lang('pincode_confirmed');
            return get_admin_view('pincode_confirmed', $data);
        }
        else {
            $browser_detect = parent::browser_detect();
            update_user_meta('browser_detect', maybe_serialize($browser_detect), Auth::user()->id);
            update_user_meta('platformname', Browser::platformName(), Auth::user()->id);
            update_user_meta('browserfamily', Browser::browserFamily(), Auth::user()->id);
            update_user_meta('signintime', time(), Auth::user()->id);
            return redirect(get_admin_url());
        }
    }
    
    /**
     * admin pincode confirm
     */
    public function admin_pincode_confirm_post(Request $request)
    {
        $confirmedAt = time() - $request->session()->get('auth.pincode_confirmed_at', 0);
        $pincodeTimeout = 38800;
        if(Auth::check() && $confirmedAt > $pincodeTimeout) {
            $this->validate($request, ['pincode' => 'required'], ['pincode.required' => admin_lang('pincode_required')]);
            $user       = Auth::user();
            $pincode    = md5($request->get('pincode'));
            $is_confirm = DB::table(USERS_TABLE)->where(['id' => $user->id, 'pincode' => $pincode])->whereIn('userlevel', ['admin', 'supervisor'])->exists();
            if($is_confirm) {
                $request->session()->put('auth.pincode_confirmed_at', time());
                $adminredirecturl = $request->session()->get('adminredirecturl');
                return ($adminredirecturl)? redirect($adminredirecturl) :   redirect(get_admin_url());
            }
            else {
                return redirect()->back()->with('errorpincode', 'true');
            }
        }
        else {
            $browser_detect = parent::browser_detect();
            update_user_meta('browser_detect', maybe_serialize($browser_detect), Auth::user()->id);
            update_user_meta('platformname', Browser::platformName(), Auth::user()->id);
            update_user_meta('browserfamily', Browser::browserFamily(), Auth::user()->id);
            update_user_meta('signintime', time(), Auth::user()->id);
            return redirect(get_admin_url());
        }
    }

    /**
     * logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
