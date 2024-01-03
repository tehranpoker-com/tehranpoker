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

class DashboardController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }

    /**
     * index_dashboard
     */
    public function index_dashboard()
    {
        $data['page_title'] = admin_lang('dashboard');
        $data['page_class'] = 'dashboard';
        $visitor_ismobile               = DB::table(VISITOR_TABLE)->where('ismobile', '1')->count();
        $visitor_istablet               = DB::table(VISITOR_TABLE)->where('istablet', '1')->count();
        $visitor_isdesktop              = DB::table(VISITOR_TABLE)->where('isdesktop', '1')->count();
        $visitor_isbot                  = DB::table(VISITOR_TABLE)->where('isbot', '1')->count();
        $visitor_ischrome               = DB::table(VISITOR_TABLE)->where('ischrome', '1')->count();
        $visitor_isfirefox              = DB::table(VISITOR_TABLE)->where('isfirefox', '1')->count();
        $visitor_isopera                = DB::table(VISITOR_TABLE)->where('isopera', '1')->count();
        $visitor_issafari               = DB::table(VISITOR_TABLE)->where('issafari', '1')->count();
        $visitor_isie                   = DB::table(VISITOR_TABLE)->where('isie', '1')->count();
        $visitor_isedge                 = DB::table(VISITOR_TABLE)->where('isedge', '1')->count();
        $visitor_ismobile               = ($visitor_ismobile)? $visitor_ismobile : 1;
        $visitor_istablet               = ($visitor_istablet)? $visitor_istablet : 1;
        $visitor_isdesktop              = ($visitor_isdesktop)? $visitor_isdesktop : 1;
        $visitor_isbot                  = ($visitor_isbot)? $visitor_isbot : 1;
        $visitor_total                  = $visitor_ismobile + $visitor_istablet + $visitor_isdesktop + $visitor_isbot;
        $data['visitor_total']          = number_format($visitor_total);
        $data['visitor_ismobile']       = number_format($visitor_ismobile);
        $data['visitor_istablet']       = number_format($visitor_istablet);
        $data['visitor_isdesktop']      = number_format($visitor_isdesktop);
        $data['visitor_isbot']          = number_format($visitor_isbot);
        $data['visitor_ismobile_pre']   = number_format(($visitor_total/$visitor_ismobile)*100, 2);
        $data['visitor_istablet_pre']   = number_format(($visitor_total/$visitor_istablet)*100, 2);
        $data['visitor_isdesktop_pre']  = number_format(($visitor_total/$visitor_isdesktop)*100, 2);
        $data['visitor_isbot_pre']      = number_format(($visitor_total/$visitor_isbot)*100, 2);
        $data['visitor_ischrome']       = number_format($visitor_ischrome);
        $data['visitor_isfirefox']      = number_format($visitor_isfirefox);
        $data['visitor_isopera']        = number_format($visitor_isopera);
        $data['visitor_issafari']       = number_format($visitor_issafari);
        $data['visitor_isie']           = number_format($visitor_isie);
        $data['visitor_isedge']         = number_format($visitor_isedge);
        $visitors = DB::table(VISITOR_TABLE)->select('date', DB::raw('count(*) as total'))->orderBy('date', 'DESC')->groupBy('date')->limit(30)->get();
        $chart_data = [];        
        foreach ($visitors as $visitor){
            array_push($chart_data, array('day' => date('d M Y', strtotime($visitor->date)), 'total' => $visitor->total));
        }
        $data['visitors'] = $chart_data;
        $data['dashboard_counter'] = [
            ['title' => admin_lang('pages'), 'count' => get_post_count('pages'), 'icon' => 'bx bx-file'],
            ['title' => admin_lang('posts'), 'count' => get_post_count('posts'), 'icon' => 'bx bx-news'],
            ['title' => admin_lang('portfolio'), 'count' => get_post_count('portfolio'), 'icon' => 'bx bx-briefcase-alt-2'],
            ['title' => admin_lang('services'), 'count' => get_post_count('services'), 'icon' => 'bx bxs-magic-wand'],
            ['title' => admin_lang('workingway'), 'count' => get_post_count('workingway'), 'icon' => 'bx bx-bullseye'],
            ['title' => admin_lang('pricings'), 'count' => get_post_count('pricings'), 'icon' => 'bx bx-dollar-circle'],
            ['title' => admin_lang('testimonials'), 'count' => get_post_count('testimonials'), 'icon' => 'bx bx-user-pin'],
            ['title' => admin_lang('clients'), 'count' => get_post_count('clients'), 'icon' => 'bx bx-heart'],
            ['title' => admin_lang('funfacts'), 'count' => get_post_count('funfacts'), 'icon' => 'bx bx-bullseye'],
            ['title' => admin_lang('education'), 'count' => get_post_count('education'), 'icon' => 'bx bx-id-card'],
            ['title' => admin_lang('experience'), 'count' => get_post_count('experience'), 'icon' => 'bx bx-briefcase-alt'],
            ['title' => admin_lang('skills'), 'count' => get_post_count('skills'), 'icon' => 'bx bx-briefcase-alt-2'],
            ['title' => admin_lang('faqs'), 'count' => get_post_count('faqs'), 'icon' => 'bx bx-help-circle'],
            ['title' => admin_lang('messages') .' <small>('.admin_lang('appointments').')</small>', 'count' => get_post_count('appointments'), 'icon' => 'bx bx-calendar'],
            ['title' => admin_lang('messages') .' <small>('.admin_lang('contactus').')</small>', 'count' => get_post_count('contactus'), 'icon' => 'bx bx-envelope'],
            ['title' => admin_lang('media_library'), 'count' => get_media_count(), 'icon' => 'bx bx-camera'],
        ];

        return get_admin_view('index_dashboard', $data);
    }
    
    /**
     * index_settings
     */
    public function index_settings(Request $request)
    {

        /**
         * backupexport - download file
         */
        if($request->has('backupexport')){
            $content = $this->get_backup_export();
            $fileName = "backup-".date('d-m-Y').".txt";
            $headers = [
                'Content-type' => 'text/plain', 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
                'Content-Length' => strlen($content)
            ];
            return response()->make($content, 200, $headers);
        }

        $data['page_title'] = admin_lang('settings');
        $data['page_class'] = 'settings';

        /**
         * google fonts
         */
        $googlefonts = json_decode(File::get(public_path('public/dashboard/json/googlefonts.json')));
        if (!empty($googlefonts)) {
            foreach ($googlefonts as $key => $options) {
                $font_family[$key] = $key;
            }
        }

        /**
         * menus
         */
        $data['menus']['general']       = ['icon' => 'bx bx-cog', 'title' => admin_lang('general')];
        $data['menus']['apikeys']       = ['icon' => 'bx bx-key', 'title' => admin_lang('settings_api_keys')];
        $data['menus']['sidebar']       = ['icon' => 'bx bx-dock-left', 'title' => admin_lang('sidebar')];
        $data['menus']['homepage']      = ['icon' => 'bx bx-home', 'title' => admin_lang('homepage')];
        $data['menus']['aboutme']       = ['icon' => 'bx bx-user', 'title' => admin_lang('aboutme')]; // ?
        $data['menus']['resume']        = ['icon' => 'bx bx-id-card', 'title' => admin_lang('resume')]; // ?
        $data['menus']['portfolio']     = ['icon' => 'bx bx-briefcase-alt', 'title' => admin_lang('portfolio')];
        $data['menus']['blog']          = ['icon' => 'bx bx-news', 'title' => admin_lang('blog')];
        $data['menus']['contactme']     = ['icon' => 'bx bx-envelope', 'title' => admin_lang('contactme')];
        $data['menus']['appointments']  = ['icon' => 'bx bx-calendar', 'title' => admin_lang('appointments')];
        $data['menus']['support']       = ['icon' => 'bx bx-buoy', 'title' => admin_lang('support')];
        $data['menus']['pricings']      = ['icon' => 'bx bx-dollar-circle', 'title' => admin_lang('pricings')];
        $data['menus']['style']         = ['icon' => 'bx bx-brush', 'title' => admin_lang('style')];
        $data['menus']['seo']           = ['icon' => 'bx bx-envelope', 'title' => admin_lang('seo')];
        $data['menus']['cookie']        = ['icon' => 'bx bx-bulb', 'title' => admin_lang('cookie')];
        $data['menus']['maintenance']   = ['icon' => 'bx bx-power-off', 'title' => admin_lang('maintenance')];
        $data['menus']['backup']        = ['icon' => 'bx bx-data', 'title' => admin_lang('backup')];

        /**
         * skins color options
         */
        $skinscolor_options = [
            '#11d6f0', 
            '#20c997', 
            '#3498db', 
            '#2997ab', 
            '#26bdef', 
            '#8e74b2', 
            '#4608ad', 
            '#f6bb17', 
            '#7daf74', 
            '#37a000', 
            '#f1505b', 
            '#fa7642', 
            '#e74b3e', 
            '#d02e37', 
            '#790000', 
            '#c50e0e',
        ];

        /**
         * General
         * no default
         */
        $data['settings']['general']['website'] = [
            'title'     => admin_lang('website_settings'),
            'options'   => [
                ['type' => 'text', 'id' => 'sitename', 'name' => admin_lang('sitetitle'), 'value' => get_option('sitename')],
                ['type' => 'text', 'id' => 'webmaster_email', 'name' => admin_lang('webmaster_email'), 'value' => get_option('webmaster_email')],
                ['type' => 'radio', 'id' => 'language', 'name' => admin_lang('language'), 'value' => get_option('language', 'en'), 'options' => [
                    'en' => admin_lang('english'),
                    'ar' => admin_lang('arabic')
                ]],
                ['type' => 'radio', 'id' => 'direction', 'name' => admin_lang('direction'), 'value' => get_option('direction', 'ltr'), 'options' => [
                    'ltr' => admin_lang('ltr'),
                    'rtl' => admin_lang('rtl')
                ]],
                ['type' => 'text', 'id' => 'date_format', 'name' => admin_lang('date_format'), 'value' => get_option('date_format', 'F j, Y')],
                ['type' => 'text', 'id' => 'time_format', 'name' => admin_lang('time_format'), 'value' => get_option('time_format', 'g:i a')],
                ['type' => 'radio', 'id' => 'comments', 'name' => admin_lang('comments'), 'value' => get_option('comments', 'off'), 'options' => [
                    'disqus' => admin_lang('disqus_comments'),
                    'graphcomment' => admin_lang('graph_comments'),
                    'off' => admin_lang('off'),
                ]]
            ]
        ];
        $data['settings']['general']['fonticon'] = [
            'title'     => admin_lang('font_icons'),
            'options'   => [
                ['type' => 'radio', 'id' => 'fonticon[boxicons]', 'name' => 'Box icons', 'value' => $this->get_option('fonticon', 'boxicons', 1), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'radio', 'id' => 'fonticon[fontawesome]', 'name' => 'Font Awesome', 'value' => $this->get_option('fonticon', 'fontawesome', 1), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
            ]
        ];
        $data['settings']['general']['dashboard'] = [
            'title'     => admin_lang('dashboard'),
            'options'   => [
                ['type' => 'radio', 'id' => 'content_editor', 'name' => admin_lang('editor'), 'value' => get_option('content_editor', 'articleeditor'), 'options' => [
                    'articleeditor' => 'Article Editor',
                    'tinymce' => 'TinyMce'
                ]],
                ['type' => 'radio', 'id' => 'admin_language', 'name' => admin_lang('language'), 'value' => get_option('admin_language', 'en'), 'options' => [
                    'en' => admin_lang('english'),
                    'ar' => admin_lang('arabic')
                ]],
                ['type' => 'radio', 'id' => 'confirm_pincode', 'name' => admin_lang('confirm_pincode'), 'value' => get_option('confirm_pincode'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
            ]
        ];

        /**
         * apikeys
         * default
         */
        $data['settings']['apikeys']['google_recaptcha'] = [
            'title'     => admin_lang('google_recaptcha'),
            'options'   => [
                ['type' => 'radio', 'id' => 'apikeys[captcha_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('apikeys', 'captcha_status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'text', 'id' => 'apikeys[recaptcha_key]', 'name' => admin_lang('google_rec_sitekey'), 'value' => $this->get_option('apikeys', 'recaptcha_key')],
                ['type' => 'text', 'id' => 'apikeys[recaptcha_secret]', 'name' => admin_lang('google_rec_secretkey'), 'value' => $this->get_option('apikeys', 'recaptcha_secret')],
            ]
        ];
        $data['settings']['apikeys']['google_analytics'] = [
            'title'     => admin_lang('google_analytics'),
            'options'   => [
                ['type' => 'radio', 'id' => 'apikeys[google_analytics_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('apikeys', 'google_analytics_status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'text', 'id' => 'apikeys[google_analytics]', 'name' => admin_lang('google_analytics_id'), 'value' => $this->get_option('apikeys', 'google_analytics')],
            ]
        ];
        $data['settings']['apikeys']['google_map'] = [
            'title'     => admin_lang('google_map'),
            'options'   => [
                ['type' => 'text', 'id' => 'apikeys[google_map_key]', 'name' => admin_lang('google_map'), 'value' => $this->get_option('apikeys', 'google_map_key')],
            ]
        ];
        $data['settings']['apikeys']['crisp_chat'] = [
            'title'     => admin_lang('crisp_chat'),
            'options'   => [
                ['type' => 'radio', 'id' => 'apikeys[crisp_chat_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('apikeys', 'crisp_chat_status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'text', 'id' => 'apikeys[crisp_chat]', 'name' => admin_lang('crisp_chat'), 'value' => $this->get_option('apikeys', 'crisp_chat')],
            ]
        ];
        $data['settings']['apikeys']['comments'] = [
            'title'     => admin_lang('comments'),
            'options'   => [
                ['type' => 'text', 'id' => 'apikeys[disqusid]', 'name' => 'Disqus ID', 'value' => $this->get_option('apikeys', 'disqusid')],
                ['type' => 'text', 'id' => 'apikeys[graphcommentid]', 'name' => 'Graph Comment ID', 'value' => $this->get_option('apikeys', 'graphcommentid')],
            ]
        ];

        /**
         * Sidebar
         * default
         */
        $data['settings']['sidebar']['sidebar'] = [
            'title'     => admin_lang('sidebar'),
            'options'   => [
                ['type' => 'radio', 'id' => 'sidebar[position]', 'name' => admin_lang('direction'), 'value' => $this->get_option('sidebar', 'position'), 'options' => [
                    'left'  => admin_lang('left'),
                    'right' => admin_lang('right'),
                ]],
                ['type' => 'upload', 'id' => 'sidebar[avatar]', 'name' => admin_lang('avatar'), 'value' => $this->get_option('sidebar', 'avatar'), 'src' => 'src'],
                ['type' => 'radio', 'id' => 'sidebar[music_status]', 'name' => admin_lang('music_status'), 'value' => $this->get_option('sidebar', 'music_status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'upload', 'id' => 'sidebar[music]', 'name' => admin_lang('music'), 'value' => $this->get_option('sidebar', 'music'), 'src' => 'src', 'library' => 'audio'],
                ['type' => 'radio', 'id' => 'sidebar[admin_status]', 'name' => admin_lang('admin_show_link'), 'value' => $this->get_option('sidebar', 'admin_status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
            ]
        ];
        $data['settings']['sidebar']['menu'] = [
            'title'     => admin_lang('menu'),
            'options'   => [
                ['type' => 'html', 'html' => $this->get_repeater_sidebar_menu()]
            ]
        ];

        /**
         * homepage
         * default
         */
        $data['settings']['homepage']['homepage'] = [
            'title'     => admin_lang('homepage'),
            'options'   => [
                ['type' => 'text', 'id' => 'homepage[title]', 'name' => admin_lang('title'), 'value' => $this->get_option('homepage', 'title')],
                ['type' => 'text', 'id' => 'homepage[subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('homepage', 'subtitle')],
                ['type' => 'text', 'id' => 'homepage[description]', 'name' => admin_lang('description'), 'value' => $this->get_option('homepage', 'description')],
                ['type' => 'radio', 'id' => 'homepage[textalign]', 'name' => admin_lang('direction'), 'value' => $this->get_option('homepage', 'textalign'), 'options' => [
                    'text-left'   => admin_lang('left'),
                    'text-center' => admin_lang('center'),
                    'text-right'  => admin_lang('right'),
                ]],
                ['type' => 'radio', 'id' => 'homepage[buttonsstatus]', 'name' => admin_lang('buttons'), 'value' => $this->get_option('homepage', 'buttonsstatus'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'radio', 'id' => 'homepage[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('homepage', 'style'), 'options' => [
                    'bgdark'   => admin_lang('dark'),
                    'bgimage'   => admin_lang('image'),
                    'bgvideo'   => admin_lang('video'),
                ]],
                ['type' => 'radio', 'id' => 'homepage[particles]', 'name' => admin_lang('particles'), 'value' => $this->get_option('homepage', 'particles'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'upload', 'id' => 'homepage[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('homepage', 'bgimage'), 'src' => 'src', 'library' => 'image'],
                ['type' => 'text', 'id' => 'homepage[bgvideo]', 'name' => admin_lang('youtube_video_url'), 'value' => $this->get_option('homepage', 'bgvideo')],            
            ]
        ];
        $data['settings']['homepage']['homepage_typed'] = [
            'title'     => admin_lang('homepage_typed'),
            'options'   => [
                ['type' => 'text', 'id' => 'homepage[typedtitle]', 'name' => admin_lang('title'), 'value' => $this->get_option('homepage', 'typedtitle')],
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.repeater_homepage_typed', ['homepage_typed' => $this->get_option('homepage', 'typed'), 'input_name' => 'homepage[typed]'])->render()],
            ]
        ];
        $data['settings']['homepage']['buttons'] = [
            'title'     => admin_lang('buttons'),
            'options'   => [
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.repeater_homepage_buttons', ['homepage_buttons' => $this->get_option('homepage', 'buttons'), 'widgets' => $this->widgets_default(), 'input_name' => 'homepage[buttons]'])->render()],
            ]
        ];
        


        /**
         * aboutme
         */
        $data['settings']['aboutme']['aboutme'] = [
            'title'     => admin_lang('aboutme'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'page_title')],
                ['type' => 'text', 'id' => 'aboutme[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'aboutme[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('aboutme', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'aboutme[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('aboutme', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['aboutme']['whoam'] = [
            'title'     => admin_lang('whoam'),
            'options'   => [
                ['type' => 'upload', 'id' => 'aboutme[avatar]', 'name' => admin_lang('profile_picture'), 'value' => $this->get_option('aboutme', 'avatar'), 'src' => 'src', 'library' => 'image'],
                ['type' => 'text', 'id' => 'aboutme[about_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'about_title')],
                ['type' => 'text', 'id' => 'aboutme[nationality]', 'name' => admin_lang('nationality'), 'value' => $this->get_option('aboutme', 'nationality')],
                ['type' => 'textarea', 'id' => 'aboutme[whoam]', 'name' => admin_lang('whoam'), 'value' => $this->get_option('aboutme', 'whoam'), 'rows' => '8'],
            ]
        ];
        $data['settings']['aboutme']['video'] = [
            'title'     => admin_lang('video'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[video_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'video_title')],
                ['type' => 'text', 'id' => 'aboutme[video_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'video_subtitle')],
                ['type' => 'upload', 'id' => 'aboutme[video_bgimage]', 'name' => admin_lang('background'), 'value' => $this->get_option('aboutme', 'video_bgimage'), 'src' => 'src', 'library' => 'image'],
                ['type' => 'text', 'id' => 'aboutme[video_url]', 'name' => admin_lang('url'), 'value' => $this->get_option('aboutme', 'video_url')],    
            ]
        ];
        $data['settings']['aboutme']['services'] = [
            'title'     => admin_lang('services'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[services_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'services_title')],
                ['type' => 'text', 'id' => 'aboutme[services_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'services_subtitle')],
                ['type' => 'radio', 'id' => 'aboutme[services_columns]', 'name' => admin_lang('columns'), 'value' => $this->get_option('aboutme', 'services_column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
            ]
        ];
        $data['settings']['aboutme']['workingway'] = [
            'title'     => admin_lang('workingway'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[workingway_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'workingway_title')],
                ['type' => 'text', 'id' => 'aboutme[workingway_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'workingway_subtitle')],
                ['type' => 'radio', 'id' => 'aboutme[workingway_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('aboutme', 'workingway_column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
            ]
        ];
        $data['settings']['aboutme']['testimonials'] = [
            'title'     => admin_lang('testimonials'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[testimonials_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'testimonials_title')],
                ['type' => 'text', 'id' => 'aboutme[testimonials_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'testimonials_subtitle')],
                ['type' => 'radio', 'id' => 'aboutme[testimonials_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('aboutme', 'testimonials_column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('style'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'radio', 'id' => 'aboutme[testimonials_style]', 'value' => $this->get_option('aboutme', 'testimonials_style'), 'options' => [
                        'normal' => admin_lang('normal'),
                        'owlcarousel' => 'Owl Carousel',
                    ]],
                    ['type' => 'slider_number', 'id' => 'aboutme[testimonials_owlrespc]', 'name' => 'Owl Responsive <i class="fas fa-laptop"></i>', 'value' => $this->get_option('aboutme', 'testimonials_owlrespc', '3'), 'min' => '1', 'max' => '4', 'step' => '1'],
                    ['type' => 'slider_number', 'id' => 'aboutme[testimonials_owlrestablet]', 'name' => 'Owl Responsive <i class="fas fa-tablet-alt"></i>', 'value' => $this->get_option('aboutme', 'testimonials_owlrestablet', '2'), 'min' => '1', 'max' => '4', 'step' => '1'],
                    ['type' => 'slider_number', 'id' => 'aboutme[testimonials_owlresphone]', 'name' => 'Owl Responsive <i class="fas fa-mobile-alt"></i>', 'value' => $this->get_option('aboutme', 'testimonials_owlresphone', '1'), 'min' => '1', 'max' => '4', 'step' => '1'],
                ]],
                
            ]
        ];
        $data['settings']['aboutme']['clients'] = [
            'title'     => admin_lang('clients'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[clients_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'clients_title')],
                ['type' => 'text', 'id' => 'aboutme[clients_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'clients_subtitle')],
                ['type' => 'radio', 'id' => 'aboutme[clients_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('aboutme', 'clients_column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('style'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'radio', 'id' => 'aboutme[clients_style]', 'value' => $this->get_option('aboutme', 'clients_style'), 'options' => [
                        'normal' => admin_lang('normal'),
                        'owlcarousel' => 'Owl Carousel',
                    ]],
                    ['type' => 'slider_number', 'id' => 'aboutme[clients_owlrespc]', 'name' => 'Owl Responsive <i class="fas fa-laptop"></i>', 'value' => $this->get_option('aboutme', 'clients_owlrespc', '3'), 'min' => '1', 'max' => '6', 'step' => '1'],
                    ['type' => 'slider_number', 'id' => 'aboutme[clients_owlrestablet]', 'name' => 'Owl Responsive <i class="fas fa-tablet-alt"></i>', 'value' => $this->get_option('aboutme', 'clients_owlrestablet', '2'), 'min' => '1', 'max' => '4', 'step' => '1'],
                    ['type' => 'slider_number', 'id' => 'aboutme[clients_owlresphone]', 'name' => 'Owl Responsive <i class="fas fa-mobile-alt"></i>', 'value' => $this->get_option('aboutme', 'clients_owlresphone', '1'), 'min' => '1', 'max' => '4', 'step' => '1'],
                ]],
                
            ]
        ];
        $data['settings']['aboutme']['funfacts'] = [
            'title'     => admin_lang('funfacts'),
            'options'   => [
                ['type' => 'text', 'id' => 'aboutme[funfacts_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('aboutme', 'funfacts_title')],
                ['type' => 'text', 'id' => 'aboutme[funfacts_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('aboutme', 'funfacts_subtitle')],
                ['type' => 'radio', 'id' => 'aboutme[funfacts_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('aboutme', 'funfacts_column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
            ]
        ];
        $data['settings']['aboutme']['page_design'] = [
            'title'     => admin_lang('page_design'),
            'options'   => [
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.pagedesign', ['pagedesign' => $this->get_option('aboutme', 'pagedesign'), 'input_name' => 'aboutme[pagedesign]'])->render()],
            ]
        ];

        /**
         * resume
         */
        $data['settings']['resume']['resume'] = [
            'title'     => admin_lang('resume'),
            'options'   => [
                ['type' => 'text', 'id' => 'resume[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('resume', 'page_title')],
                ['type' => 'text', 'id' => 'resume[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('resume', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'resume[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('resume', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'resume[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('resume', 'bgimage'), 'src' => 'src', 'library' => 'image'],
                ['type' => 'fields_groups', 'name' => admin_lang('download'), 'options' => [
                    ['type' => 'radio', 'id' => 'resume[download_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('resume', 'download_status', '1'), 'options' => [
                        '1' => admin_lang('on'),
                        '0' => admin_lang('off')
                    ]],
                    ['type' => 'fonticon', 'id' => 'resume[download_icon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('resume', 'download_icon', 'lnr lnr-cloud-download')],
                    ['type' => 'upload', 'id' => 'resume[download_url]', 'name' => admin_lang('file'), 'value' => $this->get_option('resume', 'download_url'), 'src' => 'src', 'library' => 'files'],
                ]],
            ]
        ];
        $data['settings']['resume']['education'] = [
            'title'     => admin_lang('education'),
            'options'   => [
                ['type' => 'text', 'id' => 'resume[education_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('resume', 'education_title')],
                ['type' => 'text', 'id' => 'resume[education_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('resume', 'education_subtitle')],
            ]
        ];
        $data['settings']['resume']['experience'] = [
            'title'     => admin_lang('experience'),
            'options'   => [
                ['type' => 'text', 'id' => 'resume[experience_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('resume', 'experience_title')],
                ['type' => 'text', 'id' => 'resume[experience_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('resume', 'experience_subtitle')],
            ]
        ];
        $data['settings']['resume']['page_design'] = [
            'title'     => admin_lang('page_design'),
            'options'   => [
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.pagedesign', ['pagedesign' => $this->get_option('resume', 'pagedesign'), 'input_name' => 'resume[pagedesign]'])->render()],
            ]
        ];


        /**
         * blog
         * default
         */
        $data['settings']['blog']['blog'] = [
            'title'     => admin_lang('blog'),
            'options'   => [
                ['type' => 'text', 'id' => 'blog[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('blog', 'page_title')],
                ['type' => 'text', 'id' => 'blog[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('blog', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'blog[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('blog', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'blog[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('blog', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['blog']['blog_page'] = [
            'title'     => admin_lang('blog_page'),
            'options'   => [
                ['type' => 'text', 'id' => 'blog[blog_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('blog', 'blog_title')],
                ['type' => 'text', 'id' => 'blog[blog_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('blog', 'blog_subtitle')],
                ['type' => 'radio', 'id' => 'blog[breadcrumbs]', 'name' => admin_lang('breadcrumbs'), 'value' => $this->get_option('blog', 'breadcrumbs'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'slider_number', 'id' => 'blog[per_page]', 'name' => admin_lang('post_per_page'), 'value' => $this->get_option('blog', 'per_page'), 'min' => '0', 'max' => '24', 'step' => '1'],
                ['type' => 'radio', 'id' => 'blog[post_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('blog', 'post_column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('widgets'), 'options' => [
                    ['type' => 'radio', 'id' => 'blog[widgets]', 'name' => admin_lang('direction'), 'value' => $this->get_option('blog', 'widgets'), 'options' => [
                        'left' => admin_lang('left'),
                        'right' => admin_lang('right'),
                        'off' => admin_lang('off')
                    ]],
                    ['type' => 'radio', 'id' => 'blog[widgets_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('blog', 'widgets_column'), 'options' => [
                        'col-lg-3' => ['img' => asset('images/options/col3.png')],
                        'col-lg-4' => ['img' => asset('images/options/col4.png')],
                    ]]
                ]],
            ]
        ];
        $data['settings']['blog']['single_post'] = [
            'title'     => admin_lang('single_post'),
            'options'   => [
                ['type' => 'radio', 'id' => 'blog[post_breadcrumbs]', 'name' => admin_lang('breadcrumbs'), 'value' => $this->get_option('blog', 'post_breadcrumbs'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('widgets'), 'options' => [
                    ['type' => 'radio', 'id' => 'blog[post_widgets]', 'name' => admin_lang('direction'), 'value' => $this->get_option('blog', 'post_widgets'), 'options' => [
                        'left' => admin_lang('left'),
                        'right' => admin_lang('right'),
                        'off' => admin_lang('off')
                    ]],
                    ['type' => 'radio', 'id' => 'blog[post_widgets_column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('blog', 'post_widgets_column'), 'options' => [
                        'col-lg-3' => ['img' => asset('images/options/col3.png')],
                        'col-lg-4' => ['img' => asset('images/options/col4.png')],
                    ]],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('sharelink'), 'options' => [
                    ['type' => 'radio', 'id' => 'blog[sharelink_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('blog', 'sharelink_status'), 'options' => [
                        '1' => admin_lang('on'),
                        '0' => admin_lang('off')
                    ]],
                    ['type' => 'html', 'html' => get_admin_view('settings.repeater.repeater_sharelink', ['sharelink' => $this->get_option('blog', 'sharelink'), 'input_name' => 'blog[sharelink]'])->render()]
                ]],
                ['type' => 'checkbox_group','name' => admin_lang('meta'), 'options' => [
                    ['id' => 'blog[post_meta_author]', 'name' => admin_lang('author'), 'value' => $this->get_option('blog', 'post_meta_author')],
                    ['id' => 'blog[post_meta_date]', 'name' => admin_lang('date'), 'value' => $this->get_option('blog', 'post_meta_date')],
                    ['id' => 'blog[post_meta_views]', 'name' => admin_lang('views'), 'value' => $this->get_option('blog', 'post_meta_views')],
                    ['id' => 'blog[post_meta_cate]', 'name' => admin_lang('category'), 'value' => $this->get_option('blog', 'post_meta_cate')],
                    ['id' => 'blog[post_meta_tags]', 'name' => admin_lang('tags'), 'value' => $this->get_option('blog', 'post_meta_tags')],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('related_posts'), 'options' => [
                    ['type' => 'radio', 'id' => 'blog[related_posts]', 'name' => admin_lang('status'), 'value' => $this->get_option('blog', 'related_posts'), 'options' => [
                        '1' => admin_lang('on'),
                        '0' => admin_lang('off')
                    ]],
                    ['type' => 'text', 'id' => 'blog[related_posts_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('blog', 'related_posts_title')],
                    ['type' => 'slider_number', 'id' => 'blog[related_posts_per_page]', 'name' => admin_lang('post_per_page'), 'value' => $this->get_option('blog', 'related_posts_per_page'), 'min' => '0', 'max' => '24', 'step' => '1']
                ]],
            ]
        ];
        $data['settings']['blog']['widgets'] = [
            'title'     => admin_lang('widgets'),
            'options'   => [
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.repeater_widgets', ['widgets' => $this->get_option('blog', 'widgets_blog'), 'input_name' => 'blog[widgets_blog]'])->render()],
                ['type' => 'html', 'html' => '<br />'],
                ['type' => 'slider_number', 'id' => 'blog[recent_per_page]', 'name' => admin_lang('recent_posts_per_page'), 'value' => $this->get_option('blog', 'recent_per_page'), 'min' => '0', 'max' => '12', 'step' => '1'],
                ['type' => 'slider_number', 'id' => 'blog[popular_per_page]', 'name' => admin_lang('popular_posts_per_page'), 'value' => $this->get_option('blog', 'popular_per_page'), 'min' => '0', 'max' => '12', 'step' => '1']
            ]
        ];

        /**
         * portfolio
         * default
         */
        $data['settings']['portfolio']['portfolio'] = [
            'title'     => admin_lang('portfolio'),
            'options'   => [
                ['type' => 'text', 'id' => 'portfolio[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('portfolio', 'page_title')],
                ['type' => 'text', 'id' => 'portfolio[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('portfolio', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'portfolio[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('portfolio', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'portfolio[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('portfolio', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['portfolio']['single_project'] = [
            'title'     => admin_lang('single_project'),
            'options'   => [
                ['type' => 'radio', 'id' => 'portfolio[breadcrumbs]', 'name' => admin_lang('breadcrumbs'), 'value' => $this->get_option('portfolio', 'breadcrumbs'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('sharelink'), 'options' => [
                    ['type' => 'radio', 'id' => 'portfolio[sharelink_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('portfolio', 'sharelink_status'), 'options' => [
                        '1' => admin_lang('on'),
                        '0' => admin_lang('off')
                    ]],
                    ['type' => 'html', 'html' => get_admin_view('settings.repeater.repeater_sharelink', ['sharelink' => $this->get_option('portfolio', 'sharelink'), 'input_name' => 'portfolio[sharelink]'])->render()]
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('related_posts'), 'options' => [
                    ['type' => 'radio', 'id' => 'portfolio[related_posts]', 'name' => admin_lang('status'), 'value' => $this->get_option('portfolio', 'related_posts'), 'options' => [
                        '1' => admin_lang('on'),
                        '0' => admin_lang('off')
                    ]],
                    ['type' => 'text', 'id' => 'portfolio[related_posts_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('portfolio', 'related_posts_title')],
                    ['type' => 'slider_number', 'id' => 'portfolio[related_posts_per_page]', 'name' => admin_lang('post_per_page'), 'value' => $this->get_option('portfolio', 'related_posts_per_page'), 'min' => '0', 'max' => '24', 'step' => '1']
                ]],
            ]
        ];

        /**
         * contact me
         * default
         */
        $data['settings']['contactme']['contactus'] = [
            'title'     => admin_lang('contactus'),
            'options'   => [
                ['type' => 'text', 'id' => 'contactme[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('contactme', 'page_title')],
                ['type' => 'text', 'id' => 'contactme[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('contactme', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'contactme[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('contactme', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'contactme[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('contactme', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['contactme']['google_map'] = [
            'title'     => admin_lang('google_map'),
            'options'   => [
                ['type' => 'radio', 'id' => 'contactme[mapstatus]', 'name' => admin_lang('status'), 'value' => $this->get_option('contactme', 'mapstatus'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'input_group', 'name' => admin_lang('location'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'contactme[maplatitude]', 'name' => admin_lang('latitude'), 'value' => $this->get_option('contactme', 'maplatitude'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'contactme[maplongitude]', 'name' => admin_lang('longitude'), 'value' => $this->get_option('contactme', 'maplongitude'), 'box_class' => 'megapanel-field'],
                ]],
                ['type' => 'slider_number', 'id' => 'contactme[mapzoom]', 'name' => admin_lang('map_zoom'), 'value' => $this->get_option('contactme', 'mapzoom'), 'min' => '0', 'max' => '18', 'step' => '1'],
                ['type' => 'upload', 'id' => 'contactme[mapmarker]', 'name' => admin_lang('map_marker'), 'value' => $this->get_option('contactme', 'mapmarker'), 'src' => 'src'],
            ]
        ];
        $data['settings']['contactme']['contact_information'] = [
            'title'     => admin_lang('contact_information'),
            'options'   => [
                ['type' => 'text', 'id' => 'contactme[information_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('contactme', 'information_title')],
                ['type' => 'text', 'id' => 'contactme[information_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('contactme', 'information_subtitle')],
                ['type' => 'text', 'id' => 'contactme[address]', 'name' => admin_lang('address'), 'value' => $this->get_option('contactme', 'address')],
                ['type' => 'input_group', 'name' => admin_lang('phone'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'contactme[phone]', 'name' => admin_lang('phone1'), 'value' => $this->get_option('contactme', 'phone'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'contactme[phone2]', 'name' => admin_lang('phone2'), 'value' => $this->get_option('contactme', 'phone2'), 'box_class' => 'megapanel-field'],
                ]],
                ['type' => 'input_group', 'name' => admin_lang('email'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'contactme[email]', 'name' => admin_lang('email1'), 'value' => $this->get_option('contactme', 'email'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'contactme[email2]', 'name' => admin_lang('email2'), 'value' => $this->get_option('contactme', 'email2'), 'box_class' => 'megapanel-field']
                ]],
            ]
        ];
        $data['settings']['contactme']['form'] = [
            'title'     => admin_lang('form'),
            'options'   => [
                ['type' => 'text', 'id' => 'contactme[form_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('contactme', 'form_title')],
                ['type' => 'text', 'id' => 'contactme[form_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('contactme', 'form_subtitle')],
                ['type' => 'radio', 'id' => 'contactme[send]', 'name' => admin_lang('send_contact'), 'value' => $this->get_option('contactme', 'send'), 'options' => [
                    'database' => admin_lang('database'),
                    'email' => admin_lang('email'),
                    'both' => admin_lang('both')
                ]],
            ]
        ];
        $data['settings']['contactme']['socials'] = [
            'title'     => admin_lang('socials'),
            'options'   => [
                ['type' => 'text', 'id' => 'contactme[socials_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('contactme', 'socials_title')],
                ['type' => 'text', 'id' => 'contactme[socials_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('contactme', 'socials_subtitle')],
                ['type' => 'radio', 'id' => 'contactme[socials_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('contactme', 'socials_status', 'size-md'), 'options' => [
                    'size-lg'  => admin_lang('large_size'),
                    'size-md'  => admin_lang('medium_size'),
                    'size-sm'  => admin_lang('small_size'),
                    'off'        => admin_lang('off'),
                ]],
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.repeater_socials', ['socials' => $this->get_option('contactme', 'socials'), 'input_name' => 'contactme[socials]'])->render()],
            ]
        ];

        /**
         * Appointments
         * default
         */
        $data['settings']['appointments']['appointments'] = [
            'title'     => admin_lang('appointments'),
            'options'   => [
                ['type' => 'text', 'id' => 'appointments[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('appointments', 'page_title')],
                ['type' => 'text', 'id' => 'appointments[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('appointments', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'appointments[send]', 'name' => admin_lang('send'), 'value' => $this->get_option('appointments', 'send'), 'options' => [
                    'database' => admin_lang('database'),
                    'email' => admin_lang('email'),
                    'both' => admin_lang('both')
                ]],
                ['type' => 'radio', 'id' => 'appointments[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('appointments', 'style', '0'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'appointments[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('appointments', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['appointments']['my_appointments'] = [
            'title'     => admin_lang('my_appointments'),
            'options'   => [
                ['type' => 'radio', 'id' => 'appointments[mastatus]', 'name' => admin_lang('status'), 'value' => $this->get_option('appointments', 'mastatus', '1'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'text', 'id' => 'appointments[matitle]', 'name' => admin_lang('title'), 'value' => $this->get_option('appointments', 'matitle')],
                ['type' => 'text', 'id' => 'appointments[masubtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('appointments', 'masubtitle')],
                ['type' => 'html', 'html' => get_admin_view('settings.repeater.my_appointments', ['appointments_work' => $this->get_option('appointments', 'works'), 'input_name' => 'appointments[works]'])->render()]
            ]
        ];

        /**
         * Pricings
         * default
         */
        $data['settings']['pricings']['pricings'] = [
            'title'     => admin_lang('pricings'),
            'options'   => [
                ['type' => 'text', 'id' => 'pricings[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('pricings', 'page_title')],
                ['type' => 'text', 'id' => 'pricings[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('pricings', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'pricings[template]', 'name' => admin_lang('style'), 'value' => $this->get_option('pricings', 'template'), 'options' => [
                    'style1' => admin_lang('style_1'),
                    'style2' => admin_lang('style_2')
                ]],
                ['type' => 'radio', 'id' => 'pricings[column]', 'name' => admin_lang('columns'), 'value' => $this->get_option('pricings', 'column'), 'options' => [
                    'col-lg-6' => ['img' => asset('images/options/2col.png')],
                    'col-lg-4' => ['img' => asset('images/options/3col.png')],
                    'col-lg-3' => ['img' => asset('images/options/4col.png')],
                ]],
                ['type' => 'radio', 'id' => 'pricings[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('pricings', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'pricings[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('pricings', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];

        /**
         * support
         */
        $data['settings']['support']['support'] = [
            'title'     => admin_lang('support'),
            'options'   => [
                ['type' => 'text', 'id' => 'support[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('support', 'page_title')],
                ['type' => 'text', 'id' => 'support[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('support', 'page_subtitle')],
                ['type' => 'radio', 'id' => 'support[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('support', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'support[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('support', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['support']['faqs'] = [
            'title'     => admin_lang('faqs'),
            'options'   => [
                ['type' => 'radio', 'id' => 'faqs[status]', 'name' => admin_lang('status'), 'value' => $this->get_option('faqs', 'status', '1'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'text', 'id' => 'faqs[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('faqs', 'page_title')],
                ['type' => 'text', 'id' => 'faqs[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('faqs', 'page_subtitle')],
                ['type' => 'fonticon', 'id' => 'faqs[icon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('faqs', 'icon')],
                ['type' => 'radio', 'id' => 'faqs[column]', 'name' => admin_lang('column'), 'value' => $this->get_option('faqs', 'column'), 'options' => [
                    '1column' => ['img' => asset('images/options/1col.png')],
                    '2column' => ['img' => asset('images/options/2col.png')]
                ]],
                ['type' => 'radio', 'id' => 'faqs[style]', 'name' => admin_lang('background'), 'value' => $this->get_option('faqs', 'style'), 'options' => [
                    'bgimage' => admin_lang('image'),
                    'bgdark'   => admin_lang('dark'),
                    'normal' => admin_lang('normal')
                ]],
                ['type' => 'upload', 'id' => 'faqs[bgimage]', 'name' => admin_lang('image'), 'value' => $this->get_option('faqs', 'bgimage'), 'src' => 'src', 'library' => 'image'],
            ]
        ];
        $data['settings']['support']['tickets'] = [
            'title'     => admin_lang('tickets'),
            'options'   => [
                ['type' => 'radio', 'id' => 'tickets[status]', 'name' => admin_lang('status'), 'value' => $this->get_option('tickets', 'status', '1'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'text', 'id' => 'tickets[page_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('tickets', 'page_title')],
                ['type' => 'text', 'id' => 'tickets[page_subtitle]', 'name' => admin_lang('sub_title'), 'value' => $this->get_option('tickets', 'page_subtitle')],
                ['type' => 'text', 'id' => 'tickets[url]', 'name' => admin_lang('url'), 'value' => $this->get_option('tickets', 'url')],
                ['type' => 'fonticon', 'id' => 'tickets[icon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('tickets', 'icon')],
            ]
        ];
        $data['settings']['support']['email_support'] = [
            'title'     => admin_lang('email_support'),
            'options'   => [
                ['type' => 'radio', 'id' => 'support[email_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('support', 'email_status', '1'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'text', 'id' => 'support[email_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('support', 'email_title')],
                ['type' => 'fonticon', 'id' => 'support[emailicon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('support', 'emailicon')],
                ['type' => 'input_group', 'name' => admin_lang('email'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'support[email_text]', 'name' => admin_lang('label'), 'value' => $this->get_option('support', 'email_text'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'support[email_email]', 'name' => admin_lang('email'), 'value' => $this->get_option('support', 'email_email'), 'box_class' => 'megapanel-field'],
                ]],
                ['type' => 'input_group', 'name' => admin_lang('email2'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'support[email2_text]', 'name' => admin_lang('label'), 'value' => $this->get_option('support', 'email2_text'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'support[email2_email]', 'name' => admin_lang('email'), 'value' => $this->get_option('support', 'email2_email'), 'box_class' => 'megapanel-field'],
                ]],
            ]
        ];
        $data['settings']['support']['phone_support'] = [
            'title'     => admin_lang('phone_support'),
            'options'   => [
                ['type' => 'radio', 'id' => 'support[phone_status]', 'name' => admin_lang('status'), 'value' => $this->get_option('support', 'phone_status', '1'), 'options' => [
                    '1' => admin_lang('on'),
                    '0' => admin_lang('off')
                ]],
                ['type' => 'text', 'id' => 'support[phone_title]', 'name' => admin_lang('title'), 'value' => $this->get_option('support', 'phone_title')],
                ['type' => 'fonticon', 'id' => 'support[phoneicon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('support', 'phoneicon')],
                ['type' => 'input_group', 'name' => admin_lang('phone'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'support[phone_text]', 'name' => admin_lang('label'), 'value' => $this->get_option('support', 'phone_text'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'support[phone_number]', 'name' => admin_lang('phone'), 'value' => $this->get_option('support', 'phone_number'), 'box_class' => 'megapanel-field'],
                ]],
                ['type' => 'input_group', 'name' => admin_lang('phone2'), 'box_class2' => 'd-flex', 'options' => [
                    ['type' => 'text', 'id' => 'support[phone2_text]', 'name' => admin_lang('label'), 'value' => $this->get_option('support', 'phone2_text'), 'box_class' => 'megapanel-field'],
                    ['type' => 'text', 'id' => 'support[phone2_number]', 'name' => admin_lang('phone'), 'value' => $this->get_option('support', 'phone2_number'), 'box_class' => 'megapanel-field'],
                ]],
            ]
        ];

        /**
         * style
         * default
         */
        $data['settings']['style']['style'] = [
            'title'     => admin_lang('style'),
            'options'   => [
                ['type' => 'radio', 'id' => 'style[template]', 'name' => admin_lang('template'), 'value' => $this->get_option('style', 'template'), 'options' => [
                    'onepage' => admin_lang('one_page'),
                    'multipage' => admin_lang('multi_page')
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('breadcrumbs'), 'options' => [
                    ['type' => 'radio', 'id' => 'style[breadcrumbs]', 'name' => admin_lang('breadcrumbs'), 'value' => $this->get_option('style', 'breadcrumbs'), 'options' => [
                        'style1' => admin_lang('style_1'),
                        'style2' => admin_lang('style_2'),
                    ]],
                    ['type' => 'fonticon', 'id' => 'style[breadhomeicon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('style', 'breadhomeicon')],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('gotoup'), 'options' => [
                    ['type' => 'radio', 'id' => 'style[gotoup]', 'name' => admin_lang('status'), 'value' => $this->get_option('style', 'gotoup'), 'options' => [
                        '1'  => admin_lang('on'),
                        '0' => admin_lang('off'),
                    ]],
                    ['type' => 'fonticon', 'id' => 'style[gotoupicon]', 'name' => admin_lang('icon'), 'value' => $this->get_option('style', 'gotoupicon')],
                ]],
                ['type' => 'fields_groups', 'name' => admin_lang('page_loaded'), 'options' => [
                    ['type' => 'radio', 'id' => 'style[pageloaded]', 'name' => admin_lang('status'), 'value' => $this->get_option('style', 'pageloaded'), 'options' => [
                        '1'  => admin_lang('on'),
                        '0' => admin_lang('off'),
                    ]],
                    ['type' => 'radio', 'id' => 'style[pageloadedstyle]', 'name' => admin_lang('style'), 'value' => $this->get_option('style', 'pageloadedstyle'), 'options' => [
                        'style1' => admin_lang('style_1'),
                        'style2' => admin_lang('style_2'),
                        'style3' => admin_lang('style_3'),
                    ]]
                ]],
                ['type' => 'upload', 'id' => 'style[favicon]', 'name' => admin_lang('favicon'), 'value' => $this->get_option('style', 'favicon'), 'src' => 'src'],
                ['type' => 'select', 'id' => 'style[fontfamily]', 'name' => admin_lang('font_family'), 'value' => $this->get_option('style', 'fontfamily'), 'options' => $font_family, 'class' => 'select2'],
                ['type' => 'radio', 'id' => 'style[darkmode]', 'name' => admin_lang('dark_mode'), 'value' => $this->get_option('style', 'darkmode'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'skinscolor_free', 'options' => $skinscolor_options, 'id' => 'style[skinscolor]', 'name' => admin_lang('layout_color'), 'value' => $this->get_option('style', 'skinscolor')],
                ['type' => 'select_animate', 'id' => 'style[pagesanimate]', 'name' => admin_lang('animate'), 'value' => $this->get_option('style', 'pagesanimate')],
            ]
        ];
        $data['settings']['style']['customcss'] = [
            'title'     => admin_lang('customcss'),
            'options'   => [
                ['type' => 'code_editor', 'id' => 'style[customcss]', 'name' => admin_lang('customcss'),  'value' => $this->get_option('style', 'customcss', '')],
            ]
        ];
        $data['settings']['style']['customjs'] = [
            'title'     => admin_lang('customjs'),
            'options'   => [
                ['type' => 'code_editor', 'id' => 'style[customjs]', 'name' => admin_lang('customjs'),  'value' => $this->get_option('style', 'customjs', '')],
            ]
        ];

        /**
         * SEO
         * default
         */
        $data['settings']['seo']['seo'] = [
            'title'     => admin_lang('seo'),
            'options'   => [
                ['type' => 'radio', 'id' => 'seo[status]', 'name' => admin_lang('status'), 'value' => $this->get_option('seo', 'status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'text', 'id' => 'seo[robots]', 'name' => admin_lang('meta_robots'), 'value' => $this->get_option('seo', 'robots')],
                ['type' => 'text', 'id' => 'seo[twitter]', 'name' => admin_lang('meta_twitter'), 'value' => $this->get_option('seo', 'twitter')],
                ['type' => 'textarea', 'id' => 'seo[description]', 'name' => admin_lang('meta_description'), 'value' => $this->get_option('seo', 'description'), 'rows' => '6'],
                ['type' => 'textarea', 'id' => 'seo[keywords]', 'name' => admin_lang('meta_keywords'), 'value' => $this->get_option('seo', 'keywords'), 'rows' => '6'],   
            ]
        ];

        /**
         * Cookie
         * default
         */
        $data['settings']['cookie']['cookie'] = [
            'title'     => admin_lang('cookie'),
            'options'   => [
                ['type' => 'radio', 'id' => 'cookie[status]', 'name' => admin_lang('status'), 'value' => $this->get_option('cookie', 'status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'text', 'id' => 'cookie[id]', 'name' => 'ID', 'value' => $this->get_option('cookie', 'id')],
                ['type' => 'radio', 'id' => 'cookie[position]', 'name' => admin_lang('direction'), 'value' => $this->get_option('cookie', 'position'), 'options' => [
                    'left'  => admin_lang('left'),
                    'right' => admin_lang('right')
                ]],
                ['type' => 'upload', 'id' => 'cookie[image]', 'name' => admin_lang('image'), 'value' => $this->get_option('cookie', 'image') , 'src' => 'src'], 
                ['type' => 'text', 'id' => 'cookie[title]', 'name' => admin_lang('title'), 'value' => $this->get_option('cookie', 'title')],
                ['type' => 'textarea', 'id' => 'cookie[desc]', 'name' => admin_lang('description'),  'value' => $this->get_option('cookie', 'desc')],
                ['type' => 'text', 'id' => 'cookie[decline]', 'name' => admin_lang('decline'), 'value' => $this->get_option('cookie', 'decline')],
                ['type' => 'text', 'id' => 'cookie[consent]', 'name' => admin_lang('consent'), 'value' => $this->get_option('cookie', 'consent')],
                ['type' => 'radio', 'id' => 'cookie[style]', 'name' => admin_lang('style'), 'value' => $this->get_option('cookie', 'style'), 'options' => [
                    'style1' => ['label' => admin_lang('style_1'), 'img' => asset('images/options/cookie1.png')],
                    'style2' => ['label' => admin_lang('style_2'), 'img' => asset('images/options/cookie2.png')],
                    'style3' => ['label' => admin_lang('style_3'), 'img' => asset('images/options/cookie3.png')],
                ]],
            ]
        ];

        /**
         * Maintenance
         * default
         */
        $data['settings']['maintenance']['maintenance'] = [
            'title'     => admin_lang('maintenance'),
            'options'   => [
                ['type' => 'radio', 'id' => 'maintenance[status]', 'name' => admin_lang('status'), 'value' => $this->get_option('maintenance', 'status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                
                ['type' => 'upload', 'id' => 'maintenance[bgimage]', 'name' => admin_lang('background'), 'value' => $this->get_option('maintenance', 'bgimage'), 'src' => 'src'],
                ['type' => 'text', 'id' => 'maintenance[title]', 'name' => admin_lang('title'), 'value' => $this->get_option('maintenance', 'title')],
                ['type' => 'textarea', 'id' => 'maintenance[message]', 'name' => admin_lang('message'), 'value' => $this->get_option('maintenance', 'message'), 'rows' => '6'],
                ['type' => 'radio', 'id' => 'maintenance[timer_status]', 'name' => admin_lang('maintenance_timer_status'), 'value' => $this->get_option('maintenance', 'timer_status'), 'options' => [
                    '1'  => admin_lang('on'),
                    '0' => admin_lang('off'),
                ]],
                ['type' => 'date', 'id' => 'maintenance[date]', 'name' => admin_lang('date'), 'value' => $this->get_option('maintenance', 'date'), 'format' => 'dd-mm-yyyy'],
            ]
        ];

        /**
         * Backup
         */
        $data['settings']['backup']['export'] = [
            'title'     => admin_lang('export'),
            'options'   => [
               ['type' => 'textarea_full', 'id' => '', 'rows' => '15',  'value' => $this->get_backup_export()],
               ['type' => 'link', 'class' => 'btn btn-primary', 'url' => get_admin_url('settings?backupexport'), 'text' => admin_lang('download'), 'align' => 'border-0']
            ]
        ];
        $data['settings']['backup']['import'] = [
            'title'     => admin_lang('import'),
            'options'   => [
               ['type' => 'textarea_full', 'id' => 'backup_import', 'rows' => '15',  'setid' => 'backup_import', 'value' => ''],
               ['type' => 'button', 'confirm' => admin_lang('confirm_backup_import'), 'button' => 'submit', 'class' => 'btn btn-primary', 'name' => 'import', 'value' => 'import', 'text' => admin_lang('import'), 'align' => 'border-0']
            ]
        ];
        
        return get_admin_view('settings.settings', $data);
    }

    /**
     * settings_sendform
     */
    public function settings_sendform(Request $request)
    {
        // import
        if($request->has('import') and $request->get('import') == 'import'){
            $import = $request->get('backup_import');
            if(is_serialized($import)){
                /*
                $import_data = maybe_unserialize($import);
                foreach($import_data as $key => $value){
                    $value = str_replace('{:$url:}', url('/'), $value);
                    if(is_array($value)){
                        update_option($key, maybe_serialize($value));
                    }
                    else {
                        update_option($key, $value);
                    }
                }
                */
                return redirect()->back()->with("success", admin_lang('settings_import_successfully'));
            }
            else {
                return redirect()->back()->with("warning", admin_lang('warning_backup_import'));
            }
        }
        else {
            /*
            $option_none = ['backup_import', '_token'];
            foreach($request->all() as $key => $value){
                if(!in_array($key, $option_none)){
                    if(is_array($value)){
                        update_option($key, maybe_serialize($value));
                    }
                    else {
                        update_option($key, $value);
                    }
                }
            }
            */
            return redirect()->back()->with("success", admin_lang('settings_saved_successfully'));
        }        
    }

    /**
     * get_repeater_sidebar_menu
     */
    public function get_repeater_sidebar_menu()
    {
        $sidebar_menu           = maybe_unserialize(get_option('sidebar_menu'));
        $data['sidebar_menu']   = (is_array($sidebar_menu))? $sidebar_menu : default_options('sidebar_menu');
        $data['widgets_home']   = $this->widgets_default();
        return get_admin_view('settings.repeater.sidebar_menu', $data)->render();
    }

    /**
     * widgets_default
     */
    public function widgets_default()
    {
        $widgets_default = [
            'home'          => admin_lang('home'),
            'aboutme'       => admin_lang('aboutme'),
            'resume'        => admin_lang('resume'),
            'portfolio'     => admin_lang('portfolio'),
            'blog'          => admin_lang('blog'),
            'contactme'     => admin_lang('contactme'),
            'pricings'      => admin_lang('pricings'),
            'support'       => admin_lang('support'),
            'appointments'  => admin_lang('appointments'),
            'faqs'          => admin_lang('faqs')
        ];


        $pages = $this->get_posts_query('pages')->orderBy('post_title', 'ASC')->get();

        foreach($pages as $page){
            $widgets_default['page:'.$page->post_id] = $page->post_title;
        }

        return $widgets_default;
    }

    /**
     * get_option
     */
    public function get_option($name, $key, $default = '')
    {
        $options  = has_option($name, $key);
        return ($options != '')? $options : $default;
    }

    /**
     * get_backup_export
     */
    public function get_backup_export(){
        
        $backup = config('site');
        unset($backup['unserialize']);
        $new_backup = [];
        foreach($backup as $key => $val){
            if(is_serialized($val)){
                $val = maybe_unserialize($val);
            }
            if(is_array($val)){
                $val = str_replace(str_replace('/', '\\/', url('/')), '{:$url:}', json_encode($val));
                $val = json_decode($val);
            }
            else {
                $val = str_replace(url('/'), '{:$url:}', $val);
            }
            $new_backup[$key] = $val;
        }
        
        return maybe_serialize($new_backup);
    }

}
