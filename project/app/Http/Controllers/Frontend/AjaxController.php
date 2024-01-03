<?php
/**
 * Project: Basma - Resume / CV CMS
 * @link http://themearabia.net
 * @copyright 2022
 * @author Hossam Hamed <themearabia@gmail.com> <0201094140448>
 * @version 1.5
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AjaxController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ajax_request
     * - portfolio-loadmore
     */
    public function ajax_request(Request $request)
    {
        if($request->has('action') && $request->get('action') == 'portfolio-loadmore') {
            $paged = intval($request->get('paged')) + 1;
            $paginate = has_option('portfolio', 'limitloadmore');
            $posts = $this->get_portfolio_query('portfolio')->orderBy('post_modified', 'DESC')->paginate($paginate, '', '', $paged);
            $hidemore = ($posts->lastPage() >= ($paged+1) )? true : false;
            if ($paged and $paged > $posts->lastPage()) {
                return response()->json(['status' => false, 'paged' => $paged, 'hidemore' => $hidemore, 'html' => '']);
            }
            else {
                $data['posts'] = $posts;
                $html = get_view('portfolio.ajax_more_portfolio', $data)->render();
                return response()->json(['status' => true, 'paged' => $paged, 'hidemore' => $hidemore, 'html' => $html]);
            }
        }
    }

}
