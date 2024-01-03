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
use File;

class LanguagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }

    /**
     * languages
     */
    public function languages()
    {
        $data['page_class']     = 'languages';
        $data['languages']      = DB::table(LANGUAGE_TABLE)->get();
        $data['page_title']     = admin_lang('languages');
        $data['action']         = 'addnew';
        $data['direction']      = 'ltr';
        $data['lang_status']    = 1;
        return get_admin_view('languages.languages', $data);
    }
    
    /**
     * edit_languages
     */
    public function edit_language($id, Request $request)
    {
        $lang = DB::table(LANGUAGE_TABLE)->where([['id', '=', $id]])->get();
        if ($lang->count()) {
            $single                 = $lang->first();
            $data['lang']           = $single;
            $data['lang_status']    = $single->status;
            $data['action']         = 'update';
            $data['page_title']     = admin_lang('languages');
            $data['page_class']     = 'languages';
            $data['languages']      = DB::table(LANGUAGE_TABLE)->get();
            $data['direction']      = $single->direction;
            return get_admin_view('languages.languages', $data);
        } else {
            return redirect(get_admin_url('languages'));
        }
    }

    /**
     * edit_language_phrases
     */
    public function edit_language_phrases($id, Request $request)
    {
        $lang = DB::table(LANGUAGE_TABLE)->where([['id', '=', $id]])->get();
        if ($lang->count()) {
            $single                 = $lang->first();
            $data['single']         = $single;
            $data['lang_id']        = $single->id;
            $data['page_title']     = admin_lang('phrases').'( '.$single->name.' )';
            $data['page_class']     = 'languages';

            if(!file_exists(resource_path('lang/'.$single->code.'/global.php'))){
                $this->create_file_lang($single->code);
            }
            
            $data['phrases'] = File::getRequire(resource_path('lang/'.$single->code.'/global.php')); 

            return get_admin_view('languages.language_phrases', $data);
        } else {
            return redirect(get_admin_url('languages'));
        }
    }

    /**
     * languages_sendform
     */
    public function language_sendform(Request $request)
    {
        if ($request->has('action') && $request->get('action') == 'addnew')
        {
            $code = ($request->has('code'))? $request->get('code') : 'en';
            $is_lang = DB::table(LANGUAGE_TABLE)->where([['code', '=', $code]])->get();
            if(!$is_lang->count()){
                DB::table(LANGUAGE_TABLE)->insertGetId([
                    'name'      => ($request->has('name'))? $request->get('name') : 'none',
                    'code'      => ($request->has('code'))? $request->get('code') : 'en',
                    'direction' => ($request->has('direction')) ? $request->get('direction') : 'ltr',
                    'status'    => ($request->has('status')) ? 1 : 0,
                ]);
                $success = admin_lang('msg_lang_add');

                $this->create_file_lang($code);

                if ($request->hasFile('json')) {
                    $filename = $code.'.' . request()->json->getClientOriginalExtension();
                    $request->json->move(resource_path('lang/default/json/'), $filename);
                    $json = json_decode(file_get_contents(resource_path('lang/default/json/'.$filename)), true); 
                    save_phrases($json, $code);
                    File::copy( resource_path('lang/'.$code.'/global.php'), resource_path('lang/default/'.$code.'.php') );
                }                
            }
            else {
                $success = admin_lang('msg_lang_add');
            }
        } 
        elseif ($request->has('action') && $request->get('action') == 'update')
        {
            $lang_id = $request->get('lang_id');
            DB::table(LANGUAGE_TABLE)->where(['id' => $lang_id])->update([
                'name'      => ($request->has('name'))? $request->get('name') : 'none',
                'code'      => ($request->has('code'))? $request->get('code') : 'en',
                'direction' => ($request->has('direction')) ? $request->get('direction') : 'ltr',
                'status'    => ($request->has('status')) ? 1 : 0,
            ]);
            $success = admin_lang('msg_lang_updated');
        }


        return redirect(get_admin_url('languages'))->with("success", $success);
    }
    
    /**
     * languages_actions
     */
    public function languages_actions(Request $request)
    {
        if ($request->has('query') && $request->get('query') == 'action') {
            $marks = $request->get('mark');
            if ($request->get('action') == 'enable' and is_array($marks)) {
                foreach ($marks as $markid) {
                    DB::table(LANGUAGE_TABLE)->where(['id' => $markid])->update(['status' => '1']);
                }
                $success = admin_lang('msg_enable_selected');
            } elseif ($request->get('action') == 'disable' and is_array($marks)) {
                foreach ($marks as $markid) {
                    DB::table(LANGUAGE_TABLE)->where(['id' => $markid])->update(['status' => '0']);
                }
                $success = admin_lang('msg_disable_selected');
            } elseif ($request->get('action') == 'delete' and is_array($marks)) {
                foreach ($marks as $markid) {
                    $code = DB::table(LANGUAGE_TABLE)->where(['id' => $markid])->value('code');
                    File::deleteDirectory( resource_path('lang/'.$code) );
                    DB::table(LANGUAGE_TABLE)->where(['id' => $markid])->delete();
                }
                $success = admin_lang('msg_delete_selected');
            } else {
                $success = admin_lang('msg_noselectaction');
            }
            return redirect()->back()->with("success", $success);
        }
    }
    
    /**
     * enable_language
     */
    public function enable_language($id)
    {
        DB::table(LANGUAGE_TABLE)->where(['id' => $id])->update(['status' => '1']);
        return redirect()->back()->with("success", admin_lang('msg_lang_enable'));
    }
    
    /**
     * disable_language
     */
    public function disable_language($id)
    {
        DB::table(LANGUAGE_TABLE)->where(['id' => $id])->update(['status' => '0']);
        return redirect()->back()->with("success", admin_lang('msg_lang_disable'));
    }
    
    /**
     * delete_language
     */
    public function delete_language($id, $token)
    {
        $code = DB::table(LANGUAGE_TABLE)->where(['id' => $id])->value('code');
        File::deleteDirectory( resource_path('lang/'.$code) );
        DB::table(LANGUAGE_TABLE)->where(['id' => $id])->delete();
        return redirect()->back()->with("success", admin_lang('msg_lang_delete'));
    }

    /**
     * refresh_language_phrases
     */
    public function refresh_language_phrases($id)
    {
        $lang = DB::table(LANGUAGE_TABLE)->where([['id', '=', $id]])->get();
        if ($lang->count()) {
            $single = $lang->first();
            $this->create_file_lang($single->code);
            return redirect()->back()->with("success", admin_lang('msg_lang_updated'));
        }
        else {
            return redirect()->back();
        }
    }

    public function create_file_lang($code)
    {
        $path = resource_path('lang/'.$code);
        if (!File::exists($path)) {
            File::makeDirectory($path, '0755', true);
        }

        if(file_exists(resource_path('lang/default/'.$code.'.php'))){
            File::copy( resource_path('lang/default/'.$code.'.php'), resource_path('lang/'.$code.'/global.php') );
        }
        else {
            File::copy( resource_path('lang/default/global.php'), resource_path('lang/'.$code.'/global.php') );
        }

    }
}