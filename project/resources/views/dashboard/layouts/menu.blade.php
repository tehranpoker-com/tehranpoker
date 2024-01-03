<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li><a href="{{ get_admin_url('/') }}"><i class="bx bx-home-circle"></i><span>{{ admin_lang('dashboard') }}</span></a></li>
                <li><a href="{{ get_admin_url('profile') }}"><i class="bx bx-user-circle"></i><span>{{ admin_lang('profile') }}</span></a></li>
                @action('admin_sidebar_menu_before')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-news"></i><span>{{ admin_lang('blog') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/posts') }}">{{ admin_lang('blog') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/posts') }}">{{ admin_lang('add_new') }}</a></li>
                        <li><a href="{{ get_admin_url('categories/posts') }}">{{ admin_lang('categories') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-briefcase-alt-2"></i><span>{{ admin_lang('portfolio') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/portfolio') }}">{{ admin_lang('portfolio') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/portfolio') }}">{{ admin_lang('add_new') }}</a></li>
                        <li><a href="{{ get_admin_url('categories/portfolio') }}">{{ admin_lang('categories') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bxs-magic-wand"></i><span>{{ admin_lang('services') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/services') }}">{{ admin_lang('services') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/services') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-bullseye"></i><span>{{ admin_lang('workingway') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/workingway') }}">{{ admin_lang('workingway') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/workingway') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-dollar-circle"></i><span>{{ admin_lang('pricings') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/pricings') }}">{{ admin_lang('pricings') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/pricings') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-user-pin"></i><span>{{ admin_lang('testimonials') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/testimonials') }}">{{ admin_lang('testimonials') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/testimonials') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-heart"></i><span>{{ admin_lang('clients') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/clients') }}">{{ admin_lang('clients') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/clients') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-bullseye"></i><span>{{ admin_lang('funfacts') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/funfacts') }}">{{ admin_lang('funfacts') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/funfacts') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-id-card"></i><span>{{ admin_lang('education') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/education') }}">{{ admin_lang('education') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/education') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-briefcase-alt"></i><span>{{ admin_lang('experience') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/experience') }}">{{ admin_lang('experience') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/experience') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-briefcase-alt-2"></i><span>{{ admin_lang('skills') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/skills') }}">{{ admin_lang('skills') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/skills') }}">{{ admin_lang('add_new') }}</a></li>
                        <li><a href="{{ get_admin_url('categories/skills') }}">{{ admin_lang('categories') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-envelope"></i><span>{{ admin_lang('messages') }}</span> {!! get_messages_html('appointments', 'contactus') !!}</a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('messages/appointments') }}">{{ admin_lang('appointments') }} {!! get_messages_html('appointments') !!}</a></li>
                        <li><a href="{{ get_admin_url('messages/contactus') }}">{{ admin_lang('contactus') }} {!! get_messages_html('contactus') !!}</a></li>
                    </ul>
                </li>
                @action('admin_sidebar_menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-help-circle"></i><span>{{ admin_lang('faqs') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/faqs') }}">{{ admin_lang('faqs') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/faqs') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-file"></i><span>{{ admin_lang('pages') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('posts/pages') }}">{{ admin_lang('pages') }}</a></li>
                        <li><a href="{{ get_admin_url('postnew/pages') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="bx bx-camera"></i><span>{{ admin_lang('media_library') }}</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ get_admin_url('media') }}">{{ admin_lang('media_library') }}</a></li>
                        <li><a href="{{ get_admin_url('media/upload') }}">{{ admin_lang('add_new') }}</a></li>
                    </ul>
                </li>

                <li><a href="{{ get_admin_url('languages') }}"><i class="bx bx-flag"></i><span>{{ admin_lang('languages') }}</span></a></li>
                <li><a href="{{ get_admin_url('settings') }}"><i class="bx bx-slider"></i><span>{{ admin_lang('settings') }}</span></a></li>
            </ul>
        </div>
    </div>
</div>