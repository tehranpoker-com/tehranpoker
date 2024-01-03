@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-support section-{{has_option('support', 'style')}} active">
    @include(get_extends('onepage.onepage_support'))
</section>
@endsection