@extends(get_extends('layouts.master'))
@section('content')
<div class="section-pages">
    <section id="blog">
        @include(get_extends('sections.section_articles'))
    </section>
</div>
@endsection