<?php
/**
 * Project: Basma - Resume / CV CMS
 * @link http://themearabia.net
 * @copyright 2022
 * @author Hossam Hamed <themearabia@gmail.com> <0201094140448>
 * @version 1.5
 */

@define('SCRIPT_VERSION', '1.5');

/**
 * Tables
 */
@define('ATTACHMENTS_TABLE',    'attachments');
@define('OPTIONS_TABLE',        'options');
@define('POSTS_TABLE',          'posts');
@define('POSTSMETA_TABLE',      'postsmeta');
@define('TERMS_TABLE',          'terms');
@define('TERMSMETA_TABLE',      'termsmeta');
@define('USERS_TABLE',          'users');
@define('USERSMETA_TABLE',      'usersmeta');
@define('VISITOR_TABLE',        'visitor');
@define('LANGUAGE_TABLE',       'language');

/**
 * default options
 */
if(!function_exists('default_options')){
    function default_options($name = '')
    {
        /**
         * widgets blog
         */
        $widgets_blog_default['search']       = ['id' => 'search', 'title' => admin_lang('search'), 'icon' => 'bx bx-search-alt', 'status' => '1', 'toggle' => '0'];
        $widgets_blog_default['categories']   = ['id' => 'categories', 'title' => admin_lang('categories'), 'icon' => 'bx bx-folder', 'status' => '1', 'toggle' => '0'];
        $widgets_blog_default['recentposts']  = ['id' => 'recent_posts', 'title' => admin_lang('recent_posts'), 'icon' => 'bx bxs-bolt', 'status' => '1', 'toggle' => '0'];
        $widgets_blog_default['popularposts'] = ['id' => 'popular_posts', 'title' => admin_lang('popular_posts'), 'icon' => 'bx bx-coffee', 'status' => '1', 'toggle' => '0'];
        $widgets_blog_default['tagscloud']    = ['id' => 'tags_cloud', 'title' => admin_lang('tags_cloud'), 'icon' => 'bx bx-purchase-tag-alt', 'status' => '1', 'toggle' => '0'];

        /**
         * share link
         */
        $sharelink_default['facebook']      = ['id' => 'facebook', 'title' => admin_lang('facebook'), 'icon' => 'bx bxl-facebook', 'status' => '1'];
        $sharelink_default['twitter']       = ['id' => 'twitter', 'title' => admin_lang('twitter'), 'icon' => 'bx bxl-twitter', 'status' => '1'];
        $sharelink_default['linkedin']      = ['id' => 'linkedin', 'title' => admin_lang('linkedin'), 'icon' => 'bx bxl-linkedin', 'status' => '1'];
        $sharelink_default['tumblr']        = ['id' => 'tumblr', 'title' => admin_lang('tumblr'), 'icon' => 'bx bxl-tumblr', 'status' => '1'];
        $sharelink_default['pinterest']     = ['id' => 'pinterest', 'title' => admin_lang('pinterest'), 'icon' => 'bx bxl-pinterest', 'status' => '1'];
        $sharelink_default['whatsapp']      = ['id' => 'whatsapp', 'title' => admin_lang('whatsapp'), 'icon' => 'bx bxl-whatsapp', 'status' => '1'];
        $sharelink_default['telegram']      = ['id' => 'telegram', 'title' => admin_lang('telegram'), 'icon' => 'bx bxl-telegram', 'status' => '1'];
        
        /**
         * socials default
         */
        $socials_default = [
            ['id' => 'email', 'title' => admin_lang('email'), 'url' => '', 'icon' => 'bx bx-envelope', 'bgcolor' => '#4b515d', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'facebook', 'title' => admin_lang('facebook'), 'url' => '', 'icon' => 'bx bxl-facebook', 'bgcolor' => '#3b5998', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'twitter', 'title' => admin_lang('twitter'), 'url' => '', 'icon' => 'bx bxl-twitter', 'bgcolor' => '#55acee', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'youtube', 'title' => admin_lang('youtube'), 'url' => '', 'icon' => 'bx bxl-youtube', 'bgcolor' => '#ed302f', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'vimeo', 'title' => admin_lang('vimeo'), 'url' => '', 'icon' => 'bx bxl-vimeo', 'bgcolor' => '#00A4E3', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'behance', 'title' => admin_lang('behance'), 'url' => '', 'icon' => 'bx bxl-behance', 'bgcolor' => '#0052F2', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'linkedin', 'title' => admin_lang('linkedin'), 'url' => '', 'icon' => 'bx bxl-linkedin', 'bgcolor' => '#0082ca', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'pinterest', 'title' => admin_lang('pinterest'), 'url' => '', 'icon' => 'bx bxl-pinterest', 'bgcolor' => '#c61118', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'instagram', 'title' => admin_lang('instagram'), 'url' => '', 'icon' => 'bx bxl-instagram', 'bgcolor' => '#2e5e86', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'telegram', 'title' => admin_lang('telegram'), 'url' => '', 'icon' => 'bx bxl-telegram', 'bgcolor' => '#0085c7', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'vkontakte', 'title' => admin_lang('vkontakte'), 'url' => '', 'icon' => 'bx bxl-vk', 'bgcolor' => '#4c75a3', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'stackoverflow', 'title' => admin_lang('stackoverflow'), 'url' => '', 'icon' => 'bx bxl-stack-overflow', 'bgcolor' => '#ffac44', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'slack', 'title' => admin_lang('slack'), 'url' => '', 'icon' => 'bx bxl-slack', 'bgcolor' => '#56b68b', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'github', 'title' => admin_lang('github'), 'url' => '', 'icon' => 'bx bxl-github', 'bgcolor' => '#333333', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'dribbble', 'title' => admin_lang('dribbble'), 'url' => '', 'icon' => 'bx bxl-dribbble', 'bgcolor' => '#ec4a89', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'reddit', 'title' => admin_lang('reddit'), 'url' => '', 'icon' => 'bx bxl-reddit', 'bgcolor' => '#ff4500', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'whatsapp', 'title' => admin_lang('whatsapp'), 'url' => '', 'icon' => 'bx bxl-whatsapp', 'bgcolor' => '#25d366', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
        ];


        /**
         * footer socials default
         */
        $footer_socials_default = [
            ['id' => 'facebook', 'title' => admin_lang('facebook'), 'url' => '', 'icon' => 'bx bxl-facebook', 'bgcolor' => '#3b5998', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'twitter', 'title' => admin_lang('twitter'), 'url' => '', 'icon' => 'bx bxl-twitter', 'bgcolor' => '#55acee', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'youtube', 'title' => admin_lang('youtube'), 'url' => '', 'icon' => 'bx bxl-youtube', 'bgcolor' => '#ed302f', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'vimeo', 'title' => admin_lang('vimeo'), 'url' => '', 'icon' => 'bx bxl-vimeo', 'bgcolor' => '#00A4E3', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'linkedin', 'title' => admin_lang('linkedin'), 'url' => '', 'icon' => 'bx bxl-linkedin', 'bgcolor' => '#0082ca', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'pinterest', 'title' => admin_lang('pinterest'), 'url' => '', 'icon' => 'bx bxl-pinterest', 'bgcolor' => '#c61118', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'dribbble', 'title' => admin_lang('dribbble'), 'url' => '', 'icon' => 'bx bxl-dribbble', 'bgcolor' => '#ec4a89', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
            ['id' => 'whatsapp', 'title' => admin_lang('whatsapp'), 'url' => '', 'icon' => 'bx bxl-whatsapp', 'bgcolor' => '#25d366', 'color' => '#FFFFFF', 'status' => '1', 'toggle' => '1'],
        ];

        /**
         * apikeys
         */
        $default_options['apikeys'] = [
            'captcha_status'            => '0',
            'recaptcha_key'             => '',
            'recaptcha_secret'          => '',
            'google_analytics_status'   => '',
            'google_analytics'          => '',
            'crisp_chat_status'         => '',
            'crisp_chat'                => '',
            'disqusid'                  => '',
            'graphcommentid'            => '',
        ];

        /**
         * fonticon
         */
        $default_options['fonticon'] = [
            'boxicons'      => '1',
            'fontawesome'   => '1',
        ];

        /**
         * sidebar
         * 
         */
        $default_options['sidebar'] = [
            'position'      => 'left',
            'avatar'        => get_asset('images/avatar.jpg'),
            'music_status'  => '0',
            'music'         => ''
        ];

        /**
         * sidebar_menu
         */
        $default_options['sidebar_menu'] = [
            'home'          => ['title' => admin_lang('home'), 'widget' => 'home', 'slug' => '/', 'icon' => 'lnr lnr-home', 'status' => '1', 'toggle' => '1'],
            'aboutme'       => ['title' => admin_lang('aboutme'), 'widget' => 'aboutme', 'slug' => '/aboutme', 'icon' => 'lnr lnr-user', 'status' => '1', 'toggle' => '1'],
            'resume'        => ['title' => admin_lang('resume'), 'widget' => 'resume', 'slug' => '/resume', 'icon' => 'lnr lnr-license', 'status' => '1', 'toggle' => '1'],
            'portfolio'     => ['title' => admin_lang('portfolio'), 'widget' => 'portfolio', 'slug' => '/portfolio', 'icon' => 'lnr lnr-briefcase', 'status' => '1', 'toggle' => '1'],
            'blog'          => ['title' => admin_lang('blog'), 'widget' => 'blog', 'slug' => '/blog', 'icon' => 'lnr lnr-book', 'status' => '1', 'toggle' => '0'],
            'contactme'     => ['title' => admin_lang('contactme'), 'widget' => 'contactme', 'slug' => '/contact', 'icon' => 'lnr lnr-envelope', 'status' => '1', 'toggle' => '1'],
            'appointments'  => ['title' => admin_lang('appointments'), 'widget' => 'appointments', 'slug' => 'appointments', 'icon' => 'lnr lnr-calendar-full', 'status' => '1', 'toggle' => '1'],
            'pricings'      => ['title' => admin_lang('pricings'), 'widget' => 'pricings', 'slug' => 'pricings', 'icon' => 'bx bx-dollar-circle', 'status' => '1', 'toggle' => '1'],
        ];

        /**
         * homepage
         */
        $default_options['homepage'] = [
            'title'         => 'Hello, My Name Is',
            'subtitle'      => 'Basma Designe',
            'description'   => 'A Creative Freelancer & Full Stack Developer',
            'textalign'     => 'text-center',
            'buttonsstatus' => '1',
            'style'         => 'bgimage',
            'particles'     => '0',
            'bgimage'       => get_asset('images/start_page.jpeg'),
            'bgvideo'       => '',
            'typedtitle'    => 'I\'m working as',
            'typed'         => [
                ['status' => '1', 'toggle' => '1', 'title' => 'UI/UX Designer'],
                ['status' => '1', 'toggle' => '1', 'title' => 'Web Developer'],
                ['status' => '1', 'toggle' => '1', 'title' => 'Mobile Developer'],
                ['status' => '1', 'toggle' => '1', 'title' => 'Photographer'],
            ],
            'buttons'       => [
                'contactme'     => ['title' => admin_lang('contactme'), 'widget' => 'contactme', 'slug' => '/contact', 'icon' => 'lnr lnr-envelope', 'status' => '1', 'toggle' => '1'],
                'appointments'  => ['title' => admin_lang('appointments'), 'widget' => 'appointments', 'slug' => 'appointments', 'icon' => 'lnr lnr-calendar-full', 'status' => '1', 'toggle' => '1'],
                'pricings'      => ['title' => admin_lang('pricings'), 'widget' => 'pricings', 'slug' => 'pricings', 'icon' => 'bx bx-dollar-circle', 'status' => '1', 'toggle' => '1'],
            ]
        ];

        /**
         * resume
         */
        $default_options['resume'] = [
            'page_title'            => lang('resume'),
            'page_subtitle'         => lang('resume_subtitle'),
            'style'                 => 'normal',
            'bgimage'               => '',
            'download_status'       => '0',
            'download_icon'         => 'lnr lnr-cloud-download',
            'download_url'          => '',
            'education_title'       => lang('education'),
            'education_subtitle'    => lang('education_subtitle'),
            'experience_title'      => lang('experience'),
            'experience_subtitle'   => lang('experience_subtitle'),
            'pagedesign'            => [
                ['id' => 'education', 'status' => '1'],
                ['id' => 'experience', 'status' => '1'],
                ['id' => 'skills', 'status' => '1'],
            ]
        ];

        /**
         * aboutme
         */
        $default_options['aboutme'] = [
            'page_title'                => lang('aboutme'),
            'page_subtitle'             => 'Basma Designe',
            'style'                     => 'normal',
            'bgimage'                   => '',
            'about_title'               => 'Basma Designe',
            'avatar'                    => get_asset('images/avatar.jpg'),
            'nationality'               => 'United States, America',
            'whoam'                     => 'I\'m a Freelance Full Stack Developer based in New York, USA, and I\'m very passionate and dedicated to my work .With 8 years experience as a professional Full Stack Developer, I have acquired the skills necessary to build great and premium websites. Lorem ipsum dolor sit amet, mauris suspendisse viverra eleifend tortor tellus suscipit, tortor aliquet at nulla mus, dignissim neque, nulla neque. Ultrices proin mi urna nibh ut, aenean sollicitudin etiam libero nisl, ultrices ridiculus in magna purus consequuntur, ipsum donec orci ad vitae pede, id odio. Turpis venenatis at laoreet. Etiam commodo fusce in diam feugiat, nullam suscipit tortor per velit viverra minim sed metus egestas sapien consectetuer. Etiam commodo fusce in diam feugiat, nullam suscipit tortor per velit viverra minim sed metus egestas sapien consectetuer. Etiam commodo fusce in diam feugiat, nullam suscipit tortor per velit viverra minim sed metus egestas sapien consectetuer.',
            'video_title'               => lang('video_title'),
            'video_subtitle'            => lang('video_subtitle'),
            'video_bgimage'             => get_asset('images/video_bg.jpg'),
            'video_url'                 => '',
            'services_title'            => lang('services_title'),
            'services_subtitle'         => '',
            'services_column'           => 'col-lg-4',
            'workingway_title'          => lang('workingway_title'),
            'workingway_subtitle'       => '',
            'workingway_column'         => 'col-lg-3',
            'testimonials_title'        => lang('testimonials_title'),
            'testimonials_subtitle'     => '',
            'testimonials_column'       => 'col-lg-3',
            'testimonials_style'        => 'owlcarousel',
            'testimonials_owlrespc'     => '3',
            'testimonials_owlrestablet' => '2',
            'testimonials_owlresphone'  => '1',
            'clients_title'             => lang('clients_title'),
            'clients_subtitle'          => '',
            'clients_column'            => 'col-lg-3',
            'clients_style'             => 'owlcarousel',
            'clients_owlrespc'          => '3',
            'clients_owlrestablet'      => '2',
            'clients_owlresphone'       => '1',
            'funfacts_title'            => lang('funfacts_title'),
            'funfacts_subtitle'         => '',
            'funfacts_column'           => 'col-lg-3',
            'pagedesign'                => [
                ['id' => 'whoam', 'status' => '1'],
                ['id' => 'video', 'status' => '1'],
                ['id' => 'services', 'status' => '1'],
                ['id' => 'workingway', 'status' => '1'],
                ['id' => 'testimonials', 'status' => '1'],
                ['id' => 'clients', 'status' => '1'],
                ['id' => 'funfacts', 'status' => '1'],
                ['id' => 'pricings', 'status' => '1'],
            ]
        ];

        /**
         * blog
         */
        $default_options['blog'] = [
            'page_title'                => lang('blog'),
            'page_subtitle'             => lang('blog_subtitle'),
            'style'                     => 'normal',
            'bgimage'                   => '',
            'blog_title'                => lang('blog'),
            'blog_subtitle'             => lang('blog_subtitle'),
            'breadcrumbs'               => '1',
            'per_page'                  => '12',
            'post_column'               => 'col-lg-6',
            'widgets'                   => 'right',
            'widgets_column'            => 'col-lg-4',
            'post_breadcrumbs'          => '1',
            'post_widgets'              => 'right',
            'post_widgets_column'       => 'col-lg-4',
            'sharelink_status'          => '1',
            'sharelink'                 => $sharelink_default,
            'post_meta_author'          => '1',
            'post_meta_date'            => '1',
            'post_meta_views'           => '1',
            'post_meta_cate'            => '1',
            'post_meta_tags'            => '1',
            'related_posts'             => '1',
            'related_posts_title'       => lang('related_posts'),
            'related_posts_per_page'    => '2',
            'widgets_blog'              => $widgets_blog_default,
            'recent_per_page'           => '4',
            'popular_per_page'          => '4',
        ];

        /**
         * portfolio
         */
        $default_options['portfolio'] = [
            'sectiontitle'              => '1',
            'page_title'                => lang('portfolio_title'),
            'page_subtitle'             => lang('portfolio_subtitle'),
            'imagesize'                 => 'full',
            'template'                  => 'fix',
            'fltersstyle'               => 'fix',
            'column'                    => 'size-4',
            'style'                     => 'normal',
            'loadmore'                  => '1',
            'limitloadmore'             => '10',
            'bgimage'                   => '',
            'breadcrumbs'               => '1',
            'sharelink_status'          => '1',
            'sharelink'                 => $sharelink_default,
            'related_posts'             => '1',
            'related_posts_title'       => lang('related_projects'),
            'related_posts_per_page'    => '3',
        ];

        /**
         * contactme
         */
        $default_options['contactme'] = [
            'page_title'                => lang('contact_title'),
            'page_subtitle'             => lang('contact_subtitle'),
            'style'                     => 'normal',
            'bgimage'                   => '',
            'mapstatus'                 => '1',
            'maplatitude'               => '',
            'maplongitude'              => '',
            'mapzoom'                   => '8',
            'mapmarker'                 => get_asset('images/map-marker.png'),
            'information_title'         => lang('information_title'),
            'information_subtitle'      => '',
            'address'                   => 'address',
            'phone'                     => '(01) 1234-56789-1',
            'phone2'                    => '(01) 1234-56789-2',
            'email'                     => 'themearabia@gmail.com',
            'email2'                    => 'themearabia@gmail.com',
            'form_title'                => lang('contactform_title'),
            'form_subtitle'             => '',
            'send'                      => 'database',
            'socials_title'             => lang('follow_me'),
            'socials_subtitle'          => '',
            'socials_status'            => 'size-md',
            'socials'                   => $socials_default
        ];

        /**
         * appointments
         */
        $default_options['appointments'] = [
            'page_title' => lang('appointments'),
            'page_subtitle' => lang('appointments_subtitle'),
            'send'          => 'database',
            'style'         => 'normal',
            'bgimage'       => '',
            'mastatus'      => '1',
            'matitle'       => lang('my_appointments'),
            'masubtitle'    => lang('my_appointments_subtitle'),
            'works'         => [
                'saturday'   => ['status' => '1', 'start' => '8:30 AM', 'end' => '3:30 PM'],
                'sunday'     => ['status' => '0', 'start' => '8:30 AM', 'end' => '3:30 PM'],
                'monday'     => ['status' => '1', 'start' => '8:30 AM', 'end' => '3:30 PM'],
                'tuesday'    => ['status' => '1', 'start' => '8:30 AM', 'end' => '3:30 PM'],
                'wednesday'  => ['status' => '1', 'start' => '8:30 AM', 'end' => '3:30 PM'],
                'thursday'   => ['status' => '1', 'start' => '8:30 AM', 'end' => '3:30 PM'],
                'friday'     => ['status' => '0', 'start' => '8:30 AM', 'end' => '3:30 PM'],
            ],
        ];

        /**
         * pricings
         */
        $default_options['pricings'] = [
            'page_title'    => lang('pricings'),
            'page_subtitle' => lang('pricings_subtitle'),
            'template'      => 'style1',
            'column'        => 'col-lg-4',
            'style'         => 'normal',
            'bgimage'       => null,
        ];

        /**
         * support
         */
        $default_options['support'] = [
            'page_title'    => lang('support'),
            'page_subtitle' => lang('support_subtitle'),
            'style'         => 'normal',
            'bgimage'       => null,
            'phone_status'  => '1',
            'phone_title'   => lang('phone_support'),
            'phoneicon'     => 'pe-7s-call',
            'phone_text'    => lang('sales'),
            'phone_number'  => '',
            'phone2_text'   => lang('technical'),
            'phone2_number' => '',
            'email_status'  => '1',
            'email_title'   => lang('email_support'),
            'emailicon'     => 'pe-7s-mail',
            'email_text'    => lang('sales'),
            'email_email'   => '',
            'email2_text'   => lang('technical'),
            'email2_email'  => '',
        ];

        /**
         * faqs
         */
        $default_options['faqs'] = [
            'status'        => '1',
            'page_title'    => lang('faqs'),
            'page_subtitle' => lang('faqs_subtitle'),
            'icon'          => 'pe-7s-help1',
            'column'        => '1column',
            'style'         => 'normal',
            'bgimage'       => null,
        ];

        /**
         * tickets
         */
        $default_options['tickets'] = [
            'status'        => '0',
            'page_title'    => lang('tickets'),
            'page_subtitle' => lang('tickets_subtitle'),
            'icon'          => 'pe-7s-ticket',
            'url'           => '',
        ];

        /**
         * footer
         */
        $default_options['footer'] = [
            'status'            => '0',
            'clients_status'    => '0',
            'clients'           => [],
            'socials_status'    => '0',
            'socials'           => $footer_socials_default
        ];

        /**
         * style
         */
        $default_options['style'] = [
            'template'          => 'onepage',
            'breadcrumbs'       => 'style1',
            'breadhomeicon'     => 'lnr lnr-home',
            'gotoup'            => '0',
            'gotoupicon'        => 'lnr lnr-chevron-up',
            'pageloaded'        => '1',
            'pageloadedstyle'   => 'style1',
            'favicon'           => get_asset('images/favicon.png'),
            'fontfamily'        => 'Roboto',
            'darkmode'          => '0',
            'skinscolor'        => '#F15F79',
            'pagesanimate'      => 'fadeInLeft'
        ];

        /**
         * seo
         */
        $default_options['seo'] = [
            'status'        => '1',
            'robots'        => 'index, follow, max-video-preview:-1, max-image-preview:large',
            'twitter'       => '',
            'description'   => 'Basma Resume / CV CMS',
            'keywords'      => 'personal, html5, vTemplate, resposnive, retina, resume, jquery, css3, bootstrap, portfolio, cms, laravel',
        ];

        /**
         * cookie
         */
        $default_options['cookie'] = [
            'status'        => '0',
            'id'            => 'basmaresume',
            'position'      => 'left',
            'image'         => get_asset('images/cookie.svg'),
            'title'         => '',
            'desc'          => '',
            'decline'       => admin_lang('decline'),
            'consent'       => admin_lang('consent'),
            'style'         => 'style1'
        ];

        /**
         * maintenance
         */
        $default_options['maintenance'] = [
            'status'        => '0',
            'bgimage'       => get_asset('images/maintenance.jpg'),
            'title'         => '',
            'message'       => '',
            'timer_status'  => '0',
            'date'          => ''
        ];

        if($name){
            return (isset($default_options[$name]))? $default_options[$name] : [];  
        }
        else {
            return $default_options;
        }
    }
}

if(!function_exists('default_language')){
    function default_language()
    {
        $default_language = [
            ['name' => 'English', 'code' => 'en', 'direction' => 'ltr', 'status' => '1', 'default' => '1'],
            ['name' => 'French', 'code' => 'fr', 'direction' => 'ltr', 'status' => '1', 'default' => '0'],
            ['name' => 'Russian', 'code' => 'ru', 'direction' => 'ltr', 'status' => '1', 'default' => '0'],
            ['name' => 'Turkish', 'code' => 'tr', 'direction' => 'ltr', 'status' => '1', 'default' => '0'],
            ['name' => 'German', 'code' => 'de', 'direction' => 'ltr', 'status' => '1', 'default' => '0'],
            ['name' => 'Arabic', 'code' => 'ar', 'direction' => 'rtl', 'status' => '1', 'default' => '0'],
            ['name' => 'Hindi', 'code' => 'hi', 'direction' => 'ltr', 'status' => '1', 'default' => '0'],
        ];

        return $default_language;
    }
}

/**
 * identifier types
 */
if(!function_exists('identifier_types')){
    function identifier_types()
    {
        $types = [
            'posts'         => ['slug' => 'post'], 
            'portfolio'     => ['slug' => 'portfolio'], 
            'services'      => ['slug' => false], 
            'pricings'      => ['slug' => false], 
            'workingway'    => ['slug' => false], 
            'testimonials'  => ['slug' => false], 
            'clients'       => ['slug' => false], 
            'funfacts'      => ['slug' => false], 
            'education'     => ['slug' => false], 
            'experience'    => ['slug' => false], 
            'skills'        => ['slug' => false], 
            'pages'         => ['slug' => 'page'],
            'faqs'          => ['slug' => false]
        ];
        $types = Eventy::filter('admin_filter_identifier_types', $types);
        return $types;
    }
}
