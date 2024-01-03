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
use TorMorten\Eventy\Facades\Events as Eventy;


class PostsController extends Controller
{
    private $paginate;
    private $default_type;

    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
        $this->paginate = 20;
        $this->default_type = [
            'pages', 
            'posts', 
            'portfolio', 
            'services', 
            'pricings', 
            'workingway', 
            'testimonials', 
            'clients', 
            'funfacts', 
            'education', 
            'experience', 
            'skills', 
            'faqs'
        ];
    }

    /**
     * index_posts
     */
    public function index_posts($type, Request $request)
    {
        $identifier_types = identifier_types();
        if(array_key_exists($type, $identifier_types)) {
            if(isset($identifier_types[$type]['slug'])){
                $data['type_slug']  = $identifier_types[$type]['slug'];
            }
            else {
                $data['type_slug']  = $type;
            }            
            $data['url_prefix'] = 'post';
            $data['btn_new']    = $type;
            $data['post_type']  = $type;
            $data['type']       = $type;
            $data['page_title'] = admin_lang($type);
            $data['page_class'] = $type;        
            $posts              = DB::table(POSTS_TABLE)->where([['post_type', '=', $type]]);
            if($request->get('s')){
                $posts->where('post_title', 'like', '%'.$request->get('s').'%');
            }
            $posts = $posts->orderBy('post_pin', 'desc')->orderBy('post_orders', 'asc')->orderBy('post_modified', 'desc')->paginate($this->paginate);
            if ($request->has('page') and $request->get('page') > $posts->lastPage()) {return redirect($posts->url($posts->lastPage()));}
            $data['posts'] = $posts;
            return get_admin_view('posts.' . $type . '.index_posts', $data);
        } else {
            return redirect(get_admin_url('/'));
        }
    }

    /**
     * index_duplicate
     */
    public function index_duplicate($id, Request $request)
    {
        $post = DB::table(POSTS_TABLE)->where([['id', '=', $id]])->get();
        if ($post->count()) {
            $single = $post->first();
            $type = $single->post_type;
            $user = Auth::user();
            $new_post_id = DB::table(POSTS_TABLE)->insertGetId([
                'post_author'       => $user->id,
                'post_title'        => $single->post_title. ':Duplicate',
                'post_name'         => preg_slug($single->post_name, 'post', $single->post_type),
                'post_excerpts'     => $single->post_excerpts,
                'post_content'      => $single->post_content,
                'post_type'         => $single->post_type,
                'term_id'           => $single->term_id,
                'post_views'        => 0,
                'post_tags'         => $single->post_tags,
                'post_pin'          => $single->post_pin,
                'post_orders'       => $single->post_orders,
                'comment_status'    => $single->comment_status,
                'post_status'       => $single->post_status,
            ]);
            $postsmeta = DB::table(POSTSMETA_TABLE)->where([['post_id', '=', $single->id]])->get();
            foreach($postsmeta as $meta)
            {
                update_post_meta($meta->meta_key, $meta->meta_value, $new_post_id);
            }
            return redirect(get_admin_url('editpost/'.$new_post_id))->with("success", admin_lang('msg_duplicate_success'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * index_postnew
     */
    public function index_postnew($type, Request $request)
    {
        if(array_key_exists($type, identifier_types()))
        {
            $identifier_types       = identifier_types();
            if(isset($identifier_types[$type]['slug'])){
                $data['type_slug']  = $identifier_types[$type]['slug'];
            }
            else {
                $data['type_slug']  = $type;
            }

            $data['categories']     = get_categories_type($type);
            $data['isfiles']        = false;
            $data['type']           = $type;
            $data['action']         = 'addnew';
            $data['page_title']     = admin_lang($type);
            $data['page_class']     = 'add'.$type;
            $data['post_status']    = '1';
            $data['comment_status'] = '1';
            $data['post_pin']       = '0';
            $data['post_excerpts']  = '';
            $data['post_tags']      = '';
            $data['meta_desc']      = '';
            $data['post_id']        = '';
            $data['post_title']     = '';
            $data['post_content']   = '';
            $data['thumbnails_id']  = '';
            $data['thumbnails']     = '';
            $data['term_id']        = '';
            $data['post_orders']    = get_posts_count($type, 1);
            $data['details']        = [];
            $data['ex_data']        = [];
            $data['ex_data']        = Eventy::filter('admin_filter_newpost_'.$type, $data['ex_data']);
            $data['bgimage']        = '';
            $data['style']          = 'normal';
            $data['gallery']        = [];
            $data['portfolio_type'] = 'normal';
            $data['video_url']      = '';
            $data['iframe_url']     = '';
            return get_admin_view('posts.' . $type . '.index_postform', $data);
        }
        else
        {
            return redirect(get_admin_url('/'));
        }    
    }

    /**
     * index_editpost
     */
    public function index_editpost($id, Request $request)
    {
        $post = DB::table(POSTS_TABLE)->where([['id', '=', $id]])->get();
        if ($post->count()) {
            $single = $post->first();
            $type = $single->post_type;

            if(array_key_exists($type, identifier_types())){
                $identifier_types = identifier_types();
                if(isset($identifier_types[$type]['slug'])){
                    $data['type_slug']  = $identifier_types[$type]['slug'];
                }
                else {
                    $data['type_slug']  = $type;
                }
                
                $data['post']           = $single;
                $data['categories']     = get_categories_type($type);
                $data['type']           = $type;
                $data['action']         = 'update';
                $data['page_title']     = admin_lang($type);
                $data['page_class']     = $type;            
                $data['post_id']        = $single->id;
                $data['post_status']    = $single->post_status;
                $data['comment_status'] = $single->comment_status;
                $data['post_id']        = $single->id;
                $data['post_title']     = $single->post_title;
                $data['post_excerpts']  = $single->post_excerpts;
                $data['post_content']   = $single->post_content;
                $data['post_pin']       = $single->post_pin;
                $data['post_tags']      = $single->post_tags;
                $data['meta_desc']      = get_post_meta('meta_desc', $single->id);
                $data['thumbnails_id']  = get_post_meta('thumbnails', $single->id, '');
                $data['thumbnails']     = get_attachment_url($data['thumbnails_id'], 'full');
                $data['term_id']        = $single->term_id;
                $data['post_orders']    = $single->post_orders;
                if($type == 'portfolio'){
                    $details                = get_post_meta('details', $single->id);
                    $data['details']        = (is_serialized($details))? maybe_unserialize($details) : [];
                    $gallery                = get_post_meta('gallery', $single->id);
                    $data['gallery']        = (is_serialized($gallery))? maybe_unserialize($gallery) : [];
                    $data['portfolio_type'] = get_post_meta('portfolio_type', $single->id, 'normal');
                    $data['video_url']      = get_post_meta('video_url', $single->id);
                    $data['iframe_url']     = get_post_meta('iframe_url', $single->id);
                }
                $data['ex_data']        = ['post_id' => $single->id];
                $data['ex_data']        = Eventy::filter('admin_filter_editpost_'.$type, $data['ex_data']);
                $data['style']          = get_post_meta('style', $single->id);
                $data['bgimage']        = get_post_meta('bgimage', $single->id);
                
                return get_admin_view('posts.' . $type . '.index_postform', $data);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * posts_sendform
     */
    public function posts_sendform(Request $request)
    {
        $user = Auth::user();
        $post_type = $request->get('post_type');

        $post_name = ($request->has('post_name') && !empty($request->get('post_name'))) ? $request->get('post_name') :$request->get('title');
        if ($request->has('action') && $request->get('action') == 'addnew')
        {
            $post_id = DB::table(POSTS_TABLE)->insertGetId([
                'post_author'       => $user->id,
                'post_title'        => $request->get('title'),
                'post_name'         => preg_slug($post_name, 'post', $post_type),
                'post_excerpts'     => ($request->has('post_excerpts')) ? $request->get('post_excerpts') : null,
                'post_content'      => ($request->has('content')) ? $request->get('content') : null,
                'post_type'         => $post_type,
                'term_id'           => ($request->has('term_id')) ? $request->get('term_id') : '0',
                'post_views'        => 0,
                'post_tags'         => ($request->has('post_tags')) ? $request->get('post_tags') : null,
                'post_pin'          => ($request->has('post_pin')) ? $request->get('post_pin') : '0',
                'post_orders'       => ($request->has('post_orders')) ? $request->get('post_orders') : '0',
                'comment_status'    => ($request->has('comment_status')) ? $request->get('comment_status') : '0',
                'post_status'       => ($request->has('post_status')) ? $request->get('post_status') : '0',
            ]);
            $success = admin_lang('msg_post_add');
        }
        elseif ($request->has('action') && $request->get('action') == 'update')
        {
            $post_id   = $request->get('post_id');
            DB::table(POSTS_TABLE)->where(['id' => $post_id])->update([
                'post_author'       => $user->id,
                'post_title'        => $request->get('title'),
                'post_name'         => preg_slug($post_name, 'post', $post_type, $post_id),
                'post_excerpts'     => ($request->has('post_excerpts')) ? $request->get('post_excerpts') : null,
                'post_content'      => ($request->has('content')) ? $request->get('content') : null,
                'post_type'         => $post_type,
                'term_id'           => ($request->has('term_id')) ? $request->get('term_id') : '0',
                'post_views'        => 0,
                'post_tags'         => ($request->has('post_tags')) ? $request->get('post_tags') : null,
                'post_pin'          => ($request->has('post_pin')) ? $request->get('post_pin') : '0',
                'post_orders'       => ($request->has('post_orders')) ? $request->get('post_orders') : '0',
                'comment_status'    => ($request->has('comment_status')) ? $request->get('comment_status') : '0',
                'post_status'       => ($request->has('post_status')) ? $request->get('post_status') : '0',
            ]);
            $success = admin_lang('msg_post_updated');
        }

        if ($request->has('post_pin')) {
            if($request->get('post_pin')){
                DB::table(POSTS_TABLE)->where([['post_type', '=', $post_type], ['id', '!=', $post_id]])->update(['post_pin' => 0]);
            }
        }

        if($request->has('postmeta')){
            $postmeta = mega_parse_args($request->get('postmeta'), get_default_postmeta($post_type));
        }
        else {
            $postmeta = get_default_postmeta($post_type);
        }
        
        foreach ($postmeta as $key => $value) {
            if(is_array($value)){
                $value = maybe_serialize($value);
            }
            update_post_meta($key, $value, $post_id);
        }

        if($post_type == ''){
            if(isset($postmeta['recommend'])){
                update_post_meta('recommend', '1', $post_id);
            }
            else {
                update_post_meta('recommend', '0', $post_id);
            }
        }
        


        if($request->has('thumbnails')){
            update_post_meta('thumbnails', $request->get('thumbnails'), $post_id);
        }

        Eventy::action('admin_posts_sendform_'.$post_type, ['request' => $request, 'post_id' => $post_id]);
        
        return redirect(get_admin_url('editpost/' . $post_id))->with("success", $success);
    }

    /**
     * posts_actions
     */
    public function posts_actions(Request $request)
    {
        if ($request->has('query') && $request->get('query') == 'action') {
            $marks = $request->get('mark');
            if ($request->get('action') == 'enable' and is_array($marks)) {
                foreach ($marks as $markid) {
                    $type = get_post_column($markid, 'post_type');
                    DB::table(POSTS_TABLE)->where(['id' => $markid])->update(['post_status' => '1']);
                }
                $success = admin_lang('msg_enable_selected');
            } elseif ($request->get('action') == 'disable' and is_array($marks)) {
                foreach ($marks as $markid) {
                    $type = get_post_column($markid, 'post_type');
                    DB::table(POSTS_TABLE)->where(['id' => $markid])->update(['post_status' => '0']);
                }
                $success = admin_lang('msg_disable_selected');
            } elseif ($request->get('action') == 'delete' and is_array($marks)) {
                foreach ($marks as $markid) {
                    $type = get_post_column($markid, 'post_type');
                    DB::table(POSTS_TABLE)->where(['id' => $markid])->delete();
                    DB::table(POSTSMETA_TABLE)->where(['post_id' => $markid])->delete();
                }
                $success = admin_lang('msg_delete_selected');
            } elseif ($request->get('action') == 'reorders' and is_array($marks)) {
                $idx    = $request->get('idx');
                $order  = $request->get('order');
                for ($i = 0; $i < count($idx); $i++) {
                    $theid      = $idx[$i];
                    $neworder   = $order[$i];
                    $type = get_post_column($theid, 'post_type');
                    DB::table(POSTS_TABLE)->where(['id' => $theid])->update(['post_orders' => $neworder]);
                }
                $success = admin_lang('msg_reorders_selected');
            } else {
                $success = admin_lang('msg_noselectaction');
            }
            return redirect()->back()->with("success", $success);
        }
    }

    /**
     * index_enablepost
     */
    public function index_enablepost($id)
    {
        $type = get_post_column($id, 'post_type');
        DB::table(POSTS_TABLE)->where(['id' => $id])->update(['post_status' => '1']);
        return redirect()->back()->with("success", admin_lang('msg_post_enable'));
    }

    /**
     * index_disablepost
     */
    public function index_disablepost($id)
    {
        $type = get_post_column($id, 'post_type');
        DB::table(POSTS_TABLE)->where(['id' => $id])->update(['post_status' => '0']);
        return redirect()->back()->with("success", admin_lang('msg_post_disable'));
    }
    
    /**
     * index_deletepost
     */
    public function index_deletepost($id, $token)
    {
        $type = get_post_column($id, 'post_type');
        DB::table(POSTS_TABLE)->where(['id' => $id])->delete();
        DB::table(POSTSMETA_TABLE)->where(['post_id' => $id])->delete();
        return redirect()->back()->with("success", admin_lang('msg_post_delete'));
    }

}
