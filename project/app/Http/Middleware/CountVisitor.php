<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use hisorange\BrowserDetect\Parser as Browser;

class CountVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip     = md5(GetRealIp());
        $count  = DB::table(VISITOR_TABLE)->where('date', today())->where('ip', $ip)->count();
        if (!$count) {
            DB::table(VISITOR_TABLE)->insertGetId([
                'date'              => today(),
                'ip'                => $ip,
                'timein'            => time(),
                'platformname'      => Browser::platformName(),
                'platformfamily'    => Browser::platformFamily(),
                'browserfamily'     => Browser::browserFamily(),
                'ismobile'          => Browser::isMobile(),
                'istablet'          => Browser::isTablet(),
                'isdesktop'         => Browser::isDesktop(),
                'isbot'             => Browser::isBot(),
                'ischrome'          => Browser::isChrome(),
                'isfirefox'         => Browser::isFirefox(),
                'isopera'           => Browser::isOpera(),
                'issafari'          => Browser::isSafari(),
                'isie'              => Browser::isIE(),
                'isedge'            => Browser::isEdge(),
                'devicefamily'      => Browser::deviceFamily(),
            ]);
        }
        else {
            DB::table(VISITOR_TABLE)->where('ip', $ip)->where('date', today())->update(['timein' => time(), 'online' => '1']);
        }
        $timein = time() - (60*60*5);
        DB::table(VISITOR_TABLE)->where([['timein', '<', $timein]])->update(['timein' => time(), 'online' => '0']);
        return $next($request);
    }
}