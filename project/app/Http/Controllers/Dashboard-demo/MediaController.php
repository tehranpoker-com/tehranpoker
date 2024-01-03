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
use Illuminate\Support\Facades\Auth;
use Exception;
use TorMorten\Eventy\Facades\Events as Eventy;

class MediaController extends Controller
{
    private $mediapaginate;
    private $paginate;
    private $mimes = [];
    private $mime_resize;
    
    public function __construct()
    {
        $this->middleware('admin');
        parent::__construct();
        $this->mediapaginate = 20;
        $this->paginate = 32;
        $this->mime_resize = ['jpg', 'jpeg', 'gif', 'png'];
        $this->mimes = [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
            'files' => ['txt', 'csv', 'zip', 'psd', 'pdf', 'rtf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'],
            'video' => ['mp4', 'avi', 'mov'],
            'audio' => ['mp3', 'm4a', 'wav']
        ];
    }

    /**
     * normal
     */
    public function index_media(Request $request)
    {
        $data['page_title'] = admin_lang('media_library');
        $data['page_class'] = admin_lang('media');
        $attachments = DB::table(ATTACHMENTS_TABLE);
        if($request->get('s')){
            $attachments->where('at_title', 'like', '%'.$request->get('s').'%');
        }
        $attachments = $attachments->orderBy('at_modified', 'desc')->paginate($this->mediapaginate);
        if ($request->has('page') and $request->get('page') > $attachments->lastPage()) {
            return redirect($attachments->url($attachments->lastPage()));
        }
        $data['attachments'] = $attachments;
        return get_admin_view('medialibrary.index_media', $data);
    }

    /**
     * media_upload
     */
    public function media_upload(Request $request)
    {
        $data['page_title'] = admin_lang('upload');
        $data['page_class'] = admin_lang('media');
        return get_admin_view('medialibrary.index_media_upload', $data);
    }

    /**
     * index_editmedia
     */
    public function index_editmedia($id, Request $request)
    {
        $post = DB::table(ATTACHMENTS_TABLE)->where([['at_id', '=', $id]])->get();
        if ($post->count()) {
            $single = $post->first();
            $data['page_title'] = admin_lang('media_library');
            $data['page_class'] = admin_lang('media');

            if(in_array($single->at_mimes, $this->mimes['audio'])){
                $data['filetype'] = 'audio';
            }
            elseif(in_array($single->at_mimes, $this->mimes['video'])){
                $data['filetype'] = 'video';
            }
            elseif(in_array($single->at_mimes, $this->mimes['files'])){
                $data['filetype'] = 'files';
            }
            elseif(in_array($single->at_mimes, $this->mimes['image'])){
                $data['filetype'] = 'image';
            }
            else{
                $data['filetype'] = 'none';
            }
            $data['single'] = $single;

            $data['attached_in'] = DB::table(POSTSMETA_TABLE)
            ->leftJoin('posts', function ($join) {$join->on('postsmeta.post_id', '=', 'posts.id');})
            ->selectRaw('post_title,post_name,post_type,post_id')
            ->where(['meta_key' => 'thumbnails', 'meta_value' => $single->at_id])->get(); 
            return get_admin_view('medialibrary.index_media_edit', $data);
        }
        else {
            return redirect()->back();
        }
    }
    
    /**
     * media_update
     */
    public function media_update(Request $request)
    {
        $at_id  = $request->get('at_id');
        /*
        DB::table(ATTACHMENTS_TABLE)->where(['at_id' => $at_id])->update([
            'at_title'  => $request->get('at_title'),
            'at_desc'  => $request->get('at_desc'),
        ]);
        */
        $success = admin_lang('msg_media_updated');
        return redirect(get_admin_url('editmedia/' . $at_id))->with("success", $success);
    }

    /**
     * media_actions
     */
    public function media_actions(Request $request)
    {
        if ($request->has('query') && $request->get('query') == 'action') {
            $marks = $request->get('mark');
            if ($request->get('action') == 'delete' and is_array($marks)) {
                foreach ($marks as $markid) {
                    //DB::table(ATTACHMENTS_TABLE)->where(['at_id' => $markid])->delete();
                }
                $success = admin_lang('msg_delete_selected');
            } else {
                $success = admin_lang('msg_noselectaction');
            }
            return redirect()->back()->with("success", $success);
        }
    }

