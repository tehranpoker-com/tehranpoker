@extends(get_extends('layouts.master'))
@section('content')
<section class="section-page animated section-faqs section-{{has_option('faqs', 'style')}} active">
    @include(get_extends('onepage.onepage_faqs'))
</section>
@endsection