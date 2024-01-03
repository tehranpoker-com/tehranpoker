<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * config && options v1.0
 */
/**
 * set_site_config
 */
if(!function_exists('set_site_config')){
    function set_site_config(){
        $opstions = DB::table(OPTIONS_TABLE)->get();
        foreach($opstions as $option){
            if(is_serialized($option->option_value)){
                foreach(maybe_unserialize($option->option_value) as $key => $value){
                    config(['site.unserialize.'.$option->option_name.'.'.$key => $value]);
                }
            }
            config(['site.'.$option->option_name => $option->option_value]);
        }
    }
}

/**
 * site_config
 */
if(!function_exists('site_config')){
    function site_config($name, $default = false){
        $config = config('site.'.$name);
        return ($config)? $config : $default;
    }
}

/**
 * get_option
 */
if(!function_exists('get_option')){
    function get_option($name, $default = ''){
        $options = (site_config($name)) ? site_config($name) : $default;
        if(is_serialized($options)){
            return maybe_unserialize($options);
        }
        else {
            return $options;
        }
    }
}

/**
 * has_option
 */
if(!function_exists('has_option')){
    function has_option($name, $key = '', $default = ''){
        $option = get_option($name);
        if($key){
            if(is_array($option) && isset($option[$key])){
                return $option[$key];
            } 
            elseif(get_default_option($name, $key)){
                return get_default_option($name, $key);
            }
            else{
                return $default;
            }
        }
        else {
            if($option){
                return $option;
            }
            elseif(get_default_option($name)){
                return get_default_option($name);
            }
            else {
                return $default;
            }
        }
    }
}

/**
 * get_default_option
 */
if(!function_exists('get_default_option')){
    function get_default_option($name, $key = ''){
        $option = default_options($name);
        if($key){
            return (isset($option[$key]))? $option[$key] : '';
        }
        else {
            return (isset($option))? $option : '';
        }
    }
}

/**
 * get_theme_option
 */
if(!function_exists('get_theme_option')){
    function get_theme_option($name, $default = ''){
        $theme_option = maybe_unserialize(site_config('theme_options_default'));
        if(is_array($theme_option) and isset($theme_option[$name]))
        {
            return $theme_option[$name];
        }
        else {
            return $default;
        }
    }
}

/**
 * get_option_img
 */
if(!function_exists('get_option_img')){
    function get_option_img($name, $default = false, $path = 'uploads/options/'){
        return (site_config($name)) ? url($path . site_config($name))  : $default;
    }
}

/**
 * update_option
 */
if(!function_exists('update_option')){
    function update_option($name, $value = ''){
        $is_has = DB::table(OPTIONS_TABLE)->where([['option_name', '=', $name]])->exists();
        if ($is_has) {
            DB::table(OPTIONS_TABLE)->where(['option_name' => $name])->update(['option_value' => $value]);
        } else {
            DB::table(OPTIONS_TABLE)->insert(['option_name' => $name, 'option_value' => $value]);
        }
    }
}

/**
 * get_options_autoload
 */
if(!function_exists('get_options_autoload')){
    function get_options_autoload($act = ''){
        
        /*
        $opstions = DB::table(OPTIONS_TABLE)->get();
        if($opstions->count()){
            foreach($opstions as $option){
                $setting[$option->option_name] = (is_serialized($option->option_value))? maybe_unserialize($option->option_value) : $option->option_value;
            }
        }
        */

        $admin_language = get_option('admin_language', 'en');
        $setting['admin_dir'] = ($admin_language == 'ar')? 'rtl' : 'ltr';
        $setting['admin_lang'] = $admin_language;
        $setting['site_dir'] = get_option('direction', 'ltr');
        $setting['site_lang'] = get_option('language', 'en');

        return $setting;
    }
}

/**
 * get_options_autoload
 */
if(!function_exists('get_default_image')){
    function get_default_image($image, $default){
        return ($image)? $image : $default;
    }
}

/**
 * view v1.0
 */

/**
 * get_view
 */
if(!function_exists('get_view')){
    function get_view($blade, $data = array()){
        $theme              = 'default';
        $data['get_view']   = ['blade' => $blade, 'theme' => $theme];
        $data               = mega_parse_args(get_options_autoload(), $data);
        $data               = Eventy::filter('get_options_autoload', $data);
        $data               = Eventy::filter('filter_data_get_view', $data);
        $view               = 'frontend.' . $theme . '.' . $blade;
        return view($view, $data);
    }
}

/**
 * get_extends
 */
if(!function_exists('get_extends')){
    function get_extends($blade){
        $theme = 'default';
        $extend = 'frontend.' . $theme . '.' . $blade;
        return $extend;
    }
}

/**
 * get_each
 */
if(!function_exists('get_each')){
    function get_each($blade){
        $theme = get_option('theme', 'default');
        $extend = 'frontend.' . $theme . '.' . $blade;
        return $extend;
    }
}

/**
 * get_asset
 */
if(!function_exists('get_asset')){
    function get_asset($file){
        $theme = 'default';
        return asset('frontend/' . $theme . '/assets/' . $file);
    }
}

/**
 * admin v1.0
 */
/**
 * get_admin_view
 */
