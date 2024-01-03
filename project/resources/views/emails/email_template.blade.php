<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">body{line-height: 1.4; margin: 0; padding: 0; width: 100% !important;background: #edf2f7;margin: 0;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';line-height:1.7;font-size: 13px;height: 100%;}strong {font-weight: 500;}.mail_title, .mail_subtitle {font-weight: 500;margin: 0;}blockquote{box-sizing: border-box;padding: 2px;width: 90%;max-width: 860px;margin: 40px auto;border: 1px solid #ddd;background: #fff;}.warp-box{background: #FFFFFF;padding: 30px;color: #464646;}.msg-box{border-top: 1px solid #e8e5ef;margin-top: 25px;padding-top: 25px;}</style>
</head>
<body>
<blockquote {!! (config('lang.direction')=='rtl' ) ? ' dir="rtl"' : ' dir="ltr"' !!}>
    <div class="warp-box">@yield('content')</div>
</blockquote>
</body>
</html>