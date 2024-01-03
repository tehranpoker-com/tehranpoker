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

class MessagesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }

    /**
     * index_messages
     */
    public function index_messages($type, Request $request)
    {
        $data['page_title'] = admin_lang('messages');
        $data['page_class'] = 'messages';
        $data['list_class'] = $type;
        $posts = DB::table(POSTS_TABLE)->where([['post_type', '=', $type]]);
        if($request->get('s')){
            $posts->where('post_title', 'like', '%'.$request->get('s').'%');
        }
        $posts = $posts->orderBy('post_status', 'asc')->orderBy('post_modified', 'desc')->paginate(15);
        if ($request->has('page') and $request->get('page') > $posts->lastPage()) {return redirect($posts->url($posts->lastPage()));}
        $data['posts'] = $posts;
        $data['post_type'] = $type;
        return get_admin_view('messages.index_messages', $data);
    }
    
    /**
     * index_message_show
     */
    public function index_message_show($id, Request $request)
    {
        $post = DB::table(POSTS_TABLE)->where([['id', '=', $id]])->get();
        if ($post->count()) {
            $single                 = $post->first();
            $type                   = $single->post_type;
            $data['list_class']     = $type;
            $data['post']           = $single;
            $data['post_type']      = $type;
            $data['page_title']     = admin_lang($type);
            $data['page_class']     = $type;
            $data['post_status']    = $single->post_status;
            $data['post_id']        = $single->id;
            $data['post_title']     = $single->post_title;
            $post_excerpts          = maybe_unserialize($single->post_excerpts);
            $data['username']       = (isset($post_excerpts['username']))? $post_excerpts['username'] : '';
            $data['email']          = (isset($post_excerpts['email']))? $post_excerpts['email'] : '';
            $data['subject']        = (isset($post_excerpts['subject']))? $post_excerpts['subject'] : '';
            $data['phone']          = (isset($post_excerpts['phone']))? $post_excerpts['phone'] : '';
            $data['date']           = (isset($post_excerpts['date']))? $post_excerpts['date'] : '';
            $data['time']           = (isset($post_excerpts['time']))? $post_excerpts['time'] : '';
            $data['post_content']   = $single->post_content;
            $data['modified']       = $single->post_modified;
            $browser_detect         = maybe_unserialize(get_post_meta('browser_detect', $single->id));
            $data['browser_detect'] = ($browser_detect)? $browser_detect : [];
            $data['ip']             = (isset($browser_detect['ip']))? $browser_detect['ip'] : '';
            $data['useragent']      = (isset($browser_detect['useragent']))? $browser_detect['useragent'] : '';
            $data['platformname']   = (isset($browser_detect['platformname']))? $browser_detect['platformname'] : '';
            $data['platformfamily'] = (isset($browser_detect['platformfamily']))? $browser_detect['platformfamily'] : '';
            $data['browserfamily']  = (isset($browser_detect['browserfamily']))? $browser_detect['browserfamily'] : '';

            DB::table(POSTS_TABLE)->where(['id' => $single->id])->update(['post_status' => '1']);
            return get_admin_view('messages.index_message_show', $data);
        } else {
            return redirect()->back();
        }
    }
    
    /**
     * messages_actions
     */
    public function messages_actions(Request $request)
    {
        if ($request->has('query') && $request->get('query') == 'action') {
            $marks = $request->get('mark');
            if($request->get('action') == 'markread' and is_array($marks))
            {
                foreach ($marks as $markid) {
                    DB::table(POSTS_TABLE)->where(['id' => $markid])->update(['post_status' => '1']);
                }
                $success = admin_lang('msg_markread_selected');
            }
            elseif ($request->get('action') == 'markunread' and is_array($marks))
            {
                foreach ($marks as $markid) {
                    DB::table(POSTS_TABLE)->where(['id' => $markid])->update(['post_status' => '0']);
                }
                $success = admin_lang('msg_markunread_selected');
            }
            elseif ($request->get('action') == 'delete' and is_array($marks))
            {
                foreach ($marks as $markid) {
                    DB::table(POSTS_TABLE)->where(['id' => $markid])->delete();
                    DB::table(POSTSMETA_TABLE)->where(['post_id' => $markid])->delete();
                }
                $success = admin_lang('msg_delete_selected');
            }
            else
            {
                $success = admin_lang('msg_noselectaction');
            }
            return redirect()->back()->with("success", $success);
        }
    }
    
    /**
     * message_delete
     */
    public function message_delete($id, $token, Request $request)
    {
        $token = $token;
        $post = DB::table(POSTS_TABLE)->where([['id', '=', $id]])->get();
        if ($post->count()) {
            $single                 = $post->first();
            $type                   = $single->post_type;
            DB::table(POSTS_TABLE)->where(['id' => $id])->delete();
            DB::table(POSTSMETA_TABLE)->where(['post_id' => $id])->delete();
            return redirect(get_admin_url('messages/'.$type))->with("success", admin_lang('msg_post_delete'));
        }
        else
        {
            return redirect()->back()->with("success", admin_lang('msg_noselectaction'));
        }
    }

}