if(!function_exists('get_admin_view')){
    function get_admin_view($blade, $data = array()){
        $data = mega_parse_args(get_options_autoload('admin'), $data);
        $view = 'dashboard.' . $blade;
        return view($view, $data);
    }
}

/**
 * get_admin_route
 */
if(!function_exists('get_admin_route')){
    function get_admin_route($route = false){
        $admindir = env('APP_ADMIN_FOLDER', 'admincp');
        if ($route) {
            return $admindir . '/' . $route;
        } else {
            return $admindir;
        }
    }
}

/**
 * get_admin_url
 */
if(!function_exists('get_admin_url')){
    function get_admin_url($url = false){
        $admindir = env('APP_ADMIN_FOLDER', 'admincp');
        if ($url) {
            return url($admindir . '/' . $url);
        } else {
            return $admindir;
        }
    }
}

/**
 * get_admin_language
 */
if(!function_exists('get_admin_language')){
    function get_admin_language($type = 'lang'){
        $admin_language = get_option('admin_language', 'en');
        $admin_dir  = ($admin_language == 'ar')? 'rtl' : 'ltr';
        $admin_lang = $admin_language;
        
        return ($type == 'dir')? $admin_dir : $admin_lang;
    }
}

/**
 * serialize v1.0
 */

/**
 * maybe_unserialize
 */
if(!function_exists('maybe_unserialize')){
    function maybe_unserialize($original, $default = [] ){
        if ($original and is_serialized($original)){
            return @unserialize($original);
        } else{
            return ($default)? $default : $original;
        }
    }
}

/**
 * is_serialized
 */
if(!function_exists('is_serialized')){
    function is_serialized($data, $strict = true){
        if (!is_string($data)) {return false;}
        $data = trim($data);
        if ('N;' == $data) {return true;}
        if (strlen($data) < 4) {return false;}
        if (':' !== $data[1]) {return false;}
        if ($strict) {
            $lastc = substr($data, -1);
            if (';' !== $lastc && '}' !== $lastc) {return false;}
        } else {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');
            if (false === $semicolon && false === $brace) {return false;}
            if (false !== $semicolon && $semicolon < 3) {return false;}
            if (false !== $brace && $brace < 4) {return false;}
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ($strict) {if ('"' !== substr($data, -2, 1)) {return false;}}
                elseif (false === strpos($data, '"')) {return false;}
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }
        return false;
    }
}

/**
 * is_serialized_string
 */
if(!function_exists('is_serialized_string')){
    function is_serialized_string($data){
        if (!is_string($data)) {return false;}
        $data = trim($data);
        if (strlen($data) < 4) {return false;} 
        elseif (':' !== $data[1]) {return false;} 
        elseif (';' !== substr($data, -1)) {return false;}
        elseif ($data[0] !== 's') {return false;}
        elseif ('"' !== substr($data, -2, 1)) {return false;}
        else {return true;}
    }
}

/**
 * maybe_serialize
 */
if(!function_exists('maybe_serialize')){
    function maybe_serialize($data){
        if (is_array($data) || is_object($data)) {return serialize($data);}
        if (is_serialized($data, false)){return serialize($data);}
        return $data;
    }
}

/**
 * languages v1.0
 */

/**
 * lang
 */
if(!function_exists('lang')){
    function lang($string, $replace = [], $file = 'global', $locale = null){
        $locale = ($locale == null)? get_option('language') : $locale;
        $text = trans($file . '.' . $string, $replace, $locale);
        return $text;
    }
}

/**
 * admin_lang
 */
if(!function_exists('admin_lang')){
    function admin_lang($string, $replace = [], $file = 'global', $locale = false){
        $locale = ($locale)? $locale : get_admin_language();
        $text = trans($file . '.' . $string, $replace, $locale);
        return $text;
    }
}

/**
 * users v1.0
 */

/**
 * has_user_meta
 */
if(!function_exists('has_user_meta')){
    function has_user_meta($key, $id){
        $is_has = DB::table(USERSMETA_TABLE)->where(['user_id' => $id, 'meta_key' => $key])->exists();
        return $is_has;
    }
}

/**
 * get_user_meta
 */
if(!function_exists('get_user_meta')){
    function get_user_meta($key, $id, $return = false){
        if(has_user_meta($key, $id)){
            $meta_value  = DB::table(USERSMETA_TABLE)->where(['user_id' => $id, 'meta_key' => $key])->value('meta_value');
            return $meta_value;
        } else {
            return $return;
        }
    }
}

/**
 * update_user_meta
 */
if(!function_exists('update_user_meta')){
    function update_user_meta($key, $value, $id){
        if(has_user_meta($key, $id)){
            DB::table(USERSMETA_TABLE)->where(['user_id' => $id, 'meta_key' => $key])->update(['meta_value' => $value]);
        } else {
            DB::table(USERSMETA_TABLE)->insert(['user_id' => $id, 'meta_key' => $key, 'meta_value' => $value]);
        }
    }
}

/**
 * get_user_avatar
 */
if(!function_exists('get_user_avatar')){
    function get_user_avatar($user_id, $size = '64'){
        return 'https://ui-avatars.com/api/?name='.urlencode(get_user_column($user_id, 'username')).'&color=7F9CF5&background=EBF4FF&size='.$size;
    }
}

