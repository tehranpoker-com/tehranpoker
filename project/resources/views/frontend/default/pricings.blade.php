@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-pricings section-{{has_option('pricings', 'style')}} active">
    @include(get_extends('onepage.onepage_pricings'))
</section>
@endsection
