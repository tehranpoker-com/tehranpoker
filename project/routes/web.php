<?php
/**
 * Project: Basma - Resume / CV CMS
 * @link http://themearabia.net
 * @copyright 2021
 * @author Hossam Hamed <themearabia@gmail.com> <0201094140448>
 * @version 1.0
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontController;
use App\Http\Controllers\Frontend\AjaxController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AdminAjaxController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\MessagesController;
use App\Http\Controllers\Dashboard\PostsController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\LanguagesController;

/**
 * Frontend
 */
Route::middleware(['visitor', 'frontend', 'XSSClean'])->group(function () {
    /**
     * home
     */
    Route::get('/', [FrontController::class, 'index_home'])->name('home');
    Route::get('/home', [FrontController::class, 'index_home'])->name('home');
    
    /**
     * aboutme
     */
    Route::get('/aboutme', [FrontController::class, 'index_aboutme'])->name('aboutme');
    
    /**
     * resume
     */
    Route::get('/resume', [FrontController::class, 'index_resume'])->name('resume');
    
    /**
     * portfolio
     */
    Route::get('/portfolio', [FrontController::class, 'index_portfolio'])->name('portfolio');
    Route::get('/portfolio/{slug}', [FrontController::class, 'single_portfolio'])->name('single_portfolio');
    
    /**
     * blog
     */
    Route::get('/articles', [FrontController::class, 'index_articles'])->name('articles');
    Route::get('/blog', [FrontController::class, 'index_blog'])->name('blog');
    Route::get('/fullblog', [FrontController::class, 'index_fullblog'])->name('fullblog');
    Route::get('/blog/category/{slug}', [FrontController::class, 'index_blog_category'])->name('category');
    Route::get('/post/{slug}', [FrontController::class, 'index_single_post'])->name('post');
    
    /**
     * contactme
     */
    Route::get('/contactme', [FrontController::class, 'index_contactme'])->name('contactme');
    Route::post('/sendcontact', [FrontController::class, 'send_contact'])->name('sendcontact');
    
    /**
     * appointments
     */
    Route::get('/appointments', [FrontController::class, 'index_appointments'])->name('appointments');
    Route::post('/sendappointments', [FrontController::class, 'send_appointments'])->name('sendappointments');
    
    /**
     * pricings
     */
    Route::get('/pricings', [FrontController::class, 'index_pricings'])->name('pricings');
    
    /**
     * page
     */
    Route::get('/page/{slug}', [FrontController::class, 'index_page'])->name('page');
    
    /**
     * faqs
     */
    Route::get('/faqs', [FrontController::class, 'index_faqs'])->name('faqs');
    
    /**
     * support
     */
    Route::get('/support', [FrontController::class, 'index_support'])->name('support');

    /**
     * admin login
     */
    Route::any(get_admin_route('login'), [AuthController::class, 'adminlogin'])->middleware('guest');
    Route::get(get_admin_route('pincode/confirm'), [AuthController::class, 'admin_pincode_confirm'])->middleware('auth')->name('pincode.confirm');
    Route::post(get_admin_route('pincode/confirm'), [AuthController::class, 'admin_pincode_confirm_post'])->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    /**
     * ajax
     */
    Route::post('/ajaxRequest', [AjaxController::class, 'ajax_request'])->name('ajaxRequest');

});

/**
 * Dashboard
 */