/**
 * get_username
 */
if(!function_exists('get_username')){
    function get_username($user_id, $meta = false, $name_meta = array()){
        $name  = DB::table(USERS_TABLE)->where('id', $user_id)->value('username');
        if($meta && isset($name_meta[0])){
            $user_meta  = get_user_meta($meta, $user_id);
            return ($user_meta)? $user_meta . $name_meta[0] . $name . $name_meta[1] : $name;
        } elseif($meta) {
            $user_meta  = get_user_meta($meta, $user_id);
            return ($user_meta)? $user_meta : $name;
        } else {
            return $name;
        }
    }
}

/**
 * get_user_column
 */
if(!function_exists('get_user_column')){
    function get_user_column($id, $column){
        $column  = DB::table(USERS_TABLE)->where("id", $id)->value($column);
        return $column;
    }
}

/**
 * query_user_meta
 */
if(!function_exists('query_user_meta')){
    function query_user_meta($user_id){
        $query_meta = DB::table(USERSMETA_TABLE)->where('user_id', $user_id)->get();
        $meta = [];
        foreach($query_meta as $item){
            if(is_serialized($item->meta_value)){
                $meta[$item->meta_key] = maybe_unserialize($item->meta_value);
            }
            else{
                $meta[$item->meta_key] = $item->meta_value;
            }
        }
        return $meta;
    }
}

/**
 * get_user_cover
 */
if(!function_exists('get_user_cover')){
    function get_user_cover($user_id, $cover = 'usercover.jpg'){
        return asset('images/'.$cover);
    }
}


/**
 * posts v1.0
 */

/**
 * has_post_meta
 */
if(!function_exists('has_post_meta')){
    function has_post_meta($key, $id){
        $is_has = DB::table(POSTSMETA_TABLE)->where(['meta_key' => $key, 'post_id' => $id])->exists();
        return $is_has;
    }
}

/**
 * get_post_meta
 */
if(!function_exists('get_post_meta')){
    function get_post_meta($key, $id, $return = false){
        if (has_post_meta($key, $id)) {
            $meta_value  = DB::table(POSTSMETA_TABLE)->where(['meta_key' => $key, 'post_id' => $id])->value('meta_value');
            return $meta_value;
        } else {
            return $return;
        }
    }
}

/**
 * unserialize_post_meta
 */
if(!function_exists('unserialize_post_meta')){
    function unserialize_post_meta($key, $id, $return = false){
        if (has_post_meta($key, $id)) {
            $meta_value  = DB::table(POSTSMETA_TABLE)->where(['meta_key' => $key, 'post_id' => $id])->value('meta_value');
            return maybe_unserialize($meta_value);
        } else {
            return [];
        }
    }
}

/**
 * update_post_meta
 */
if(!function_exists('update_post_meta')){
    function update_post_meta($key, $value, $id){
        if (has_post_meta($key, $id)) {
            DB::table(POSTSMETA_TABLE)->where(['post_id' => $id,'meta_key' => $key])->update(['meta_value' => $value]);
        } else {
            DB::table(POSTSMETA_TABLE)->insert(['post_id' => $id,'meta_key' => $key,'meta_value' => $value]);
        }
    }
}

/**
 * get_post_count
 */
if(!function_exists('get_post_count')){
    function get_post_count($type, $term_id = ''){
        if ($term_id) {
            $count = DB::table(POSTS_TABLE)->where([['term_id', '=', $term_id], ['post_type', '=', $type]])->count();
        } else {
            $count = DB::table(POSTS_TABLE)->where([['post_type', '=', $type]])->count();
        }
        return $count;
    }
}

/**
 * get_post_count_status
 */
if(!function_exists('get_post_count_status')){
    function get_post_count_status($type, $term_id = '', $status = 1){
        if ($term_id) {
            $count = DB::table(POSTS_TABLE)->where([['term_id', '=', $term_id], ['post_type', '=', $type], ['post_status', '=', $status]])->count();
        } else {
            $count = DB::table(POSTS_TABLE)->where([['post_type', '=', $type], ['post_status', '=', $status]])->count();
        }
        return $count;
    }
}

/**
 * get_posts_type
 */
if(!function_exists('get_posts_type')){
    function get_posts_type($type, $term_id = false, $status = false){
        if ($term_id) {
            $where[] =  ['term_id', '=', $term_id];
        }

        if ($status) {
            $where[] =  ['post_status', '=', $status];
        }

        $where[] =  ['post_type', '=', $type];

        $posts = DB::table(POSTS_TABLE)->where($where)->get();

        return $posts;
    }
}

/**
 * get_posts
 */
if(!function_exists('get_posts')){
    function get_posts($args){
        if ($args['cid']) {
            $where[] =  ['term_id', '=', $args['cid']];
        }
        
        $status     = (isset($args['status']))? $args['status'] : 1;
        $where[]    =  ['post_status', '=', $status];
        $where[]    =  ['post_type', '=', $args['type']];
        $limit      = (isset($args['limit']))? $args['limit'] : 10;
        $posts      = DB::table(POSTS_TABLE)->where($where)->limit($limit)->get();
        return $posts;
    }
}

/**
 * get_post_title
 */
