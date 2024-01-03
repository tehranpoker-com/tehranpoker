<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{has_option('resume', 'page_title')}}</h2>
                <p>{{has_option('resume', 'page_subtitle')}}</p>
                <div class="divider"></div>
            </div>
            @if(has_option('resume', 'download_status'))
            <a href="{{has_option('resume', 'download_url')}}" target="_blank" class="download-resume" title="{{lang('download_resume')}}">
                <i class="{{has_option('resume', 'download_icon')}}"></i><span class="download-overlay"></span>
            </a>
            @endif
            @foreach (has_option('resume', 'pagedesign') as $box)
            @if(isset($box['status']))
            @include(get_extends('sections.section_'.$box['id']))
            @endif
            @endforeach
        </div>
    </div>
</div>