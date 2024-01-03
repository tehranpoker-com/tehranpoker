<?php

/**
 * Theme Name: Basma Resume
 * Theme URI: http://themearabia.net/php_help_manager/themes/basma_resume
 * Version: 1.0
 * Requires: 1.0
 * Description: Theme Description
 * Author: Themearabia
 * Author URI: http://themearabia.net
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (!class_exists('theme_default')) {
    class theme_default {

        protected $theme_folder = 'default';
        protected $theme_order  = '1';
        protected $pagetemplate = '';
        protected $route_name   = '';

        function __construct()
        {
            $this->theme_path  = resource_path('views/frontend/'.$this->theme_folder);
            $this->theme_url   = url(env('APP_ROOT_PAHT').'/resources/views/frontend/'.$this->theme_folder);
            $this->pagetemplate = has_option('style', 'template');
            $this->route_name = Route::currentRouteName();
            if(!is_admin()){
                Eventy::addAction('blade_body_class', [$this, 'action_body_class'], $this->theme_order, 1);
                Eventy::addAction('blade_action_header_before', [$this, 'action_header_before'], $this->theme_order, 1);
                Eventy::addAction('blade_action_header_after', [$this, 'action_header_after'], $this->theme_order, 1);
                Eventy::addAction('blade_action_footer_before', [$this, 'action_footer_before'], $this->theme_order, 1);
                Eventy::addAction('blade_action_footer_after', [$this, 'action_footer_after'], $this->theme_order, 1);
                Eventy::addAction('blade_action_script', [$this, 'action_script'], $this->theme_order, 1);

            }
        }

        public function action_body_class()
        {
            $body_class     = [];
            $darkmode       = has_option('style', 'darkmode');
            $music          = has_option('sidebar', 'music_status');
            $body_class[]   = get_option('language', 'en');
            $body_class[]   = get_option('direction', 'ltr');
            $body_class[]   = 'sidebar-'.has_option('sidebar', 'position');

            $body_class[]   = has_option('style', 'template', 'onepage');
            
            if(($darkmode)){
                $body_class[]   = 'dark';
            }
            
            if(($music)){
                $body_class[]   = 'music';
            }
            
            echo implode(' ', $body_class);
        }

        public function action_header_before()
        {
            $font_family = has_option('style', 'fontfamily');
            $font_link = str_replace(' ', '%20', $font_family);
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family='.$font_link.':300,400,600,800">'."\n";
            $skinscolor = has_option('style', 'skinscolor');
            echo "<style>:root {--skinscolor: {$skinscolor}!important;--fontfamily: '{$font_family}', sans-serif!important;}</style>"."\n";
            echo '<link rel="stylesheet" href="'.asset('libs/fonticons/fonticons.min.css').'">'."\n";
        }

        public function action_header_after()
        {
            $stylesheet = '';
            $css_files  = [];
            $background = [];
            $css_code   = '';
            $contactme_css = false;
            /**
             * icons
             */
            if(has_option('fonticon', 'boxicons')){
                $css_files['boxicons'] = asset('libs/fonticons/boxicons.min.css');
            }

            if(has_option('fonticon', 'fontawesome')){
                $css_files['fontawesome'] = asset('libs/fonticons/fontawesome.min.css');
            }
            
            /**
             * page template
             */
            if(in_array($this->pagetemplate, ['onepage', 'scrollpage'])){
                if(has_option('appointments', 'mastatus')){
                    $css_files['dropper'] = get_asset('css/dropper.min.css');

                }

                $background = [
                    'homepage'      => '.section-home',
                    'blog'          => '.section-blog',
                    'contactme'     => '.section-contactme',
                    'portfolio'     => '.section-portfolio',
                    'aboutme'       => '.section-aboutme',
                    'appointments'  => '.section-appointments',
                    'pricings'      => '.section-pricings',
                    'support'       => '.section-support',
                    'faqs'          => '.section-faqs',
                    'resume'        => '.section-resume',
                ];
                
                $contactme_css = true;


                $pages = get_posts_type('pages');
                if($pages->count()){
                    foreach($pages as $page){
                        $is_style = get_post_meta('style', $page->id);
                        if($is_style == 'bgimage'){
                            $background['page-'.$page->id]         = '.section-page-'.$page->id;
                            $background_status['page-'.$page->id]  = true;
                            $background_image['page-'.$page->id]   = get_post_meta('bgimage', $page->id);
                        }
                    }
                }

            }
            else {

                /**
                 * homepage
                 */
                if($this->route_name == 'home'){
                    $background['homepage'] = '.section-home';
                }

                /**
                 * blog
                 */
                if($this->route_name == 'articles'){
                    $background['blog'] = '.section-blog';
                }

                /**
                 * portfolio
                 */
                if($this->route_name == 'portfolio'){
                    $background['portfolio'] = '.section-portfolio';
                }

                /**
                 * appointments
                 */
                if($this->route_name == 'appointments'){
                    if(has_option('appointments', 'mastatus')){
                        $css_files['dropper'] = get_asset('css/dropper.min.css');
                    }
                    $background['appointments'] = '.section-appointments';
                }

                /**
                 * contactme
                 */
                if($this->route_name == 'contactme'){
                    $background['contactme'] = '.section-contactme';
                    $contactme_css = true;
                }
                
                /**
                 * aboutme
                 */
                if($this->route_name == 'aboutme'){
                    $background['aboutme'] = '.section-aboutme';
                }

                /**
                 * resume
                 */
                if($this->route_name == 'resume'){
                    $background['resume'] = '.section-resume';
                }

                /**
                 * pricings
                 */
                if($this->route_name == 'pricings'){
                    $background['pricings'] = '.section-pricings';
                }

                /**
                 * support
                 */
                if($this->route_name == 'support'){
                    $background['support'] = '.section-support';
                }

                /**
                 * faqs
                 */
                if($this->route_name == 'faqs'){
                    $background['faqs'] = '.section-faqs';
                }

                /**
                 * page
                 */
                if($this->route_name == 'page'){
                    $current_params = Route::current()->parameters();
                    $slug = utf8_uri_encode($current_params['slug']);
                    $page_id = get_postid_by_postname($slug, 'pages');
                    $background_status['page']  = false;
                    if(get_post_meta('style', $page_id) == 'bgimage'){
                        $background['page']         = '.section-page';
                        $background_status['page']  = true;
                        $background_image['page']   = get_post_meta('bgimage', $page_id);
                    }
                }

            }

            /**
             * loop files css
             */
            foreach($css_files as $file){
                $stylesheet .= '<link href="'.$file.'" rel="stylesheet" type="text/css" />'."\n";
            }

            /**
             * code css
             */
            
            foreach($background as $key => $item){
                $page_bgimage = (isset($background_status[$key]))? $background_status[$key] : has_option($key, 'style');
                $bgimage = (isset($background_image[$key]))? $background_image[$key] : has_option($key, 'bgimage');
                if($page_bgimage == 'bgimage' and $bgimage){
                    $css_code .= $item.'{background-image: url('.$bgimage.');}';
                }
            }

            if($contactme_css){
                foreach (has_option('contactme', 'socials') as $key => $item){
                    if(isset($item['status'])){
                        $css_code .= ".social{$key}{background:{$item['bgcolor']};color:{$item['color']};}";
                    }
                }
            }


            foreach (has_option('footer', 'socials') as $key => $item){
                if(isset($item['status'])){
                    $css_code .= ".footer .social .footer-social{$key} i{border-color:{$item['bgcolor']};color:{$item['color']};}";
                    $css_code .= ".footer .social .footer-social{$key} i:hover{background:{$item['bgcolor']};color:{$item['color']};}";
                }
            }
            
            if(has_option('style', 'customcss')){
                $css_code .= has_option('style', 'customcss');
            }

            echo $stylesheet;
            
            if($css_code){
                echo '<style type="text/css">'.$css_code.'</style>'."\n";
            }

            if(has_option('apikeys', 'google_analytics_status')){
                $google_analytics = has_option('apikeys', 'google_analytics');
                echo '<script async src="https://www.google-analytics.com/analytics.js"></script>'."\n";
                echo "<script>window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;ga('create', '{$google_analytics}', 'auto');ga('send', 'pageview');</script>"."\n";
            }
            
        }

        public function action_footer_before()
        {
            if(has_option('style', 'gotoup')){
                $icon = (has_option('style', 'gotoupicon'))? has_option('style', 'gotoupicon') : 'lnr lnr-chevron-up' ;
                echo '<div class="go-up"><i class="'.$icon.'"></i></div>'."\n";
            }
        }

        public function action_footer_after(){
            
        }

        public function action_script(){
            $html = '';
            $files_js = [];
            $script_code = '';

            /**
             * sidebar music
             */
            if(has_option('sidebar', 'music_status')){
                $files_js['music'] = get_asset('js/music.min.js');
            }
            
            if(in_array($this->pagetemplate, ['onepage', 'scrollpage'])){
                
                if($this->pagetemplate == 'scrollpage'){
                    $files_js['nav'] = get_asset('js/jquery.nav.js');
                }

                

                /**
                 * bgvideo
                 */
                if(has_option('homepage', 'style') == 'bgvideo'){
                    $files_js['bgvideo'] = get_asset('js/jquery.mb.ytplayer.js');
                }

                /**
                 * particles
                 */
                if(has_option('homepage', 'particles')){
                    $files_js['particles'] = get_asset('js/particles.min.js');
                }

                /**
                 * contactme
                 */
                if(has_option('contactme', 'mapstatus')){
                    $files_js['googlemap'] = 'https://maps.google.com/maps/api/js?key=AIzaSyBkdsK7PWcojsO-o_q2tmFOLBfPGL8k8Vg&amp;language=en';       
                }

                /**
                 * appointments
                 */
                if(has_option('appointments', 'mastatus')){
                    $files_js['dropper'] = get_asset('js/dropper.min.js');
                    if(has_option('appointments', 'mastatus')){
                        $script_code .= "(function ($) { $('#app_date').dateDropper();$('#app_time').timeDropper(); })(jQuery);"."\n";
                    }
                }

                /**
                 * google recaptcha
                 */
                if(has_option('apikeys', 'captcha_status')){
                    $files_js['grecaptcha'] = 'https://www.google.com/recaptcha/api.js?hl='.get_option('language', 'en');
                }


            }
            else{

                /**
                 * homepage
                 */
                if($this->route_name == 'homepage'){
                    if(has_option('homepage', 'style') == 'bgvideo'){
                        $files_js['bgvideo'] = get_asset('js/jquery.mb.ytplayer.js');
                    }

                    if(has_option('homepage', 'particles')){
                        $files_js['particles'] = get_asset('js/particles.min.js');
                        $files_js['particles_app'] = get_asset('js/particles.app.js');
                    }
                }

                /**
                 * appointments
                 */
                if($this->route_name == 'appointments'){
                    if(has_option('appointments', 'mastatus')){
                        $files_js['dropper'] = get_asset('js/dropper.min.js');
                    }
                    if(has_option('apikeys', 'captcha_status')){
                        $files_js['grecaptcha'] = 'https://www.google.com/recaptcha/api.js?hl='.get_option('language', 'en');
                    }

                    if(has_option('appointments', 'mastatus')){
                        $script_code .= "(function ($) { $('#app_date').dateDropper();$('#app_time').timeDropper(); })(jQuery);"."\n";
                    }

                }

                /**
                 * contactme
                 */
                if($this->route_name == 'contactme'){
                    $files_js['googlemap'] = 'https://maps.google.com/maps/api/js?key=AIzaSyBkdsK7PWcojsO-o_q2tmFOLBfPGL8k8Vg&amp;language=en'; 
                    if(has_option('apikeys', 'captcha_status')){
                        $files_js['grecaptcha'] = 'https://www.google.com/recaptcha/api.js?hl='.get_option('language', 'en');
                    }
                }
                
                /**
                 * aboutme
                 */
                if($this->route_name == 'aboutme'){
                    
                }

                /**
                 * resume
                 */
                if($this->route_name == 'resume'){
                    
                }

                /**
                 * pricings
                 */
                if($this->route_name == 'pricings'){
                    
                }

                /**
                 * support
                 */
                if($this->route_name == 'support'){
                    
                }

                /**
                 * faqs
                 */
                if($this->route_name == 'faqs'){
                    
                }

                /**
                 * page
                 */
                if($this->route_name == 'page'){
                    
                }


            }


            foreach($files_js as $js){
                $html .= '<script src="'.$js.'"></script>'."\n";
            }

            $cookie_id      = (has_option('cookie', 'id'))? has_option('cookie', 'id') : '';
            $pagesanimate   = (has_option('style', 'pagesanimate'))? has_option('style', 'pagesanimate') : 'fadeInLeft';
            $csrf_token     = csrf_token();
            $ajaxRequest    = url('ajaxRequest');

            $html .= '<script>'."\n";
            $html .= has_option('style', 'customjs')."\n";
            $html .= "$.ajaxSetup({headers: {'X-CSRF-TOKEN': '{$csrf_token}'}});var ajaxRequest = '{$ajaxRequest}', cookie_id = '{$cookie_id}', pagetemplate = '{$this->pagetemplate}', animated_direction = '{$pagesanimate}';"."\n";
            $html .= $script_code;
            $html .= '</script>'."\n";
            echo $html;
        }

    }
    new theme_default();
}