<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {!! (config('lang.direction')=='rtl' ) ? ' dir="rtl"' : '' !!}>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (isset($page_title))? $page_title. ' | ' : '' }}{{get_option('sitename')}}</title>
    <link rel="icon" href="{{has_option('style', 'favicon')}}">
    <style type="text/css">
     * {outline: none;}html {font-size: 15px;-webkit-text-size-adjust: none;}::-webkit-scrollbar {width: 10px;background: rgba(0, 0, 0, 0) }::-webkit-scrollbar-track-piece {border-radius: 5px;background: rgba(0, 0, 0, 0) }::-webkit-scrollbar-thumb {height: 30px;border-radius: 5px;background: rgba(0, 0, 0, 0) }@media only screen and (min-width: 991px) {::-webkit-scrollbar {background: rgba(0, 0, 0, 0) }::-webkit-scrollbar-thumb {background: #CCCCCC;}}body {position: relative;margin: 0;font-family: Roboto, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif;font-size: 16px;color: #6b6b6b;font-weight: 300;line-height: 1.75;background: #F0F0F0;}h1, h2, h3, h4, h5, h6 {margin: 0 0 1rem;font-weight: 400;font-style: normal;line-height: 1.21;color: #444;}h1 {font-size: 3.052em;}h2 {font-size: 2.441em;}h3 {font-size: 1.953em;}h4 {font-size: 1.563em;}h5 {font-size: 1.25em;margin: 0 0 0.8rem;}.slider {background-size: cover;position: relative;background-attachment: fixed;display: table;table-layout: fixed;width: 100%;overflow: hidden;height: 100vh;}.slider:before {content: '';position: absolute;left: 0;top: 0;width: 100%;height: 100%;background: rgba(14, 14, 14, 0.5);}.slider .content {z-index: 999;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);text-align: center;}.slider .content span {font-size: 32px;color: #fff;}.slider .content h1 {font-size: 52px;color: #fff;margin-bottom: 35px;}.slider .content p {margin: 0 0 30px;color: #fff;font-size: 18px;font-weight: 300;}.slider a {display: inline-block;position: absolute;bottom: 30px;z-index: 13;left: 50%;transform: translateX(-50%);user-select: none;color: #fff;}.slider a i {font-size: 12px;padding-left: 10px;-webkit-animation: mover 1s infinite alternate;animation: mover 1s infinite alternate;}#wrapper.coming-soon {text-align: center;min-height: 100vh;position: relative;width: 100%;}.coming-soon header {background: rgba(255, 255, 255, 0.5);padding: 10px 0;text-align: center;}.coming-soon h2 {color: #fff;}#coming-soon .countdown {display: inline-block;border: 2px solid #ffffff;position: relative;padding: 20px;margin: 15px 15px 15px 15px;color: #2c2c2c;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;}#coming-soon .countdown > div {display: table-cell;vertical-align: middle;width: 80px;}#coming-soon .countdown > div span:first-child {font-size: 42px;line-height: 42px;display: block;color: #fff;margin-bottom: 10px;}#coming-soon .countdown > div span:last-child {font-size: 18px;color: #fff;}
    .coming-soon .slider{background-image: url({{has_option('maintenance', 'bgimage')}});}
    </style>
</head>
<body>
    <div id="wrapper" class="coming-soon">
        <section class="slider">
            <div class="content">
                <h2 id="count2">{{has_option('maintenance', 'title')}}</h2>
                <p>{!!nl2br(e(has_option('maintenance', 'message')))!!}</p>
                @if(has_option('maintenance', 'timer_status'))
                <div id="coming-soon">
                    <div class="countdown">
                        <div>
                            <span id="dday"></span>
                            <span id="days">Days</span>
                        </div>
                    </div>
                    <div class="countdown">
                        <div>
                            <span id="dhour"></span>
                            <span id="hours">Hours</span>
                        </div>
                    </div>
                    <div class="countdown">
                        <div>
                            <span id="dmin"></span>
                            <span id="minutes">Mins</span>
                        </div>
                    </div>
                    <div class="countdown">
                        <div>
                            <span id="dsec"></span>
                            <span id="seconds">Secs</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
    @if(has_option('maintenance', 'timer_status'))
    <script>
    var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
    function countdown(yr,m,d) {
        theyear=yr;themonth=m;theday=d
        var today=new Date()
        var todayy=today.getYear()
        if (todayy < 1000)
        todayy+=1900
        var todaym=today.getMonth()
        var todayd=today.getDate()
        var todayh=today.getHours()
        var todaymin=today.getMinutes()
        var todaysec=today.getSeconds()
        var todaystring=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec
        futurestring=montharray[m-1]+" "+d+", "+yr
        dd=Date.parse(futurestring)-Date.parse(todaystring)
        dday=Math.floor(dd/(60*60*1000*24)*1)
        dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1)
        dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1)
        dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1)
        if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=0){
            document.getElementById('coming-countdown').innerHTML=current;
            document.getElementById('coming-countdown').style.display="block";
            document.getElementById('dday').style.display="none";
            document.getElementById('dhour').style.display="none";
            document.getElementById('dmin').style.display="none";
            document.getElementById('dsec').style.display="none";
            document.getElementById('days').style.display="none";
            document.getElementById('hours').style.display="none";
            document.getElementById('minutes').style.display="none";
            document.getElementById('seconds').style.display="none";
            document.getElementById('coming-soon').style.display="none";
            return
        }else{
            document.getElementById('dday').innerHTML=dday;
            document.getElementById('dhour').innerHTML=dhour;
            document.getElementById('dmin').innerHTML=dmin;
            document.getElementById('dsec').innerHTML=dsec;
            setTimeout("countdown(theyear,themonth,theday)",1000);
        }
    }
    var current = "";
    countdown({{date('Y', strtotime(has_option('maintenance', 'date')))}},{{date('m', strtotime(has_option('maintenance', 'date')))}},{{date('d', strtotime(has_option('maintenance', 'date')))}});
    </script>
    @endif
</body>
</html>