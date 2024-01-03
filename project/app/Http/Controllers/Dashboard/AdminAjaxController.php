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
use File;


class AdminAjaxController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
    }
    
    /**
     * adminajax
     */
    public function adminajax(Request $request)
    {
        /**
         * megapanel_geticons
         */
        if($request->has('action') and $request->get('action') == 'megapanel_geticons')
        {
            $json_files = [];
            $json_files['linearicons'] = ['title' => 'Linearicons', 'file' => public_path('public/dashboard/json/linearicons.json')];
            $json_files['peicon7stroke'] = ['title' => 'Pe Icon 7 Stroke', 'file' => public_path('public/dashboard/json/peicon7stroke.json')];

            if(has_option('fonticon', 'boxicons')){
                $json_files['boxicons'] = ['title' => 'Box icons', 'file' => public_path('public/dashboard/json/boxicons.json')];
            }

            if(has_option('fonticon', 'fontawesome')){
                $json_files['fontawesome'] = ['title' => 'Font Awesome', 'file' => public_path('public/dashboard/json/fontawesome.json')];
            }
            
            foreach($json_files as $key => $file){
                echo '<div class="megapanel-options-head-items">
                <h3><span class="megapanel-title-item">'.$file['title'].'</span><span class="megapanel_tools collapse-button"><i class="fa fa-minus"></i></span></h3>
                <div class="megapanel-options-content megapanel-toggle-content ">';
                if( file_exists($file['file']) ) {
                    $object = json_decode(File::get($file['file']));
                    if( is_object( $object ) ) {
                        foreach ( $object->icons as $icon ) {
                            echo '<a class="tacf-icon-selector" data-seticon="'. $icon .'"><i class="'. $icon .'"></i></a>';
                        }
                    } else {
                        echo '<h4 class="megapanel-dialog-title">'.admin_lang('error_load_json_file').'</h4>';
                    }
                }
                else
                {
                    echo '<h4 class="megapanel-dialog-title">'.admin_lang('error_notfound_json_file').'</h4>';
                }
                echo '</div></div>';
            }
        }
        elseif($request->has('action') and $request->get('action') == 'phrasesave')
        {
            $key    = $request->get('key');
            $code   = $request->get('code');
            $phrase = $request->get('phrase');
            $phrases_data  = File::getRequire(resource_path('lang/'.$code.'/global.php'));
            $phrases_data[$key] = $phrase;
            save_phrases($phrases_data, $code);
            return response()->json(['status' => true, 'phrases' => $phrases_data]);
        }
    }

}