if(!function_exists('get_post_title')){
    function get_post_title($id){
        $title  = DB::table(POSTS_TABLE)->where('id', $id)->value('post_title');
        return $title;
    }
}

/**
 * get_post_name
 */
if(!function_exists('get_post_name')){
    function get_post_name($id){
        $post_name  = DB::table(POSTS_TABLE)->where('id', $id)->value('post_name');
        return $post_name;
    }
}

/**
 * get_post_column
 */
if(!function_exists('get_post_column')){
    function get_post_column($id, $column = 'post_title'){
        return DB::table(POSTS_TABLE)->where('id', $id)->value($column);
    }
}

/**
 * get_default_postmeta
 */
if(!function_exists('get_default_postmeta')){
    function get_default_postmeta($post_type){
        $default = [
            'meta_author'       => '0',
            'meta_date'         => '0',
            'meta_comments'     => '0',
            'meta_views'        => '0',
            'meta_shareit'      => '0',
            'views'             => '0',
            'details'           => [],
        ];
        $postmeta = Eventy::filter('admin_filter_default_postmeta_'.$post_type, $default);

        return $postmeta;
    }
}

/**
 * query_posts_meta
 */
if(!function_exists('query_posts_meta')){
    function query_posts_meta($post_id){
        $query_meta = DB::table(POSTSMETA_TABLE)->where('post_id', $post_id)->get();
        $meta = get_default_postmeta(get_post_column($post_id, 'post_type'));
        foreach($query_meta as $item){
            if(is_serialized($item->meta_value)){
                $meta[$item->meta_key] = maybe_unserialize($item->meta_value);
            }
            else{
                $meta[$item->meta_key] = $item->meta_value;
            }
        }
        return $meta;
    }
}

/**
 * query_posts_meta
 */
if(!function_exists('get_posts_count')){
    function get_posts_count($type, $plus = 0){
        $count = DB::table(POSTS_TABLE)->where('post_type', $type)->count();
        return $count + $plus;
    }
}

/**
 * get_postid_by_postname
 */
if(!function_exists('get_postid_by_postname')){
    function get_postid_by_postname($post_name, $post_type){
        $postid = DB::table(POSTS_TABLE)->where(['post_type' => $post_type, 'post_name' => $post_name])->value('id');
        return $postid;
    }
}

/**
 * terms v1.0
 */

/**
 * get_categories_type
 */
if(!function_exists('get_categories_type')){
    function get_categories_type($type){
        $categories = DB::table(TERMS_TABLE)->where('type', $type)->get();
        return $categories;
    }
}

/**
 * get_term_by_slug
 */
if(!function_exists('get_term_by_slug')){
    function get_term_by_slug($slug, $type){
        $term = DB::table(TERMS_TABLE)->where(['status' => '1', 'type' => $type, 'slug' => $slug])->get();
        return $term;
    }
}

/**
 * get_term_column
 */
if(!function_exists('get_term_column')){
    function get_term_column($id, $column = 'name')
    {
        return DB::table(TERMS_TABLE)->where('id', $id)->value($column);
    }
}

/**
 * get_term_name
 */
if(!function_exists('get_term_name')){
    function get_term_name($id){
        $name  = DB::table(TERMS_TABLE)->where('id', $id)->value('name');
        return ($name)? $name : '';
    }
}

/**
 * get_term_slug
 */
if(!function_exists('get_term_slug')){
    function get_term_slug($id){
        $slug  = DB::table(TERMS_TABLE)->where('id', $id)->value('slug');
        return $slug;
    }
}

/**
 * get_term_count
 */
if(!function_exists('get_term_count')){
    function get_term_count($type, $plus = 0){
        $count = DB::table(TERMS_TABLE)->where('type', $type)->count();
        return $count + $plus;
    }
}

/**
 * get_term_parent_count
 */
if(!function_exists('get_term_parent_count')){
    function get_term_parent_count($parent, $type){
        $count = DB::table(TERMS_TABLE)->where(['type' => $type, 'parent' => $parent])->count();
        return $count;
    }
}

/**
 * has_term_meta
 */
if(!function_exists('has_term_meta')){
    function has_term_meta($key, $id){
        $is_has = DB::table(TERMSMETA_TABLE)->where(['meta_key' => $key, 'term_id' => $id])->exists();
        return $is_has;
    }
}

/**
 * get_term_meta
 */
if(!function_exists('get_term_meta')){
    function get_term_meta($key, $id, $return = false){
        if (has_term_meta($key, $id)) {
            $meta_value  = DB::table(TERMSMETA_TABLE)->where(['meta_key' => $key, 'term_id' => $id])->value('meta_value');
            return $meta_value;
        } else {
            return $return;
        }
    }
}

/**
 * update_term_meta
 */
if(!function_exists('update_term_meta')){
    function update_term_meta($key, $value, $id){
        if (has_term_meta($key, $id)) {
            DB::table(TERMSMETA_TABLE)->where(['term_id' => $id,'meta_key' => $key])->update(['meta_value' => $value]);
        } else {
            DB::table(TERMSMETA_TABLE)->insert(['term_id' => $id,'meta_key' => $key,'meta_value' => $value]);
        }
    }
}


/**
 * other
 */

