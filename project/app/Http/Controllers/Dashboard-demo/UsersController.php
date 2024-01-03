<?php
/**
 * Project: Basma - Resume / CV CMS
 * @link http://themearabia.net
 * @copyright 2022
 * @author Hossam Hamed <themearabia@gmail.com> <0201094140448>
 * @version 1.0
 */

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }

    /**
     * index_profile
     */
    public function index_profile(Request $request)
    {
        $curre_user = Auth::user();
        $user_id = $curre_user->id;
        $getuser = DB::table(USERS_TABLE)->where([['id', '=', $user_id]])->get();
        if ($getuser->count()) {
            $type               = 'users';
            $user               = $getuser->first();
            $data['user']       = $user;
            $data['type']       = $type;
            $data['page_class'] = $type;
            $data['action']     = 'update';
            $data['page_title'] = admin_lang('profile').' '.$data['user']->username;
            $data['user_meta']  = query_user_meta($data['user']->id);
            $data['signintime'] = get_user_meta('signintime', $user->id);
            $data['details']['ip'] = get_user_meta('ip', $user->id);
            $data['details']['useragent'] = get_user_meta('useragent', $user->id);
            $data['details']['platformname'] = get_user_meta('platformname', $user->id);
            $data['details']['browserfamily'] = get_user_meta('browserfamily', $user->id);
            $datauser                   = $user;
            $data['user_userlevel']     = $curre_user->userlevel;
            $data['userlevel']          = $datauser->userlevel;
            $data['type']               = $datauser->userlevel;
            $data['page_class']         = $datauser->userlevel;
            $data['action']             = 'update';
            $data['userid']             = $datauser->id;
            $data['username']           = $datauser->username;
            $data['email']              = $datauser->email;
            return get_admin_view('index_profile', $data);
        }
    }

    /**
     * users_sendform
     */
    public function users_sendform(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'username'  => 'required',
            'email'     => 'required|email'
        ];

        $messages = [
            'username.required'     => admin_lang('username_required'),
            'email.required'        => admin_lang('email_required'),
            'email.email'           => admin_lang('email_correct'),
        ];

        
        $this->validate($request, $rules, $messages);

        /*
        DB::table(USERS_TABLE)->where(['id' => $user->id])->update([
            'username'          => safe_input($request->get('username'), false), 
            'email'             => safe_input($request->get('email'), false), 
            'updated_at'        => now(),
        ]);

        // update password
        if($request->has('password') and !empty($request->get('password'))){
            DB::table(USERS_TABLE)->where(['id' => $user->id])->update(['password' => Hash::make($request->get('password'))]);
        }
        
        // update pincode
        if($request->has('pincode') and !empty($request->get('pincode'))){
            DB::table(USERS_TABLE)->where(['id' => $user->id])->update(['pincode' => md5($request->get('pincode'))]);
        }
        
        // update usermeta
        if ($request->has('usermeta')) {
            foreach ($request->get('usermeta') as $key => $value) {
                update_user_meta($key, $value, $user->id);
            }
        }
        */
        $success = admin_lang('msg_profile_updated');
        // redirect
        return redirect(get_admin_url('profile'))->with("success", $success);
    }
}