@section('head_style')
<link rel="stylesheet" href="{{ asset('libs/article/article-editor.min.css') }}" />
@endsection
@section('admin_script')
<script src="{{ asset('libs/article/article-editor.js') }}"></script>
<script src="{{ asset('libs/article/lang/'.$admin_lang.'.js') }}"></script>
<script src="{{ asset('libs/article/plugins/blockcode.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/counter.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/imageposition.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/imageresize.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/inlineformat.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/medialibrary.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/print.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/removeformat.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/reorder.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/selector.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/specialchars.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/textdirection.min.js') }}"></script>
<script src="{{ asset('libs/article/plugins/underline.min.js') }}"></script>
@endsection
@section('script_code')
<script>
    var token = '{{ csrf_token() }}';
    ArticleEditor('.articleeditor-content', {
        editor: {lang: '{{$admin_lang}}'},
        css: '{{asset('libs/article')}}/',
        classes: {img: 'img-fluid'},
        plugins: ['blockcode', 'counter', 'imageposition', 'imageresize', 'inlineformat', 'medialibrary', 'print', 'removeformat', 'reorder', 'selector', 'specialchars', 'style', 'textdirection', 'underline'],
        custom: {css: ['{{ asset('libs/article/article-custom.min.css') }}', '{{ asset('dashboard/css/bootstrap.min.css') }}']},
        grid: {
            classname: 'row',
            columns: 12,
            gutter: '1px',
            offset: {
                left: '15px',
                right: '15px'
            },
            patterns: {
                '6|6': 'col-md-6|col-md-6',
                '4|4|4': 'col-md-4|col-md-4|col-md-4',
                '3|3|3|3': 'col-md-3|col-md-3|col-md-3|col-md-3',
                '2|2|2|2|2|2': 'col-md-2|col-md-2|col-md-2|col-md-2|col-md-2|col-md-2',
                '3|6|3': 'col-md-3|col-md-6|col-md-3',
                '2|8|2': 'col-md-2|col-md-8|col-md-2',
                '5|7': 'col-md-5|col-md-7',
                '7|5': 'col-md-7|col-md-5',
                '4|8': 'col-md-4|col-md-8',
                '8|4': 'col-md-8|col-md-4',
                '3|9': 'col-md-3|col-md-9',
                '9|3': 'col-md-9|col-md-3',
                '2|10': 'col-md-2|col-md-10',
                '10|2': 'col-md-10|col-md-2',
                '12': 'col-md-12'
            }
        },
        image: {drop: false},      
    });
</script>
@endsection