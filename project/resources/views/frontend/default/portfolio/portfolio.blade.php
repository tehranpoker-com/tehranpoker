@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-portfolio section-{{has_option('portfolio', 'style')}} active">
@include(get_extends('onepage.onepage_portfolio'))
</section>
@endsection