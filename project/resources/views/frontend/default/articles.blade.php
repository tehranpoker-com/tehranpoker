@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-blog section-{{has_option('blog', 'style')}} active">
    @include(get_extends('onepage.onepage_blog'))
</section>
@endsection