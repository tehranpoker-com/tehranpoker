<?php
/**
 * Project: Basma - Resume / CV CMS
 * @link http://themearabia.net
 * @copyright 2022
 * @author Hossam Hamed <themearabia@gmail.com> <0201094140448>
 * @version 1.0
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use ValidatesRequests;

    public function __construct()
    {
        if(!file_exists(storage_path()."/installed")){
            header('location:install');
            die;
        }
        set_site_config();
        $this->lood_theme();
    }

    /**
     * browser_detect
     */
    public function browser_detect(){
        $browser_detect = [
            'ip'                => GetRealIp(),
            'useragent'         => Browser::userAgent(),
            'platformname'      => Browser::platformName(),
            'browserfamily'     => Browser::browserFamily(),
        ];
        return $browser_detect;
    }

    /**
     * lood_theme
     */
    public function lood_theme()
    {
        include(theme_path('default/options.php'));
    }

    /**
     * get_posts_query
     */
    public function get_posts_query($post_type = 'noneposttype')
    {
        $posts = DB::table(POSTS_TABLE)
        ->leftJoin('postsmeta as thumbnails', function ($join) {$join->on('thumbnails.post_id', '=', 'posts.id')->where('thumbnails.meta_key', '=', 'thumbnails');})
        ->leftJoin('users', function ($join) {$join->on('users.id', '=', 'posts.post_author');})
        ->leftJoin('terms', function ($join) {$join->on('terms.id', '=', 'posts.term_id');})
        ->selectRaw(
            db_select_column_as('posts', 'post_title').
            db_select_column_as('posts', 'post_name').
            db_select_column_as('posts', 'post_excerpts').
            db_select_column_as('posts', 'post_content').
            db_select_column_as('posts', 'id', 'post_id').
            db_select_column_as('posts', 'post_author').
            db_select_column_as('posts', 'post_type').
            db_select_column_as('posts', 'term_id').
            db_select_column_as('posts', 'comment_status').
            db_select_column_as('posts', 'post_modified').
            db_select_column_as('posts', 'post_pin').
            db_select_column_as('posts', 'post_views').
            db_select_column_as('terms', 'slug').
            db_select_column_as('terms', 'name').
            db_select_column_as('users', 'username').
            db_select_column_as('thumbnails', 'meta_value', 'thumbnail', '')
        )
        ->where(['post_status' => '1', 'post_type' => $post_type]);

        return $posts;
    }

    /**
     * get_posts_query
     */
    public function get_portfolio_query($post_type = 'noneposttype')
    {
        $posts = DB::table(POSTS_TABLE)
        ->leftJoin('postsmeta as thumbnails', function ($join) {$join->on('thumbnails.post_id', '=', 'posts.id')->where('thumbnails.meta_key', '=', 'thumbnails');})
        ->leftJoin('postsmeta as portfolio_type', function ($join) {$join->on('portfolio_type.post_id', '=', 'posts.id')->where('portfolio_type.meta_key', '=', 'portfolio_type');})
        ->leftJoin('postsmeta as iframe_url', function ($join) {$join->on('iframe_url.post_id', '=', 'posts.id')->where('iframe_url.meta_key', '=', 'iframe_url');})
        ->leftJoin('postsmeta as video_url', function ($join) {$join->on('video_url.post_id', '=', 'posts.id')->where('video_url.meta_key', '=', 'video_url');})
        ->leftJoin('users', function ($join) {$join->on('users.id', '=', 'posts.post_author');})
        ->leftJoin('terms', function ($join) {$join->on('terms.id', '=', 'posts.term_id');})
        ->selectRaw(
            db_select_column_as('posts', 'post_title').
            db_select_column_as('posts', 'post_name').
            db_select_column_as('posts', 'post_excerpts').
            db_select_column_as('posts', 'post_content').
            db_select_column_as('posts', 'id', 'post_id').
            db_select_column_as('posts', 'post_author').
            db_select_column_as('posts', 'post_type').
            db_select_column_as('posts', 'term_id').
            db_select_column_as('posts', 'comment_status').
            db_select_column_as('posts', 'post_modified').
            db_select_column_as('posts', 'post_pin').
            db_select_column_as('posts', 'post_views').
            db_select_column_as('terms', 'slug').
            db_select_column_as('terms', 'name').
            db_select_column_as('users', 'username').
            db_select_column_as('portfolio_type', 'meta_value', 'portfolio_type').
            db_select_column_as('iframe_url', 'meta_value', 'iframe_url').
            db_select_column_as('video_url', 'meta_value', 'video_url').
            db_select_column_as('thumbnails', 'meta_value', 'thumbnail', '')
        )
        ->where(['post_status' => '1', 'post_type' => $post_type]);

        return $posts;
    }

    /**
     * get_terms_query
     */
    public function get_terms_query($type = 'noneposttype')
    {
        $terms = DB::table(TERMS_TABLE)->where(['status' => '1', 'type' => $type]);

        return $terms;
    }
}