    /**
     * index_deletemedia
     */
    public function index_deletemedia($id, $token)
    {
        //DB::table(ATTACHMENTS_TABLE)->where(['at_id' => $id])->delete();
        return redirect()->back()->with("success", admin_lang('msg_media_delete'));
    }

    /**
     * index_medialibrary
     */
    public function index_medialibrary(Request $request)
    {
        $data['page_title'] = admin_lang('media_library');
        if($request->has('type') and in_array($request->get('type'), ['audio', 'video', 'files'])){
            $type = $request->get('type');
        } else {
            $type = 'image';
        }
        $attachments = DB::table(ATTACHMENTS_TABLE)->whereIn('at_mimes', $this->mimes[$type]);
        if($request->get('s')){
            $attachments->where('at_title', 'like', '%'.$request->get('s').'%');
        }
        $attachments = $attachments->orderBy('at_modified', 'desc')->paginate($this->paginate);
        if ($request->has('page') and $request->get('page') > $attachments->lastPage()) {
            return redirect($attachments->url($attachments->lastPage()));
        }

        $attach_date = DB::table(ATTACHMENTS_TABLE)
        ->select(DB::raw('count(at_id) as `data`'), DB::raw("DATE_FORMAT(at_modified, '%Y-%m') date_val"), DB::raw("DATE_FORMAT(at_modified, '%M %Y') date_txt"), DB::raw('YEAR(at_modified) year, MONTH(at_modified) month'))
        ->groupby('year','month')
        ->whereIn('at_mimes', $this->mimes[$type])->orderBy('at_modified', 'desc')->get();
        $data['attachments'] = $attachments;
        $data['attach_date'] = $attach_date;
        $data['type'] = $type;
        return get_admin_view('medialibrary.index_medialibrary', $data);
    }

    /**
     * index_mediaaction
     */
    public function index_mediaaction(Request $request)
    {

        if($request->has('action') and $request->get('action') == 'handler')
        {
            if($request->has('send') and $request->get('send') == 'gallery')
            {
                
            }
            else
            {
                $send_id                = $request->get('id');
                $attachments            = DB::table(ATTACHMENTS_TABLE)->where('at_id', $send_id)->first();
                $mimes                  = $attachments->at_mimes;
                $file['title']          = $attachments->at_title;
                $file['mimes']          = $mimes;
                $file['fileid']         = $send_id;
                if(in_array($mimes, $this->mimes['audio']))
                {
                    $file['filetype'] = 'audio';
                    $file['file'] = url($attachments->at_file);
                }
                elseif(in_array($mimes, $this->mimes['video']))
                {
                    $file['filetype'] = 'video';
                    $file['file'] = url($attachments->at_file);
                }
                elseif(in_array($mimes, $this->mimes['files']))
                {
                    $file['filetype'] = 'files';
                    $file['file'] = url($attachments->at_file);
                }
                elseif(in_array($mimes, $this->mimes['image']))
                {
                    $file['filetype'] = 'image';
                    $file['file'] = get_media_mimes_thumbnail($attachments->at_files, $mimes, 'file');
                }
                else
                {
                    $file['filetype'] = 'none';
                }
                $file['thumbnail'] = get_media_mimes_thumbnail($attachments->at_files, $mimes, 'thumbnail');
                return response()->json($file);
            }
        }
        elseif($request->has('action') and $request->get('action') == 'async_upload')
        {
            return $this->ajax_async_upload($request);
        }
        elseif($request->has('action') and $request->get('action') == 'getmediainfo')
        {
            return $this->ajax_get_media_info($request);
        }
        elseif($request->has('action') and $request->get('action') == 'loadmedia')
        {
            return $this->ajax_load_media($request);
        }
        elseif($request->has('action') and $request->get('action') == 'filtermedia')
        {
            return $this->ajax_load_media($request);
        }
    }

