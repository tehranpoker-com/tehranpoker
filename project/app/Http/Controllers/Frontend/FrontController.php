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
use hisorange\BrowserDetect\Parser as Browser;
use Mail;
use Validator;

class FrontController extends Controller
{

    public $send_username = '';
    public $send_email = '';
    public $options = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index_home
    */
    public function index_home(Request $request)
    {
        $data['page_title'] = lang('home');
        $data['page_class'] = 'home';

        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])){
            
            /**
             * date portfolio
             */
            $data['portfolio'] = $this->get_data_portfolio();

            /**
             * date blog
             */
            $data['blog'] = $this->get_data_blog();

            /**
             * date aboutme
             */
            $data = mega_parse_args($data, $this->get_data_aboutme());
            
            /**
             * date resume
             */
            $data = mega_parse_args($data, $this->get_data_resume());

            /**
             * pricings
             */
            $data['pricings'] = $this->get_data_pricings();
  

            /**
             * date faqs
             */
            $data = mega_parse_args($data, $this->get_data_faqs());
            
            
            return get_view('onepage.onepage', $data);
        }
        else{
            return get_view('homepage', $data);
        }
    }

    /**
     * articles
     * blog
     * category
     * single
     * widget
     * data
     */
    public function index_articles(Request $request)
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#blog'));
        }

        $data['blog']           = $this->get_data_blog();
        $data['page_class']     = 'blog';
        $data['page_title']     = has_option('blog', 'blog_title');
        $data['page_subtitle']  = has_option('blog', 'blog_subtitle');

        return get_view('articles', $data);
    }
    
    public function index_blog(Request $request)
    {
        $data['term_id']        = false;
        $data['page_title']     = has_option('blog', 'blog_title');
        $data['page_subtitle']  = has_option('blog', 'blog_subtitle');
        $data['page_class']     = 'blog';
        $posts = $this->get_posts_query('posts')
        ->orderBy('post_pin', 'desc')
        ->orderBy('post_modified', 'desc');

        if($request->has('s') and $request->get('s')){
            $posts->where('post_title', 'like', '%'.safe_input($request->get('s')).'%');
            $posts->orWhere('post_tags', 'like', '%'.safe_input($request->get('s')).'%');
        }
        if($request->has('tag') and $request->get('tag')){
            $posts->where('post_tags', 'like', '%'.safe_input($request->get('tag')).'%');
        }

        $posts = $posts->paginate(has_option('blog', 'per_page'))->onEachSide(0);

        if ($request->has('page') and $request->get('page') > $posts->lastPage()) {return redirect($posts->url($posts->lastPage()));}

        if($request->has('s') and $request->get('s')){
            $posts->appends(['s' => safe_input($request->get('s'))]);
        }
        
        if($request->has('tag') and $request->get('tag')){
            $posts->appends(['tag' => safe_input($request->get('tag'))]);
        }
        
        $data['posts']  = $posts;

        /**
         * widgets
         */
        $widgets_column             = has_option('blog', 'widgets_column');
        $posts_column               = ($widgets_column == 'col-lg-4')? 'col-lg-8' : 'col-lg-9';
        $data['widgets_column']     = $widgets_column;
        $data['posts_column']       = $posts_column;
        $blog_widgets               = has_option('blog', 'widgets');
        $data['widgets_status']     = $blog_widgets;
        if(in_array($blog_widgets, ['right', 'left'])){
            $widgets_option = has_option('blog', 'widgets_blog');
            $widgets        = [];
            foreach($widgets_option as $key => $widget){
                if(isset($widget['status'])){
                    $widgets[$key]  = [
                        'id'    => $widget['id'],
                        'title' => $widget['title'],
                        'icon'  => $widget['icon'],
                        'data'  => $this->widget_data($widget['id'])
                    ];
                }
            }
            $data['widgets'] = $widgets;
        }

        /**
         * breadcrumbs
         */
        $data['breadcrumbs_title'] = has_option('blog', 'page_title');
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            $data['breadcrumbs'][]  = ['link' => url('/#home'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
        }
        else {
            $data['breadcrumbs'][]  = ['link' => url('/'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
        }

        if($request->has('s') and $request->get('s')){
            $data['breadcrumbs'][]  = ['link' => url('/blog'), 'title' => has_option('blog', 'blog_title')];
            $data['breadcrumbs'][]  = ['link' => false, 'title' => lang('search')];
        }
        elseif($request->has('tag') and $request->get('tag')){
            $data['breadcrumbs'][]  = ['link' => url('/blog'), 'title' => has_option('blog', 'blog_title')];
            $data['breadcrumbs'][]  = ['link' => false, 'title' => lang('tag')];
        }
        else{
            $data['breadcrumbs'][]  = ['link' => false, 'title' => has_option('blog', 'blog_title')];
        }


        /**
         * return view
         */
        if(in_array($blog_widgets, ['right', 'left']))
        {
            return get_view('blog.blog', $data);
        }
        else
        {
            return get_view('blog.blog_full', $data);
        }
    }

    public function index_blog_category($slug, Request $request)
    {
        
        $slug = utf8_uri_encode(safe_input($slug));
        $term = DB::table(TERMS_TABLE)->where(['status' => '1', 'type' => 'posts', 'slug' => $slug])->get();
        if ($term->count()) {
            $get_term               = $term->first();
            $data['term_id']        = $get_term->id;
            $data['term_name']      = $get_term->name;
            $data['term_slug']      = $get_term->slug;
            $data['description']    = $get_term->description;
            $data['page_title']     = has_option('blog', 'blog_title');
            $data['page_subtitle']  = has_option('blog', 'blog_subtitle');
            $data['page_class']     = 'blog';
    
            $posts = $this->get_posts_query('posts')
            ->where('term_id', $get_term->id)
            ->orderBy('post_pin', 'desc')
            ->orderBy('post_modified', 'desc');
    
            if($request->has('s') and $request->get('s')){
                $posts->where('post_title', 'like', '%'.safe_input($request->get('s')).'%');
                $posts->orWhere('post_tags', 'like', '%'.safe_input($request->get('s')).'%');
            }
            if($request->has('tag') and $request->get('tag')){
                $posts->where('post_tags', 'like', '%'.safe_input($request->get('tag')).'%');
            }
    
            $posts = $posts->paginate(has_option('blog', 'per_page'))->onEachSide(0);
    
            if ($request->has('page') and $request->get('page') > $posts->lastPage()) {return redirect($posts->url($posts->lastPage()));}
    
            if($request->has('s') and $request->get('s')){
                $posts->appends(['s' => safe_input($request->get('s'))]);
            }
            
            if($request->has('tag') and $request->get('tag')){
                $posts->appends(['tag' => safe_input($request->get('tag'))]);
            }
            
            $data['posts']  = $posts;
    
            /**
             * widgets
             */
            $widgets_column             = has_option('blog', 'widgets_column');
            $posts_column               = ($widgets_column == 'col-lg-4')? 'col-lg-8' : 'col-lg-9';
            $data['widgets_column']     = $widgets_column;
            $data['posts_column']       = $posts_column;
            $blog_widgets               = has_option('blog', 'widgets');
            $data['widgets_status']     = $blog_widgets;
            if(in_array($blog_widgets, ['right', 'left'])){
                $widgets_option = has_option('blog', 'widgets_blog');
                $widgets        = [];
                foreach($widgets_option as $key => $widget){
                    if(isset($widget['status'])){
                        $widgets[$key]  = [
                            'id'    => $widget['id'],
                            'title' => $widget['title'],
                            'icon'  => $widget['icon'],
                            'data'  => $this->widget_data($widget['id'])
                        ];
                    }
                }
                $data['widgets'] = $widgets;
            }
    
            /**
             * breadcrumbs
             */
            $data['breadcrumbs_title'] = has_option('blog', 'page_title');
            if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
                $data['breadcrumbs'][]  = ['link' => url('/#home'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
            }
            else {
                $data['breadcrumbs'][]  = ['link' => url('/'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
            }
            $data['breadcrumbs'][]  = ['link' => url('/blog'), 'title' => has_option('blog', 'blog_title')];
            if($request->has('s') and $request->get('s')){
                $data['breadcrumbs'][]  = ['link' => url('/blog/category/'.$get_term->slug), 'title' => $get_term->name];
                $data['breadcrumbs'][]  = ['link' => false, 'title' => lang('search')];
            }
            elseif($request->has('tag') and $request->get('tag')){
                $data['breadcrumbs'][]  = ['link' => url('/blog/category/'.$get_term->slug), 'title' => $get_term->name];
                $data['breadcrumbs'][]  = ['link' => false, 'title' => lang('tag')];
            }
            else{
                $data['breadcrumbs'][]  = ['link' => false, 'title' => $get_term->name];
            }
            
    
            /**
             * return view
             */
            if(in_array($blog_widgets, ['right', 'left']))
            {
                return get_view('blog.blog', $data);
            }
            else
            {
                return get_view('blog.blog_full', $data);
            }
        }
        else{
            return redirect(url('blog'));
        }
    }

    public function index_single_post($slug, Request $request)
    {
        $slug = utf8_uri_encode(safe_input($slug));
        $post = DB::table(POSTS_TABLE)->where(['post_status' => '1', 'post_type' => 'posts', 'post_name' => $slug])->get();
        if ($post->count()) {
            $single     = $post->first();

            /**
             * update views
             */
            $views      = $single->post_views+1;
            DB::table(POSTS_TABLE)->where('id', $single->id)->update(['post_views' => $views]);

            /**
             * data single post
             */
            $data['single']         = $single;
            $data['page_title']     = $single->post_title;
            $data['page_subtitle']  = $single->post_excerpts;
            $data['page_class']     = 'blog';
            $data['post_meta']      = query_posts_meta($single->id);
            $data['details']        = (is_array($data['post_meta']['details']))? $data['post_meta']['details'] : [];
            /**
             * data term
             */
            $data['term_id']        = $single->term_id;
            $data['term_name']      = get_term_name($single->term_id);
            $data['term_slug']      = get_term_slug($single->term_id);
            $data['post_tags']      = explode(',', $single->post_tags);

            /**
             * widgets
             */
            $widgets_column             = has_option('blog', 'post_widgets_column');
            $posts_column               = ($widgets_column == 'col-lg-4')? 'col-lg-8' : 'col-lg-9';
            $data['widgets_column']     = $widgets_column;
            $data['posts_column']       = $posts_column;
            $blog_widgets               = has_option('blog', 'post_widgets');
            $data['widgets_status']     = $blog_widgets;
            if(in_array($blog_widgets, ['right', 'left'])){
                $widgets_option = has_option('blog', 'widgets_blog');
                $widgets        = [];
                foreach($widgets_option as $key => $widget){
                    if(isset($widget['status'])){
                        $widgets[$key]  = [
                            'id'    => $widget['id'],
                            'title' => $widget['title'],
                            'icon'  => $widget['icon'],
                            'data'  => $this->widget_data($widget['id'])
                        ];
                    }
                }
                $data['widgets'] = $widgets;
            }
    
            /**
             * breadcrumbs
             */
            $data['breadcrumbs_title'] = has_option('blog', 'page_title');
            if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
                $data['breadcrumbs'][]  = ['link' => url('/#home'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
            }
            else {
                $data['breadcrumbs'][]  = ['link' => url('/'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
            }
            $data['breadcrumbs'][]  = ['link' => url('/blog'), 'title' => has_option('blog', 'blog_title')];
            $data['breadcrumbs'][]  = ['link' => url('/blog/category/'.get_term_slug($single->term_id)), 'title' => get_term_name($single->term_id)];
            $data['breadcrumbs'][]  = ['link' => false, 'title' => $single->post_title];

            /**
             * share link
             */
            $data['sharelink'] = has_option('blog', 'sharelink');

            /**
             * seo
             */
            $data['description']    = $data['post_meta']['meta_desc'];
            $data['keywords']       = $single->post_tags;
            $data['seo_image']      = get_attachment_url($data['post_meta']['thumbnails'], 'full');

            /**
             * related
             */
            $data['is_related'] = has_option('blog', 'related_posts');
            $data['related'] = $this->get_posts_query('posts')
            ->where([['posts.id', '!=', $single->id], ['posts.term_id', '=', $single->term_id]])
            ->inRandomOrder()
            ->limit(has_option('blog', 'related_posts_per_page'))
            ->get();
    
            /**
             * return view
             */
            if(in_array($blog_widgets, ['right', 'left']))
            {
                return get_view('blog.single_post', $data);
            }
            else
            {
                return get_view('blog.single_post_full', $data);
            }

        }
        else
        {
            return redirect('/blog');
        }
    }

    public function widget_data($type = false)
    {
        if($type == 'categories'){
            $categories = DB::table(TERMS_TABLE)->where([['type', '=', 'posts'], ['status', '=', '1']])->orderBy('orders', 'ASC')->get();
            return $categories;
        }
        elseif($type == 'recent_posts'){
            $recentpost = $this->get_posts_query('posts')->orderBy('post_modified', 'desc')->limit(has_option('blog', 'recent_per_page'))->get();
            return $recentpost;
        }
        elseif($type == 'popular_posts'){
            $popularpost = $this->get_posts_query('posts')->orderBy('post_views', 'desc')->limit(has_option('blog', 'popular_per_page'))->get();
            return $popularpost;
        }
        elseif($type == 'tags_cloud'){
            $tags = [];
            $posts = DB::table(POSTS_TABLE)->where([['post_status', '=', '1'], ['post_type', '=', 'posts']])->orderBy('post_views', 'desc')->get();
            foreach($posts as $post){                
                if($post->post_tags != NULL or $post->post_tags != ''){
                    $tags_array = explode(',', $post->post_tags);
                    $tags = mega_parse_args( $tags, $tags_array);
                }   
            }
            return array_count_values($tags);
        }
        else{
            return '';
        }
    }
    
    public function get_data_blog()
    {        
        $data['posts_pin'] = $this->get_posts_query('posts')->where([
            ['post_status', '=', '1'],
            ['post_pin', '=', '1'],
        ])->orderBy('post_modified', 'desc')->get()->first();

        $offset_block1 = 0;
        $offset_block2 = 4;
        if($data['posts_pin'] == NULL)
        {
            $data['posts_pin'] = $this->get_posts_query('posts')->where([
                ['post_status', '=', '1'],
                ['post_pin', '!=', '1'],
            ])->orderBy('post_modified', 'desc')->get()->first();
            $offset_block1 = 1;
            $offset_block2 = 5;
        }

        $data['posts_featured'] = $this->get_posts_query('posts')->where([
            ['post_status', '=', '1'],
            ['post_pin', '!=', '1'],
        ])->orderBy('post_modified', 'desc')->offset($offset_block1)->limit(4)->get();

        $data['posts'] = $this->get_posts_query('posts')->where([
            ['post_status', '=', '1'],
            ['post_pin', '!=', '1'],
        ])->orderBy('post_modified', 'desc')->offset($offset_block2)->limit(6)->get();

        return $data;
    }

    /**
     * portfolio
     * single
     * data
    */
    public function index_portfolio()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#portfolio'));
        }

        $data['page_class'] = 'portfolio';
        $data['portfolio'] = $this->get_data_portfolio();

        return get_view('portfolio.portfolio', $data);
    }

    public function single_portfolio($slug,  Request $request)
    {
        $slug = utf8_uri_encode($slug);
        $post = DB::table(POSTS_TABLE)->where(['post_type' => 'portfolio', 'post_status' => '1', 'post_name' => $slug])->get();
        $data['page_class'] = 'portfolio';
        if($post->count())
        {
            $single     = $post->first();

            /**
             * update views
             */
            $views      = $single->post_views+1;
            DB::table(POSTS_TABLE)->where('id', $single->id)->update(['post_views' => $views]);

            /**
             * data single post
             */
            $data['single']         = $single;
            $data['page_title']     = $single->post_title;
            $data['page_subtitle']  = $single->post_excerpts;
            $data['page_class']     = 'portfolio';
            $data['post_meta']      = query_posts_meta($single->id);
            $data['details']        = (is_array($data['post_meta']['details']))? $data['post_meta']['details'] : [];

            $data['gallery']        = (isset($data['post_meta']['gallery']) and is_array($data['post_meta']['gallery']))? $data['post_meta']['gallery'] : [];
            $data['portfolio_type'] = (isset($data['post_meta']['portfolio_type']))? $data['post_meta']['portfolio_type'] : '';
            $data['video_url']      = (isset($data['post_meta']['video_url']))? $data['post_meta']['video_url'] : '';
            $data['iframe_url']     = (isset($data['post_meta']['iframe_url']))? $data['post_meta']['iframe_url'] : '';

            /**
             * data term
             */
            $data['term_id']        = $single->term_id;
            $data['term_name']      = get_term_name($single->term_id);
            $data['term_slug']      = get_term_slug($single->term_id);
            
            /**
             * breadcrumbs
             */
            $data['breadcrumbs_title'] = has_option('portfolio', 'page_title');
            if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
                $data['breadcrumbs'][]  = ['link' => url('/#home'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
                $data['breadcrumbs'][]  = ['link' => url('/#portfolio'), 'title' => has_option('portfolio', 'page_title')];
            }
            else {
                $data['breadcrumbs'][]  = ['link' => url('/'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
                $data['breadcrumbs'][]  = ['link' => url('portfolio'), 'title' => has_option('portfolio', 'page_title')];
            }
            
            $data['breadcrumbs'][]  = ['link' => false, 'title' => $single->post_title];

            /**
             * share link
             */
            $data['sharelink'] = has_option('portfolio', 'sharelink');

            /**
             * seo
             */
            $data['description']    = $data['post_meta']['meta_desc'];
            $data['keywords']       = $single->post_tags;
            $data['seo_image']      = get_attachment_url($data['post_meta']['thumbnails'], 'full');

            /**
             * related
             */
            $data['is_related'] = has_option('portfolio', 'related_posts');
            $data['related'] = $this->get_portfolio_query('portfolio')
            ->where([['posts.id', '!=', $single->id], ['posts.term_id', '=', $single->term_id]])
            ->inRandomOrder()
            ->limit(has_option('portfolio', 'related_posts_per_page'))
            ->get();

            return get_view('portfolio.single_portfolio', $data);
        }
        else
        {
            return redirect(url('portfolio'));
        }
    }

    public function get_data_portfolio()
    {
        $data['page_class'] = 'portfolio';
        $data['terms'] = $this->get_terms_query('portfolio')->orderBy('orders', 'ASC')->get();
        if(has_option('portfolio', 'loadmore')){
            $data['posts'] = $this->get_portfolio_query('portfolio')->orderBy('post_modified', 'DESC')->limit(has_option('portfolio', 'limitloadmore'))->get();
        }
        else {
            $data['posts'] = $this->get_portfolio_query('portfolio')->orderBy('post_modified', 'DESC')->get();
        }
        
        return $data;
    }

    /**
     * aboutme
     * data
     */
    public function index_aboutme()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#aboutme'));
        }

        $data['page_class'] = 'aboutme';
        $data = mega_parse_args($data, $this->get_data_aboutme());
        $data['pricings'] = $this->get_data_pricings();

        return get_view('aboutme', $data);
    }

    public function get_data_aboutme()
    {
        /**
         * services
         */
        $data['services'] = $this->get_posts_query('services')->orderBy('post_orders', 'ASC')->get();

        /**
         * workingway
         */
        $data['workingway'] = $this->get_posts_query('workingway')->orderBy('post_orders', 'ASC')->get();

        /**
         * testimonials
         */
        $data['testimonials'] = $this->get_posts_query('testimonials')->orderBy('post_orders', 'ASC')->get();

        /**
         * clients
         */
        $data['clients'] = $this->get_posts_query('clients')->orderBy('post_orders', 'ASC')->get();

        /**
         * funfacts
         */
        $data['funfacts'] = $this->get_posts_query('funfacts')->orderBy('post_orders', 'ASC')->get();

        return $data;
    }

    /**
     * resume
     * data
     */
    public function index_resume()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#resume'));
        }

        $data['page_class'] = 'resume';
        $data = mega_parse_args($data, $this->get_data_resume());

        return get_view('resume', $data);
    }

    public function get_data_resume()
    {
        /**
         * education
         */
        $data['education'] = $this->get_posts_query('education')->orderBy('post_orders', 'ASC')->get();

        /**
         * experience
         */
        $data['experience'] = $this->get_posts_query('experience')->orderBy('post_orders', 'ASC')->get();

        /**
         * skills
         */
        $data['term_skills'] = $this->get_terms_query('skills')->orderBy('orders', 'ASC')->get();

        return $data;
    }

    /**
     * appointments 
     * send
     */
    public function index_appointments()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#appointments'));
        }

        $data['page_class'] = 'appointments';
        $data['page_title'] = has_option('appointments', 'page_title');

        return get_view('appointments', $data);
    }

    public function send_appointments(Request $request)
    {
        $redirect_url = (in_array(has_option('style', 'template'), ['onepage', 'scrollpage']))? url('/#appointments') : url('/appointments');

        $rules = [
            'apm_subject'   => 'required',
            'apm_name'      => 'required',
            'apm_email'     => 'required|email',
            'apm_phone'     => 'required',
            'apm_date'      => 'required',
            'apm_time'      => 'required',
            'apm_message'   => 'required',
        ];

        $message = [
            'required' => lang('the_field_required'),
            'contact_email.email' => lang('error_email'),
        ];

        if(has_option('apikeys', 'captcha_status')){
            $rules['g-recaptcha-response'] = 'required|recaptcha';
            $message['g-recaptcha-response.required']   = lang('complete_the_captcha');
            $message['g-recaptcha-response.recaptcha']  = lang('captcha_verification_failed');
        }

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect($redirect_url)->withErrors($validator)->withInput();
        }

        $send_applications  = has_option('appointments', 'send');

        if(in_array($send_applications, ['email', 'both']))
        {
            $mail_data = [
                'msg_subject'   => safe_input($request->get('apm_subject')),
                'msg_name'      => safe_input($request->get('apm_name')),
                'msg_email'     => safe_input($request->get('apm_email')),
                'msg_phone'     => safe_input($request->get('apm_phone')),
                'msg_date'      => safe_input($request->get('apm_date')),
                'msg_time'      => safe_input($request->get('apm_time')),
                'msg_content'   => safe_input($request->get('apm_message')),
            ];
            if(env('IS_MAILER')) {
                Mail::send('emails.appointments', $mail_data, function ($message) {
                    $message->to(get_option('webmaster_email'))->replyTo(request()->get('email'), request()->get('name'))->subject(lang('email_training_appointments', ['name' => request()->get('name')]));
                });
            }
        }

        if(in_array($send_applications, ['database', 'both']))
        {
            $post_excerpts = maybe_serialize([
                'username'  => safe_input($request->get('apm_name')),
                'email'     => safe_input($request->get('apm_email')),
                'subject'   => safe_input($request->get('apm_subject')),
                'phone'     => safe_input($request->get('apm_phone')),
                'date'      => safe_input($request->get('apm_date')),
                'time'      => safe_input($request->get('apm_time')),
            ]);

            $message_id = DB::table(POSTS_TABLE)->insertGetId([
                'post_author'       => 0,
                'post_title'        => safe_input($request->get('apm_name')),
                'post_excerpts'     => $post_excerpts,
                'post_content'      => safe_textarea($request->get('apm_message')),
                'post_status'       => 0,
                'post_type'         => 'appointments',
            ]);

            $browser_detect = [
                'ip'                => GetRealIp(),
                'useragent'         => Browser::userAgent(),
                'platformname'      => Browser::platformName(),
                'platformfamily'    => Browser::platformFamily(),
                'browserfamily'     => Browser::browserFamily(),
            ];
            update_post_meta('browser_detect', maybe_serialize($browser_detect), $message_id);            
  
        }
        
        return redirect($redirect_url)->with("apm_success", lang('message_has_been_sent'));
    }

    /**
     * contactme
     * send
    */
    public function index_contactme()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#contactme'));
        }

        $data['page_class'] = 'contactme';
        $data['page_title'] = has_option('contactme', 'page_title');

        return get_view('contactme', $data);
    }

    public function send_contact(Request $request)
    {
        $redirect_url = (in_array(has_option('style', 'template'), ['onepage', 'scrollpage']))? url('/#contactme') : url('/contactme');

        $rules = [
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_message' => 'required',
        ];

        $message = [
            'required' => lang('the_field_required'),
            'contact_email.email' => lang('error_email'),
        ];

        if(has_option('apikeys', 'captcha_status')){
            $rules['g-recaptcha-response'] = 'required|recaptcha';
            $message['g-recaptcha-response.required']   = lang('complete_the_captcha');
            $message['g-recaptcha-response.recaptcha']  = lang('captcha_verification_failed');
        }

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect($redirect_url)->withErrors($validator)->withInput();
        }

        $send_contact  = has_option('contactme', 'send');

        if(in_array($send_contact, ['email', 'both'])){
            $mail_data = [
                'msg_name'      => safe_input($request->get('contact_name')),
                'msg_email'     => safe_input($request->get('contact_email')),
                'msg_content'   => safe_textarea($request->get('contact_message')),
            ];

            $this->send_username = safe_input($request->get('contact_name'));
            $this->send_email = safe_input($request->get('contact_email'));

            if(env('IS_MAILER')) {
                Mail::send('emails.contact', $mail_data, function ($message) {
                    $message->to(get_option('webmaster_email'))->replyTo($this->send_email, $this->send_username)->subject(lang('email_training_contact', ['name' => $this->send_username]));
                });
            }
        }

        if(in_array($send_contact, ['database', 'both'])){
            $post_excerpts = maybe_serialize([
                'username'  => safe_input($request->get('contact_name')),
                'email'     => safe_input($request->get('contact_email')),
            ]);

            $message_id = DB::table(POSTS_TABLE)->insertGetId([
                'post_author'       => 0,
                'post_title'        => safe_input($request->get('contact_name')),
                'post_excerpts'     => $post_excerpts,
                'post_content'      => safe_textarea($request->get('contact_message')),
                'post_status'       => 0,
                'post_type'         => 'contactus',
            ]);

            $browser_detect = [
                'ip'                => GetRealIp(),
                'useragent'         => Browser::userAgent(),
                'platformname'      => Browser::platformName(),
                'platformfamily'    => Browser::platformFamily(),
                'browserfamily'     => Browser::browserFamily(),
            ];
            update_post_meta('browser_detect', maybe_serialize($browser_detect), $message_id);
        }

        return redirect($redirect_url)->with("contact_success", lang('message_has_been_sent'));
    }

    /**
     * pricings
     * data
    */
    public function index_pricings()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#pricings'));
        }

        $data['page_class'] = 'pricings';
        $data['page_title'] = has_option('pricings', 'page_title');
        $data['pricings'] = $this->get_data_pricings();

        return get_view('pricings', $data);
    }

    public function get_data_pricings()
    {
        /**
         * pricings
         */
        $data = $this->get_posts_query('pricings')->orderBy('post_orders', 'ASC')->get();
        return $data;
    }

    /**
     * support
     */
    public function index_support()
    {
        if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
            return redirect(url('/#support'));
        }

        $data['page_class'] = 'support';
        $data['page_title'] = has_option('support', 'page_title');

        return get_view('support', $data);
    }

    /**
     * index_page
     */
    public function index_page($slug, Request $request)
    {
        $slug = utf8_uri_encode($slug);
        $post = DB::table(POSTS_TABLE)->where(['post_status' => '1', 'post_type' => 'pages', 'post_name' => $slug])->get();
        if ($post->count()) {
            $single     = $post->first();
            /**
             * update views
             */
            $views      = $single->post_views+1;
            DB::table(POSTS_TABLE)->where('id', $single->id)->update(['post_views' => $views]);
            $data['single']         = $single;
            $data['page_title']     = $single->post_title;
            $data['page_subtitle']  = $single->post_excerpts;
            $data['page_class']     = 'page-'.$single->id;
            $data['page_style']     = get_post_meta('style', $single->id);


            $data['breadcrumbs_title'] = has_option('portfolio', 'page_title');
            if(in_array(has_option('style', 'template'), ['onepage', 'scrollpage'])) {
                $data['breadcrumbs'][]  = ['link' => url('/#home'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
                $data['breadcrumbs'][]  = ['link' => false, 'title' => $single->post_title];
            }
            else {
                $data['breadcrumbs'][]  = ['link' => url('/'), 'title' => lang('home'), 'icon' => 'lnr lnr-home'];
                $data['breadcrumbs'][]  = ['link' => false, 'title' => $single->post_title];
            }

            return get_view('page', $data);
        } else {
            return redirect('/');
        }
    }


    /**
     * faqs
     * data
     */
    public function index_faqs()
    {
        if(has_option('faqs', 'status')){
            $data['page_class'] = 'faqs';
            $data['page_title'] = has_option('faqs', 'page_title');
            $data = mega_parse_args($data, $this->get_data_faqs());

            return get_view('faqs', $data);
        }  
        else {
            $redirect_url = (in_array(has_option('style', 'template'), ['onepage', 'scrollpage']))? url('/#support') : url('/support');
            return redirect($redirect_url);
        } 
    }

    public function get_data_faqs()
    {
        $get_faqs = $this->get_posts_query('faqs')->orderBy('post_orders', 'ASC')->get();
        $x = 0;
        $faqs1 = [];
        $faqs2 = [];
        $faqs = [];
        if($get_faqs->count()){
            foreach($get_faqs as $faq){
                $x++;
                if($x == 1){
                    $faqs1[] = [
                        'post_title'    => $faq->post_title,
                        'post_content'  => $faq->post_content,
                    ];
                }
                else {
                    $faqs2[] = [
                        'post_title'    => $faq->post_title,
                        'post_content'  => $faq->post_content,
                    ];
                    $x = 0;
                }
    
                $faqs[] = [
                    'post_title'    => $faq->post_title,
                    'post_content'  => $faq->post_content,
                ];
            }
        }
        

        $data['faqs1'] = $faqs1;
        $data['faqs2'] = $faqs2;
        $data['faqs'] = $faqs;  

        return $data;
    }

}