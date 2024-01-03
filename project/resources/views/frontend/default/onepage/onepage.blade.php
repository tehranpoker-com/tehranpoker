@extends(get_extends('layouts.master'))
@section('content')
@foreach (has_option('sidebar_menu') as $key => $item)
@if(isset($item['status']) and $item['status'] and $item['widget'])
<section id="{{get_class_section($item['widget'])}}" class="section-page animated section-{{get_class_section($item['widget'])}} @if($item['widget'] == 'home') {{has_option('homepage', 'textalign')}} section-bgimage active @elseif(get_pageid_section($item['widget'])) section-{{get_post_meta('style', get_pageid_section($item['widget']))}} @else section-{{has_option($item['widget'], 'style')}} @endif">
@include(get_extends('onepage.onepage_'.get_name_section($item['widget'])), ['widget' => $item, 'page_id' => get_pageid_section($item['widget'])])
</section>
@endif
@endforeach
@endsection