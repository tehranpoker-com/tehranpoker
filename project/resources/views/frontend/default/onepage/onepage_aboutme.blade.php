<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('aboutme', 'page_title')}}</h2>
                <p>{{has_option('aboutme', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            @foreach (has_option('aboutme', 'pagedesign') as $box)
            @if(isset($box['status']))
            @include(get_extends('sections.section_'.$box['id']))
            @endif
            @endforeach
        </div>
    </div>
</div>