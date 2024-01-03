@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-contactme section-{{has_option('contactme', 'style')}} active">
    @include(get_extends('onepage.onepage_contactme'))
</section>
@endsection