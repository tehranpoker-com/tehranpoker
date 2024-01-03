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

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }

    /**
     * categories
     */
    public function categories($type, Request $request)
    {
        if(array_key_exists($type, identifier_types()))
        {
            $data['type']           = $type;
            $data['page_class']     = $type;
            $data['categories']     = get_categories_type($type);
            $data['page_title']     = admin_lang('categories');
            $data['action']         = 'addnew';
            $data['term_style']     = 'style-progress';
            $data['term_column']    = 'col-lg-12';
            $data['cate_status']    = 1;
            return get_admin_view('categories.category_' . $type, $data);
        }
        else
        {
            return redirect(get_admin_url('/'));
        }
    }
    
    /**
     * edit_category
     */
    public function edit_category($id, Request $request)
    {
        $cate = DB::table(TERMS_TABLE)->where([['id', '=', $id]])->get();
        if ($cate->count()) {
            $single                 = $cate->first();
            $data['cate']           = $single;
            $data['type']           = $single->type;
            $data['cate_status']    = $single->status;
            $data['action']         = 'update';
            $data['page_title']     = admin_lang('categories');
            $data['page_class']     = $single->type;
            $data['categories']     = get_categories_type($single->type);
            $data['term_style']     = get_term_meta('style', $single->id);
            $data['term_column']    = get_term_meta('column', $single->id);
            return get_admin_view('categories.category_' . $single->type, $data);
        } else {
            return redirect(get_admin_url('/'));
        }
    }
    
    /**
     * categorys_sendform
     */
    public function categorys_sendform(Request $request)
    {
        $type = $request->get('type');
        if(array_key_exists($type, identifier_types()))
        {
            if ($request->has('action') && $request->get('action') == 'addnew')
            {
                $slug = ($request->has('slug') and !empty($request->get('slug'))) ? $request->get('slug') : $request->get('name');
                /*
                $term_id = DB::table(TERMS_TABLE)->insertGetId([
                    'name'          => $request->get('name'),
                    'description'   => ($request->has('description'))? $request->get('description') : null,
                    'image'         => ($request->has('image'))? $request->get('image') : null,
                    'slug'          => preg_slug($slug, 'categories', $type),
                    'parent'        => ($request->has('parent')) ? $request->get('parent') : 0,
                    'type'          => $type,
                    'orders'        => $request->get('orders'),
                    'status'        => ($request->has('status')) ? 1 : 0,
                ]);
                */
                $success = admin_lang('msg_cate_add');
            } 
            elseif ($request->has('action') && $request->get('action') == 'update')
            {
                $term_id = $request->get('term_id');
                $slug = ($request->has('slug') and !empty($request->get('slug'))) ? $request->get('slug') : $request->get('name');
                /*
                DB::table(TERMS_TABLE)->where(['id' => $term_id])->update([
                    'name'          => $request->get('name'),
                    'description'   => ($request->has('description'))? $request->get('description') : null,
                    'image'         => ($request->has('image'))? $request->get('image') : null,
                    'slug'          => preg_slug($slug, 'categories', $type, $term_id),
                    'parent'        => ($request->has('parent')) ? $request->get('parent') : 0,
                    'type'          => $type,
                    'orders'        => $request->get('orders'),
                    'status'        => ($request->has('status')) ? 1 : 0,
                ]);
                */
                $success = admin_lang('msg_cate_updated');
            }

            /*
            $termmeta = $request->get('termmeta');
            if(is_array($termmeta)){
                foreach ($termmeta as $key => $value) {
                    if(is_array($value)){
                        $value = maybe_serialize($value);
                    }
                    update_term_meta($key, $value, $term_id);
                }    
            }
            */
            
            return redirect(get_admin_url('categories/' . $type))->with("success", $success);
        }
        else
        {
            return redirect(get_admin_url('/'));
        }
    }
    
    /**
     * categorys_actions
     */
    public function categorys_actions(Request $request)
    {
        if ($request->has('query') && $request->get('query') == 'action') {
            $marks = $request->get('mark');
            if ($request->get('action') == 'enable' and is_array($marks)) {
                foreach ($marks as $markid) {
                    //DB::table(TERMS_TABLE)->where(['id' => $markid])->update(['status' => '1']);
                }
                $success = admin_lang('msg_enable_selected');
            } elseif ($request->get('action') == 'disable' and is_array($marks)) {
                foreach ($marks as $markid) {
                    //DB::table(TERMS_TABLE)->where(['id' => $markid])->update(['status' => '0']);
                }
                $success = admin_lang('msg_disable_selected');
            } elseif ($request->get('action') == 'delete' and is_array($marks)) {
                foreach ($marks as $markid) {
                    //DB::table(TERMS_TABLE)->where(['id' => $markid])->delete();
                }
                $success = admin_lang('msg_delete_selected');
            } elseif ($request->get('action') == 'reorders' and is_array($marks)) {
                $idx    = $request->get('idx');
                $order  = $request->get('order');
                for ($i = 0; $i < count($idx); $i++) {
                    $theid      = $idx[$i];
                    $neworder   = $order[$i];
                    //DB::table(TERMS_TABLE)->where(['id' => $theid])->update(['orders' => $neworder]);
                }
                $success = admin_lang('msg_reorders_selected');
            } else {
                $success = admin_lang('msg_noselectaction');
            }
            return redirect()->back()->with("success", $success);
        }
    }
    
    /**
     * enable_category
     */
    public function enable_category($id)
    {
        //DB::table(TERMS_TABLE)->where(['id' => $id])->update(['status' => '1']);
        return redirect()->back()->with("success", admin_lang('msg_cate_enable'));
    }
    
    /**
     * disable_category
     */
    public function disable_category($id)
    {
        //DB::table(TERMS_TABLE)->where(['id' => $id])->update(['status' => '0']);
        return redirect()->back()->with("success", admin_lang('msg_cate_disable'));
    }
    
    /**
     * delete_category
     */
    public function delete_category($id, $token)
    {
        //DB::table(TERMS_TABLE)->where(['id' => $id])->delete();
        return redirect()->back()->with("success", admin_lang('msg_cate_delete'));
    }
}