/**
 * theme_path
 */
if(!function_exists('theme_path')){
    function theme_path($path = ''){
        return resource_path('views/frontend/'.$path);
    }
}

/**
 * theme_url
 */
if(!function_exists('theme_url')){
    function theme_url($file = ''){
        return url(env('APP_ROOT_PAHT').'/resources/views/frontend/'.$file);
    }
}

/**
 * is_admin
 */
if(!function_exists('is_admin')){
    function is_admin(){
        $admindir = env('APP_ADMIN_FOLDER', 'admincp');
        if(Request()->route()->getPrefix() == '/'.$admindir){
            return true;
        }
        else {
            return false;
        }
    }
}

/**
 * is_user_admin
 */
if(!function_exists('is_user_admin')){
    function is_user_admin(){
        if(Auth::check() and in_array(auth()->user()->userlevel, ['admin'])){
            return true;
        }
        else {
            return false;
        }
    }
}

/**
 * GetRealIp
 */
if(!function_exists('GetRealIp')){    
    function GetRealIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
    }
}

/**
 * mega_parse_args
 */
if(!function_exists('mega_parse_args')){
    function mega_parse_args($args, $defaults = array()){
        if (is_object($args)) {
            $parsed_args = get_object_vars( $args );
        } elseif ( is_array( $args ) ) {
            $parsed_args =& $args;
        } else {
            $parsed_args = [];
        }
    
        if ( is_array( $defaults ) && $defaults ) {
            return array_merge( $defaults, $parsed_args );
        }
        return $parsed_args;
    }
}

/**
 * get_media_count
 */
if(!function_exists('get_media_count')){
    function get_media_count(){
        $count = DB::table(ATTACHMENTS_TABLE)->count();
        return $count;
    }
}

/**
 * setting_input_radio
 */
if(!function_exists('setting_input_radio')){
    function setting_input_radio($inputs = array(), $name, $value, $type = ''){
        $html = '<div class="megapanel-buttons-options">';
        if (is_array($inputs)) {
            if ($type != '') {
                $onoff = ['option-off', 'option-on'];
            }
            foreach ($inputs as $key => $input) {
                $active = ($key == $value) ? 'active' : '';
                $class  = ($type != '') ? $onoff[$key] : 'option-on';
                $html .= '<button type="button" data-value="' . $key . '" class="' . $class . ' ' . $active . '">' . $input . '</button>';
            }
        }
        $html .= '<input type="hidden" name="' . $name . '" value="' . $value . '"></div>';
        return $html;
    }
}

/**
 * setting_input_radio_multiple
 */
if(!function_exists('setting_input_radio_multiple')){
    function setting_input_radio_multiple($inputs = array(), $name, $value, $offkey = ''){
        $html = '<div class="megapanel-buttons-options">';
        if (is_array($inputs)) {
            foreach ($inputs as $key => $input) {
                $active = ($key == $value) ? 'active' : '';
                $class  = ($key == $offkey) ? 'option-off' : 'option-on';
                $html .= '<button type="button" data-value="' . $key . '" class="' . $class . ' ' . $active . '">' . $input . '</button>';
            }
        }
        $html .= '<input type="hidden" name="' . $name . '" value="' . $value . '"></div>';
        return $html;
    }
}

/**
 * setting_input_radio_multiple_img
 */
if(!function_exists('setting_input_radio_multiple_img')){
    function setting_input_radio_multiple_img($inputs = array(), $name, $value, $offkey = ''){
       

        $html = '<div class="megapanel-buttons-options">';
        if (is_array($inputs)) {
            foreach ($inputs as $key => $image) {
                $labelafter = '<div class="option-boximg"><img src="'.$image.'" /></div>';
                $active = ($key == $value) ? 'active' : '';
                $class  = ($key == $offkey) ? 'option-off' : 'option-on';
                $html .= '<button type="button" data-value="' . $key . '" class="' . $class . ' boximg ' . $active . '">' . $labelafter . '</button>';
            }
        }
        $html .= '<input type="hidden" name="' . $name . '" value="' . $value . '"></div>';
        return $html;



    }
}

/**
 * selected
 */
if(!function_exists('selected')){
    function selected($checked, $current, $echo = true){
        if ($checked == $current) {
            $result = 'selected=""';
        } else {
            $result = '';
        }
        if ($echo) {
            echo $result;
        }
        return $result;
    }
}

/**
 * get_select_delete_options
 */
if(!function_exists('get_select_delete_options')){
    function get_select_delete_options(){
        $html = '<div class="actionselect"><select name="action" class="custom-select form-select custom-select-sm form-control form-control-sm width-120"><option value="-1">'.admin_lang('bulk_actions').'</option><option value="delete">'.admin_lang('delete').'</option></select>&nbsp;<input type="submit" class="btn btn-sm btn-primary" value="' . admin_lang('apply') . '" onclick="return confirm(\\\'' . admin_lang('apply_confirm') . '\\\');" /></div>';
        return $html;
    }
}

/**
 * get_select_actions_options
 */
