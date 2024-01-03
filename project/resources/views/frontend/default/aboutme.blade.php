@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-aboutme section-{{has_option('aboutme', 'style')}} active">
    @include(get_extends('onepage.onepage_aboutme'))
</section>
@endsection