    /**
     * ajax_load_media
     */
    public function ajax_load_media($request)
    {
        $page = $request->get('page');
        $type = $request->get('type');
        $filter_search = $request->get('search');
        $filter_date = $request->get('date');
        $where[] = ['trash', '=', '0'];

        if($filter_search != null){
            $where[]    = ['at_title', 'like', '%'.$filter_search.'%'];
        }
        if($filter_date != 'all'){
            $where[]    = ['at_modified', 'like', '%'.$filter_date.'%'];
        }
        
        $attachments = DB::table(ATTACHMENTS_TABLE)
        ->where($where)
        ->whereIn('at_mimes', $this->mimes['image'])
        ->orderBy('at_modified', 'desc')
        ->paginate($this->paginate, '*', '',  $page);

        if ($page <= $attachments->lastPage()) {
            $data['upfiles'] = $attachments;
            $returnHTML = get_admin_view('medialibrary.ajax_loop_load_media', $data)->render();
            return response()->json(['success' => true, 'html'=> $returnHTML, 'lastPage'=> $attachments->lastPage(), 'page'=> $page]);
        }
        else
        {
            return response()->json(['success' => false, 'lastPage'=> $attachments->lastPage()]);
        }
    }

    /**
     * ajax_get_media_info
     */
    public function ajax_get_media_info($request)
    {
        $mediaid = $request->get('mediaid');
        $attachment = DB::table(ATTACHMENTS_TABLE)->where('at_id', '=', $mediaid)->get();
        if($attachment->count())
        {
            $file = $attachment->first();
            $return['status']      = true;
            $return['title']       = $file->at_title;
            $return['uploaded']    = $file->at_modified;
            $return['size']        = format_size($file->at_size);
            $return['mimes']       = $file->at_mimes;
            if(in_array($return['mimes'], $this->mimes['audio']))
            {
                $return['file']   = $file->at_file;
                $return['type']   = 'audio';
                $return['player'] = get_admin_view('layouts/player_audio')->render();
            }
            return response()->json($return);
        }
        else
        {
            return response()->json(['status' => false]);
        }
    }

    /**
     * index_mediaajax
     */
    public function index_mediaajax(Request $request)
    {
        if($request->has('action') and $request->get('action') == 'async_upload')
        {
            $retype = ($request->has('retype'))? $request->get('retype') : '';
            $upfiles = $this->ajax_async_upload($request);
            $data['upfiles'] = $upfiles;
            if($retype == 'normal') {
                $returnHTML = get_admin_view('medialibrary.loop_upfiles', $data)->render();
            } else {
                $returnHTML = get_admin_view('medialibrary.ajax_loop_upfiles', $data)->render();
            }
            return response()->json(['success' => true, 'html'=> $returnHTML]);
        }
    }