if(!function_exists('get_select_actions_options')){
    function get_select_actions_options($order = false){
        $html = '<div class="actionselect"><select name="action" class="custom-select form-select custom-select-sm form-control form-control-sm width-120"><option value="-1">' . admin_lang('bulk_actions') . '</option>';
        if ($order) {
            $html .= '<option value="reorders">' . admin_lang('reorders') . '</option>';
        }
        $html .= '<option value="enable">' . admin_lang('enable') . '</option><option value="disable">' . admin_lang('disable') . '</option><option value="delete">' . admin_lang('delete') . '</option></select>&nbsp;<input type="submit" class="btn btn-sm btn-primary" value="' . admin_lang('apply') . '" onclick="return confirm(\\\'' . admin_lang('apply_confirm') . '\\\');" /></div>';
        return $html;
    }
}

/**
 * time_ago
 */
if(!function_exists('time_ago')){
    function time_ago($datetime, $full = false, $lang = false){
        $now = new DateTime;
        $ago = (is_numeric($datetime))? new DateTime(date('Y-m-d H:i:s', $datetime)) :  new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => ($lang)? admin_lang('year') : lang('year'),
            'm' => ($lang)? admin_lang('month') : lang('month'),
            'w' => ($lang)? admin_lang('week') : lang('week'),
            'd' => ($lang)? admin_lang('day') : lang('day'),
            'h' => ($lang)? admin_lang('hour') : lang('hour'),
            'i' => ($lang)? admin_lang('minute') : lang('minute'),
            's' => ($lang)? admin_lang('second') : lang('second'),
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                if(get_option('language', 'en') == 'en') {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                }
                else {
                    $v = $diff->$k . ' ' . $v ;
                }
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        if($lang) {
            if(get_option('language', 'en') == 'en') {
                return $string ? implode(', ', $string) . ' ' . admin_lang('ago') : admin_lang('justnow');
            }
            else {
                return $string ? admin_lang('ago') .' '. implode(', ', $string): admin_lang('justnow');
            }   
        }
        else {
            if(get_option('language', 'en') == 'en') {
                return $string ? implode(', ', $string) . ' ' . lang('ago') : lang('justnow');
            }
            else {
                return $string ? lang('ago') .' '. implode(', ', $string): lang('justnow');
            } 
        }
    }
}

/**
 * get_date_from_to
 */
if(!function_exists('get_date_from_to')){
    function get_date_from_to($id)
    {
        $date_format_from = '';
        $date_format_to = '';
        $date_from  = get_post_meta('date_from', $id);
        $date_to    = get_post_meta('date_to', $id);
        $icurrently = get_post_meta('icurrently', $id);
        if($date_from){
            $date_format_from = time_format($date_from, 'date', 'M Y') . ' - ';
        }
        if($date_to and !$icurrently){
            $date_format_to = time_format($date_to, 'date', 'M Y');
        }
        elseif($icurrently) {
            $date_format_to = lang('currently');
        }
        return $date_format_from.$date_format_to;
    }
}

/**
 * format_size
 */
if(!function_exists('format_size')){
    function format_size($filesize){
        $size = '--';
        switch ($filesize){
            case $filesize < 1024:
                $size = $filesize .' B';
            break;
            case $filesize < 1048576:
                $size = round($filesize / 1024, 2) .' KB';
            break;
            case $filesize < 1073741824:
                $size = round($filesize / 1048576, 2) . ' MB';
            break;
            case $filesize < 1099511627776:
                $size = round($filesize / 1073741824, 2) . ' GB';
            break;
        }
        return $size;
    }
}

/**
 * get_attachment_url
 */
if(!function_exists('get_attachment_url')){
    function get_attachment_url($id, $size = 'thumbnail'){
        $attachment_file = DB::table(ATTACHMENTS_TABLE)->where('at_id', $id)->value('at_files');
        $file = maybe_unserialize($attachment_file);
        if(isset($file[$size]) and $file)
        {
            return url($file[$size]);
        }
        elseif(isset($file['file']) and $file)
        {
            return url($file['file']);
        }
        else
        {
            return false;
        }
    }
}

/**
 * get_attachment_data_url
 */
if(!function_exists('get_attachment_data_url')){
    function get_attachment_data_url($attachment, $size = 'thumbnail'){
        $file = maybe_unserialize($attachment);
        if(isset($file[$size]) and $file){
            return url($file[$size]);
        }
        elseif(isset($file['file']) and $file){
            return url($file['file']);
        }
        else{
            return false;
        }
    }
}

/**
 * get_media_mimes_thumbnail
 */
if(!function_exists('get_media_mimes_thumbnail')){
    function get_media_mimes_thumbnail($attachment, $type, $size = 'thumbnail'){
        if($attachment or in_array($type, ['svg', 'webp', 'bmp'])){
            $src = get_attachment_data_url($attachment, $size);
        }
        else {
            if(file_exists(public_path("public/libs/filetypes/{$type}.svg"))){
                $src = asset("libs/filetypes/{$type}.svg");
            } else {
                $src = asset("libs/filetypes/search.svg");
            }
        }
        return $src;
    }
}

/**
 * preg_slug
 */
