@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-home section-bgimage section-{{has_option('homepage', 'style')}} {{has_option('homepage', 'textalign')}} active">
@include(get_extends('onepage.onepage_home'), ['widget' => ['widget' => 'home']])
</section>
@endsection