Route::group(['prefix' => get_admin_url(), 'middleware' => ['admin', 'admin.pincodeconfirm', 'XSSClean']], function () {

    /**
     * dashboard
     */
    Route::get('/', [DashboardController::class, 'index_dashboard']);
    Route::get('/dashboard', [DashboardController::class, 'index_dashboard']);

    /**
     * profile
     */
    Route::get('/profile', [UsersController::class, 'index_profile']);
    Route::post('/UsersSendForm', [UsersController::class, 'users_sendform'])->name('UsersSendForm');

    /**
     * settings
     */
    Route::get('/settings', [DashboardController::class, 'index_settings']);
    Route::post('/SettingsSendForm', [DashboardController::class, 'settings_sendform']);

    /**
     * adminajax
     */
    Route::any('adminajax/', [AdminAjaxController::class, 'adminajax']);

    /**
     * categories
     */
    Route::get('/categories/{type?}', [CategoriesController::class, 'categories']);
    Route::get('/editcategory/{id}', [CategoriesController::class, 'edit_category']);
    Route::get('/enablecategory/{id}', [CategoriesController::class, 'enable_category']);
    Route::get('/disablecategory/{id}', [CategoriesController::class, 'disable_category']);
    Route::get('/deletecategory/{id}/{token}', [CategoriesController::class, 'delete_category']);
    Route::post('/CategorySendForm', [CategoriesController::class, 'categorys_sendform']);
    Route::post('/CategorysActions', [CategoriesController::class, 'categorys_actions']);

    /**
     * Media
     */
    Route::get('/media', [MediaController::class, 'index_media']);
    Route::get('/media/upload', [MediaController::class, 'media_upload']);
    Route::get('/editmedia/{id}', [MediaController::class, 'index_editmedia']);
    Route::get('/deletemedia/{id}/{token}', [MediaController::class, 'index_deletemedia']);
    Route::post('/MediaActions', [MediaController::class, 'media_actions']);
    Route::post('/MediaUpdate', [MediaController::class, 'media_update']);
    Route::get('/medialibrary', [MediaController::class, 'index_medialibrary']);
    Route::post('/mediaaction', [MediaController::class, 'index_mediaaction']);
    Route::any('/mediaajax', [MediaController::class, 'index_mediaajax']);

    /**
     * Messages
     */

    Route::get('/messages/{type}', [MessagesController::class, 'index_messages']);
    Route::get('/message/show-{id}', [MessagesController::class, 'index_message_show']);
    Route::get('/message/delete/{id}/{token}', [MessagesController::class, 'message_delete']);
    Route::post('/MessagesActions', [MessagesController::class, 'messages_actions']);

    /**
     * posts
     */
    Route::get('/posts/{type}', [PostsController::class, 'index_posts']);
    Route::get('/postnew/{type}', [PostsController::class, 'index_postnew']);
    Route::get('/editpost/{id}', [PostsController::class, 'index_editpost']);
    Route::get('/duplicate/{id}', [PostsController::class, 'index_duplicate']);
    Route::post('/PostSendForm', [PostsController::class, 'posts_sendform']);
    Route::post('/TranslatePostForm', [PostsController::class, 'posts_translate']);
    Route::get('/enablepost/{id}', [PostsController::class, 'index_enablepost']);
    Route::get('/disablepost/{id}', [PostsController::class, 'index_disablepost']);
    Route::get('/trashpost/{id}/{token}', [PostsController::class, 'index_trashpost']);
    Route::get('/deletepost/{id}/{token}', [PostsController::class, 'index_deletepost']);
    Route::post('/PostsActions', [PostsController::class, 'posts_actions']);

    /**
     * language
     */
    Route::get('/languages', [languagesController::class, 'languages']);
    Route::get('/editlanguage/{id}', [languagesController::class, 'edit_language']);
    Route::get('/language/phrases/{id}', [languagesController::class, 'edit_language_phrases']);
    Route::get('/language/refresh/{id}', [languagesController::class, 'refresh_language_phrases']);
    Route::get('/enablelanguage/{id}', [languagesController::class, 'enable_language']);
    Route::get('/disablelanguage/{id}', [languagesController::class, 'disable_language']);
    Route::get('/deletelanguage/{id}/{token}', [languagesController::class, 'delete_language']);
    Route::post('/LanguageSendForm', [languagesController::class, 'language_sendform']);
    Route::post('/LanguagesActions', [languagesController::class, 'languages_actions']);
    
});