if(!function_exists('preg_slug')){
    function preg_slug($title, $table = 'post', $type = 'posts', $id = 0){
        $slug       = Str::slug($title, '-');
        $z          = 0;
        $i          = 1;
        $atr_slug   = '';
        while ($z <= 0) {
            $slug_name = $slug . $atr_slug;
            if($table == 'post'){
                $is_slug  = DB::table(POSTS_TABLE)->where([['post_name', '=', $slug_name], ['post_type', '=', $type], ['id', '!=', $id]])->count();
            }
            elseif($table == 'categories'){
                $is_slug  = DB::table(TERMS_TABLE)->where([['slug', '=', $slug_name], ['type', '=', $type], ['id', '!=', $id]])->count();
            }

            if(!$is_slug){
                $z = 1;
                continue;
            }
            else{
                $atr_slug = '-'.$i++;
            }
            continue;
        }

        return $slug_name;
    }
}

/**
 * sanitize_text
 */
if(!function_exists('sanitize_text')){
    function sanitize_text($string){
        $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
        return $string;
    }
}

/**
 * unsanitize_text
 */
if(!function_exists('unsanitize_text')){
    function unsanitize_text($string){
        $string = str_replace(array("'", "'", '"', '"'), array('‘', '’', '“', '”'), $string);
        return $string;
    }
}

/**
 * safe_input
 */
if(!function_exists('safe_input')){
    function safe_input($string, $br = true){
        $string = trim($string);
        $string = unsanitize_text($string);
        $string = strip_tags($string);
        $string = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        if($br){
            $string = str_replace("\r\n", "\n", $string);
            $string = str_replace("\n", '<br />', $string);
        }
        
        return $string;
    }
}

/**
 * safe_textarea
 */
if(!function_exists('safe_textarea')){
    function safe_textarea($string){
        $string = unsanitize_text($string);
        $string = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = str_replace(array("&lt;pre&gt;", "&lt;/pre&gt;"), array("<pre>", "</pre>"), $string);
        $string = str_replace("\r\n", "\n", $string);
        $string = str_replace("\n", '<br />', $string);
        $string = trim($string);
        return $string;
    }
}

/**
 * get_messages_count
 */
if(!function_exists('get_messages_count')){
    function get_messages_count($type){
        $count   = DB::table(POSTS_TABLE)->where([['post_type', '=', $type], ['post_status', '=', '0']])->count();
        return $count;
    }
}

/**
 * get_messages_html
 */
if(!function_exists('get_messages_html')){
    function get_messages_html($type1, $type2 = ''){
        $count_unraed1   = DB::table(POSTS_TABLE)->where([['post_type', '=', $type1], ['post_status', '=', '0']])->count();
        if($type2)
        {
            $count_unraed2   = DB::table(POSTS_TABLE)->where([['post_type', '=', $type2], ['post_status', '=', '0']])->count();
            $count = $count_unraed1 + $count_unraed2;
        }
        else
        {
            $count = $count_unraed1;
        }


        return ($count)? '<span class="badge rounded-pill bg-danger float-end">'.$count.'</span>' : '';
    }
}

/**
 * file_upload_max_size
 */
if(!function_exists('file_upload_max_size')){
    function file_upload_max_size(){
        static $max_size = -1;
        if ($max_size < 0) {
            $post_max_size = parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }
            $upload_max = parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }
}

/**
 * parse_size
 */
