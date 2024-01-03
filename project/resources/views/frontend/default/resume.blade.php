@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-resume section-{{has_option('resume', 'style')}} active">
    @include(get_extends('onepage.onepage_resume'))
</section>
@endsection