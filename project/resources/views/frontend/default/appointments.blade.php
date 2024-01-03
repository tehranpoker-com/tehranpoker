@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-appointments section-{{has_option('appointments', 'style')}} active">
    @include(get_extends('onepage.onepage_appointments'))
</section>
@endsection