if(!function_exists('parse_size')){
    function parse_size($size){
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
}

/**
 * utf8_uri_encode
 */
if(!function_exists('utf8_uri_encode')){
    function utf8_uri_encode($utf8_string, $length = 0){
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;
        $string_length = strlen($utf8_string);
        for ($i = 0; $i < $string_length; $i++) {
            $value = ord($utf8_string[$i]);
            if ($value < 128) {
                if ($length && ($unicode_length >= $length))
                    break;
                $unicode .= chr($value);
                $unicode_length++;
            } else {
                if (count($values) == 0) {
                    if ($value < 224) {
                        $num_octets = 2;
                    } elseif ($value < 240) {
                        $num_octets = 3;
                    } else {
                        $num_octets = 4;
                    }
                }
                $values[] = $value;
                if ($length && ($unicode_length + ($num_octets * 3)) > $length)
                    break;
                if (count($values) == $num_octets) {
                    for ($j = 0; $j < $num_octets; $j++) {
                        $unicode .= '%' . dechex($values[$j]);
                    }
                    $unicode_length += $num_octets * 3;
                    $values = array();
                    $num_octets = 1;
                }
            }
        }
        return $unicode;
    }
}

/**
 * time_format
 */
if(!function_exists('time_format')){
    function time_format($time, $type = 'full', $formatdate = false, $formattime = false){
        if(!is_numeric($time)){
            $time = strtotime($time);
        }

        $formatdate = ($formatdate)? $formatdate : get_option('date_format', 'F j, Y');
        $formattime = ($formattime)? $formattime : get_option('time_format', 'g:i a');

        if(!is_numeric($time)) {
            $time = strtotime($time);
        }
        if ($type == 'time') {
            $time_format = date($formattime, $time);
        } elseif ($type == 'date') {
            $time_format = date($formatdate, $time);
        } else {
            $time_format = date($formatdate . ' ' . $formattime, $time);
        }

        if(get_option('language') == 'ar'){
            return get_arabic_date($time_format);
        }
        else {
            return $time_format;
        }

    }
}

/**
 * get_arabic_date
 */
if(!function_exists('get_arabic_date')){
    function get_arabic_date($date){
        $en_data = [
            'January', 'Jan', 'Feburary', 'Feb', 'March', 'Mar',
            'April', 'Apr', 'May', 'June', 'Jun',
            'July', 'Jul', 'August', 'Aug', 'September', 'Sep',
            'October', 'Oct', 'November', 'Nov', 'December', 'Dec',
            'Satureday', 'Sat', 'Sunday', 'Sun', 'Monday', 'Mon',
            'Tuesday', 'Tue', 'Wednesday', 'Wed', 'Thursday', 'Thu', 'Friday', 'Fri',
            'AM', 'am', 'PM', 'pm'
        ];

        $ar_data = [
            'يناير', 'يناير', 'فبراير', 'فبراير', 'مارس', 'مارس',
            'أبريل', 'أبريل', 'مايو', 'مايو', 'يونيو', 'يونيو',
            'يوليو', 'يوليو', 'أغسطس', 'أغسطس', 'سبتمبر', 'سبتمبر',
            'أكتوبر', 'أكتوبر', 'نوفمبر', 'نوفمبر', 'ديسمبر', 'ديسمبر',
            'السبت', 'السبت', 'الأحد', 'الأحد', 'الإثنين', 'الإثنين',
            'الثلاثاء', 'الثلاثاء', 'الأربعاء', 'الأربعاء', 'الخميس', 'الخميس', 'الجمعة', 'الجمعة',
            'صباحاً', 'صباحاً', 'مساءً', 'مساءً'
        ];

        return str_replace($en_data, $ar_data, $date);
    }
}

/**
 * get_pricing_featured
 */
if(!function_exists('get_pricing_featured')){
    function get_pricing_featured($featured){
        $featured = explode("\n", $featured);
        if(is_array($featured)){
            return $featured;
        }
        else {
            return [];
        }
    }
}

/**
 * get_posts_skills
 */
if(!function_exists('get_posts_skills')){
    function get_posts_skills($term_id){
        $posts = DB::table(POSTS_TABLE)->where([
            ['post_type', '=', 'skills'], 
            ['term_id', '=', $term_id], 
            ['post_status', '=', '1']
        ])->orderBy('post_orders', 'ASC')->get();
        
        if ($posts->count()) {
            return $posts;
        } else {
            return [];
        }
    }
}

/**
 * get_name_section
 */
if(!function_exists('get_name_section')){
    function get_name_section($widget){
        $section = explode(':', $widget);
        if(is_array($section) and isset($section[0])){
            return $section[0];
        }
        else {
            return $widget;
        }
    }
}

/**
 * get_class_section
 */
if(!function_exists('get_class_section')){
    function get_class_section($widget, $url = false){
        $section = explode(':', $widget);

        if($url){
            if(is_array($section) and isset($section[0]) and isset($section[1]) and $section[0] == 'page'){
                return url('page/'.get_post_name($section[1]));
            }
            else {
                if($widget == 'home'){
                    return url('/');
                }
                elseif($widget == 'blog'){
                    return url('articles');
                }
                else{
                    return url($widget);
                }
            }
        }
        else{
            if(is_array($section) and isset($section[0])){
                if(isset($section[1])){
                    return $section[0].'-'.$section[1];
                }
                else{
                    return $section[0];
                }
            }
            else {
                return $widget;
            }
        }

        
    }
}

/**
 * get_pageid_section
 */
if(!function_exists('get_pageid_section')){
    function get_pageid_section($widget){
        $section = explode(':', $widget);
        if(is_array($section) and isset($section[1])){
            return $section[1];
        }
        else {
            return 0;
        }
    }
}


/**
 * db_select_column_as
 */
if(!function_exists('db_select_column_as')){
    function db_select_column_as($table, $column, $as_column = false, $end = ', '){
        $db_prefix = env('DB_PREFIX');
        $new_column = ($as_column)? " AS {$as_column}" : '';
        return "{$db_prefix}{$table}.{$column}{$new_column}{$end}";
    }
}

/**
 * db_select_column_as_count
 */
if(!function_exists('db_select_column_as_count')){
    function db_select_column_as_count($table, $column, $as_column = false, $end = ', '){
        $db_prefix = env('DB_PREFIX');
        $new_column = ($as_column)? " AS {$as_column}" : '';
        return "count({$db_prefix}{$table}.{$column}) {$new_column}{$end}";
    }
}

/**
 * save_phrases
 */
if(!function_exists('save_phrases')){
    function save_phrases($phrases, $code){
        ksort($phrases);
        $substr_array = [];
        $new_phrases = "<?php\n\nreturn [\n";
        foreach($phrases as $key => $val){
            $substr = substr($key, 0, 1);
            if(!in_array($substr, $substr_array)){
                $substr_array[] = $substr;
                $new_phrases .= "\n\t/**\n\t* ".ucfirst($substr)."\n\t*/\n";
            }
            $val = str_replace("'", "\'", $val);
            $new_phrases .= "\t'{$key}' => '{$val}',\n";
        }
        $new_phrases .= "];\n";
        file_put_contents(resource_path('lang/'.$code.'/global.php'), $new_phrases, LOCK_EX);
    }
}