    /**
     * ajax_async_upload
     */
    public function ajax_async_upload($request, $type = '')
    {
        $upfiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $isfile = $this->ajax_upload_file($file, $file->getClientOriginalExtension());
                if(isset($isfile['error'])) {
                    $upfiles[] = ['error' => $isfile['error']];
                }
                else {
                    $upfiles[] = $isfile;
                }
            }
            return $upfiles;
        }
        else
        {
            return $upfiles;
        }
    }

    /**
     * ajax_upload_file
     */
    public function ajax_upload_file($file, $mimes = null)
    {
        $mimes = $file->getClientOriginalExtension();
        if(file_upload_max_size() == $file->getSize()) {
            return ['error' => admin_lang('error_file_upload_max_size')];
        }
        elseif($this->is_allowed_mime($mimes)) {
            /*
            $user               = Auth::user();
            $uploads            = $this->get_upload_dir();
            $path_upload        = $uploads['target'];
            $name               = $file->getClientOriginalName();
            $file_name          = $this->unique_filename($path_upload, $name);
            $size               = $file->getSize();
            $title              = $this->get_real_filename($name);
            $new_file           = $uploads['path'] . $file_name;
            $type               = $file->getMimeType();
            $attachment_file    = [];
            $at_files           = null;
            $dimensions         = null;
            $content            = '';
            $up_file            = $uploads['target'] . $file_name;
            $path = $file->move($path_upload, $file_name);
            if(in_array($mimes, $this->mimes['image'])) {
                if(in_array($mimes, $this->mime_resize) ){
                    try {
                        $sizeInfo   = getimagesize($path);
                        $width      = $sizeInfo[0]; 
                        $height     = $sizeInfo[1];
                        $dimensions = (isset($width) and isset($height))? $width.'x'.$height : null;
                    }
                    catch (Exception $e) {}
                    $attachment_file = $this->image_resize($uploads, $file_name, $mimes, $width, $height);
                }                
                $attachment_file['file'] = $new_file;
                $at_files = maybe_serialize($attachment_file);
            }

            $attach_id = DB::table(ATTACHMENTS_TABLE)->insertGetId([
                'at_uid'        => $user->id,
                'at_title'      => $title,
                'at_file'       => $new_file,
                'at_files'      => $at_files,
                'at_mimes'      => $mimes,
                'at_type'       => $type,
                'at_dimensions' => $dimensions,
                'at_size'       => $size,
            ]);
            // chmod file
            $stat  = stat($uploads['target'].$file_name);
            $perms = $stat['mode'] & 0000666;
            @chmod( $new_file, $perms );
            */
            $title = 'upload demo!';
            $mimes = 'jpg';
            $attachment_file = [
                'file' => url('uploads/2021/11/2021-11-04.jpeg')
            ];
            $attach_id = '56';

            return ['id' => $attach_id, 'url' => get_media_mimes_thumbnail($attachment_file, $mimes), 'title' => $title];
        }
        else {
            return ['error' => admin_lang('error_has_failed_upload', ['filename' => $file->getClientOriginalName()])];
        }
    }

    /**
     * get_real_filename
     */
    public function get_real_filename($filename)
    {
        $ext       = pathinfo( $filename, PATHINFO_EXTENSION );
        $name      = pathinfo( $filename, PATHINFO_BASENAME );
        if ( $ext ) {
            $ext = '.' . $ext;
        }
        return preg_replace( '|' . preg_quote(strtolower($ext)) . '$|', '', $filename );
    }
    
    /**
     * unique_filename
     */
    public function unique_filename( $dir, $filename)
    {
        $filename  = $this->sanitize_file_name($filename);
        $ext       = pathinfo( $filename, PATHINFO_EXTENSION );
        $name      = pathinfo( $filename, PATHINFO_BASENAME );
        if ( $ext ) {
            $ext = '.' . $ext;
        }
        if ( $name === $ext ) {
            $name = '';
        }
        $number = '';
        if ( $ext && strtolower($ext) != $ext ) {
            $ext2       = strtolower($ext);
            $filename2  = preg_replace( '|' . preg_quote($ext) . '$|', $ext2, $filename );
            while ( file_exists($dir . $filename) || file_exists($dir . $filename2) ) {
                $new_number = (int) $number + 1;
                $filename   = str_replace( array( "-$number$ext", "$number$ext" ), "-$new_number$ext", $filename );
                $filename2  = str_replace( array( "-$number$ext2", "$number$ext2" ), "-$new_number$ext2", $filename2 );
                $number = $new_number;
            }
            return $filename;
        }
        while ( file_exists( $dir . $filename ) ) {
            $new_number = (int) $number + 1;
            if ( '' == "$number$ext" ) {
                $filename = "$filename-" . $new_number;
            } else {
                $filename = str_replace( array( "-$number$ext", "$number$ext" ), "-" . $new_number . $ext, $filename );
            }
            $number = $new_number;
        }
        return $filename;
    }

    /**
     * sanitize_file_name
     */
    public function sanitize_file_name( $filename )
    {
        $filename_raw = $filename;
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", chr(0));
        $filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );
        $filename = str_replace( $special_chars, '', $filename );
        $filename = str_replace( array( '%20', '+' ), '-', $filename );
        $filename = preg_replace( '/[\r\n\t -]+/', '-', $filename );
        $filename = trim( $filename, '.-_' );
        if ( false === strpos( $filename, '.' ) ) {
            $mime_types = $this->get_mime_types();
            $filetype = $this->check_filetype( 'test.' . $filename, $mime_types );
            if ( $filetype['ext'] === $filename ) {
                $filename = 'unnamed-file.' . $filetype['ext'];
            }
        }
        $parts = explode('.', $filename);
        if ( count( $parts ) <= 2 ) {
            return $filename;
        }
        $filename  = array_shift($parts);
        $extension = array_pop($parts);
        $mimes     = $this->get_allowed_mime_types();
        foreach ( (array) $parts as $part) {
            $filename .= '.' . $part;
            if ( preg_match("/^[a-zA-Z]{2,5}\d?$/", $part) ) {
                $allowed = false;
                foreach ( $mimes as $ext_preg => $mime_match ) {
                    $ext_preg = '!^(' . $ext_preg . ')$!i';
                    if ( preg_match( $ext_preg, $part ) ) {
                        $allowed = true;
                        break;
                    }
                }
                if ( !$allowed )
                    $filename .= '_';
            }
        }
        $filename .= '.' . $extension;
        return $filename;
    }
    
    /**
     * folder_upload_date
     */
    public function folder_upload_date($target)
    {
        if(!is_dir( $target ))
        {
            $target_parent = dirname( $target );
            while ( '.' != $target_parent && ! is_dir( $target_parent ) ) {
                $target_parent = dirname( $target_parent );
            }

            if ( $stat = @stat( $target_parent ) ) {
                $dir_perms = $stat['mode'] & 0007777;
            } else {
                $dir_perms = 0777;
            }
            if ( @mkdir( $target, $dir_perms, true ) )
            {
                
            }
        }
        return date('Y').'/'.date('m');
    }
    
    /**
     * get_upload_dir
     */
    public function get_upload_dir()
    {
        $dir['basedir']     = date('Y').'/';
        $dir['subdir']      = date('m').'/';
        $dir['path']        = 'uploads/'.$dir['basedir'].$dir['subdir'];
        $dir['target']      = public_path($dir['path']);
        $dir['diruploads']  = public_path('uploads/');
        $dir['url']         = url($dir['path']);
        $dir['siteurl']     = url('/');
        $dir['uploaddir']   = $dir['basedir'].$dir['subdir'];
        $this->folder_upload_date($dir['target']);
        return $dir;
    }

    /**
     * get_mime_types
     */
    public function get_mime_types()
    {
        return array(
        // Image formats.
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'tiff|tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        // Video formats.
        'asf|asx' => 'video/x-ms-asf',
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wm' => 'video/x-ms-wm',
        'avi' => 'video/avi',
        'divx' => 'video/divx',
        'flv' => 'video/x-flv',
        'mov|qt' => 'video/quicktime',
        'mpeg|mpg|mpe' => 'video/mpeg',
        'mp4|m4v' => 'video/mp4',
        'ogv' => 'video/ogg',
        'webm' => 'video/webm',
        'mkv' => 'video/x-matroska',
        '3gp|3gpp' => 'video/3gpp', // Can also be audio
        '3g2|3gp2' => 'video/3gpp2', // Can also be audio
        // Text formats.
        'txt|asc|c|cc|h|srt' => 'text/plain',
        'csv' => 'text/csv',
        'tsv' => 'text/tab-separated-values',
        'ics' => 'text/calendar',
        'rtx' => 'text/richtext',
        'vtt' => 'text/vtt',
        'dfxp' => 'application/ttaf+xml',
        // Audio formats.
        'mp3|m4a|m4b' => 'audio/mpeg',
        'ra|ram' => 'audio/x-realaudio',
        'wav' => 'audio/wav',
        'ogg|oga' => 'audio/ogg',
        'flac' => 'audio/flac',
        'mid|midi' => 'audio/midi',
        'wma' => 'audio/x-ms-wma',
        'wax' => 'audio/x-ms-wax',
        'mka' => 'audio/x-matroska',
        // Misc application formats.
        'rtf' => 'application/rtf',
        'pdf' => 'application/pdf',
        'class' => 'application/java',
        'tar' => 'application/x-tar',
        'zip' => 'application/zip',
        'gz|gzip' => 'application/x-gzip',
        //'rar' => 'application/rar',
        '7z' => 'application/x-7z-compressed',
        'psd' => 'application/octet-stream',
        'xcf' => 'application/octet-stream',
        // MS Office formats.
        'doc' => 'application/msword',
        'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
        'wri' => 'application/vnd.ms-write',
        'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
        'mdb' => 'application/vnd.ms-access',
        'mpp' => 'application/vnd.ms-project',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
        'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
        'oxps' => 'application/oxps',
        'xps' => 'application/vnd.ms-xpsdocument',
        // OpenOffice formats.
        'odt' => 'application/vnd.oasis.opendocument.text',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odf' => 'application/vnd.oasis.opendocument.formula',
        // WordPerfect formats.
        'wp|wpd' => 'application/wordperfect',
        // iWork formats.
        'key' => 'application/vnd.apple.keynote',
        'numbers' => 'application/vnd.apple.numbers',
        'pages' => 'application/vnd.apple.pages',
        );
    }

    /**
     * check_filetype
     */
    public function check_filetype( $filename, $mimes = null )
    {
        if ( empty($mimes) )
            $mimes = $this->get_mime_types();
        $type = false;
        $ext = false;
    
        foreach ( $mimes as $ext_preg => $mime_match ) {
            $ext_preg = '!\.(' . $ext_preg . ')$!i';
            if ( preg_match( $ext_preg, $filename, $ext_matches ) ) {
                $type = $mime_match;
                $ext = $ext_matches[1];
                break;
            }
        }
    
        return compact( 'ext', 'type' );
    }

    /**
     * get_allowed_mime_types
     */
    public function get_allowed_mime_types( $user = null )
    {
        $t = $this->get_mime_types();
        unset( $t['swf'], $t['exe'] );
        unset( $t['htm|html'], $t['js'] );
        unset($t['code']);
        return $t;
    }

    /**
     * is_allowed_mime
     */
    public function is_allowed_mime($mime)
    {
        $mime_allowed = call_user_func_array("array_merge", $this->mimes);
        return (in_array($mime, $mime_allowed))? true : false;
    }

    /**
     * image_resize
     */
    public function image_resize($uploads, $file, $ext, $width = '', $height = '')
    {
        $default = [
            'thumbnail'     => ['width' => '150', 'height' => '150'],
            'medium'        => ['width' => '345', 'height' => '200'],
            'medium_large'  => ['width' => '500', 'height' => '400'],
            'large'         => ['width' => '1000', 'height' => '450'],
        ];
        $image_resize = Eventy::filter('filter_image_resize', $default);
        $attachment_file = [];
        foreach($image_resize as $key => $size)
        {
            $attachment_file[$key] = $this->thumbnail_imgsize($uploads, $file, $size['width'].'x'.$size['height'], $ext, $size['width'], $size['height']);
        }
            
        return $attachment_file;
    }

    /**
     * thumbnail_imgsize
     */
    public function thumbnail_imgsize($uploads,$fname,$att_name,$ext,$thumb_width = '150',$thumb_height = '150')
    {
        $fname = rtrim($fname, '.'.$ext);
        $extnew = ".".$ext;
        if(in_array($ext, $this->mime_resize) )
        {
            if($ext == 'jpg' or $ext == 'jpeg')
            {
                try {
                    $image = imagecreatefromjpeg($uploads['target'].$fname.$extnew);
                } catch (Exception $ex) {
                    $image= imagecreatefromstring(file_get_contents($uploads['target'].$fname.$extnew));
                }
            }
            elseif($ext == 'png')
            {
                try {
                    $image = imagecreatefrompng($uploads['target'].$fname.$extnew);
                } catch (Exception $ex) {
                    $image= imagecreatefromstring(file_get_contents($uploads['target'].$fname.$extnew));
                }
            }
            elseif($ext == 'gif')
            {
                try {
                    $image = imagecreatefromgif($uploads['target'].$fname.$extnew);
                } catch (Exception $ex) {
                    $image= imagecreatefromstring(file_get_contents($uploads['target'].$fname.$extnew));
                }
            }
            else
            {
                return $uploads['path'].$fname.$extnew;
            }

            $filename = $fname.'-'.$att_name.$extnew;
            $width = imagesx($image);
            $height = imagesy($image);
            $original_aspect = $width / $height;
            $thumb_aspect = $thumb_width / $thumb_height;
            if ( $original_aspect >= $thumb_aspect ){
               $new_height = $thumb_height;
               $new_width = $width / ($height / $thumb_height);
            } else {
               $new_width = $thumb_width;
               $new_height = $height / ($width / $thumb_width);
            }
            $thumb = imagecreatetruecolor($thumb_width,$thumb_height);
            $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
            imagefill($thumb, 0, 0, $transparent);
            imagesavealpha($thumb, true);
            imagecopyresampled($thumb,$image,0 - ($new_width - $thumb_width) / 2,0 - ($new_height - $thumb_height) / 2,0, 0,$new_width, $new_height,$width, $height);
            imagepng($thumb, $uploads['target'].$filename);
            return $uploads['path'].$filename;
        }
        else
        {
            return $uploads['path'].$fname.$extnew;
        }
    }
    
}
