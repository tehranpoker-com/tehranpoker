<div class="section-body">
    <div class="container">
        <div class="section-inner">
            <div class="section-title">
                <h2>{{get_post_title($page_id)}}</h2>
                <p>{{get_post_column($page_id, 'post_excerpts')}}</p>
                <div class="divider"></div>
            </div>
            <div class="mt-30 mb-30">
                {!! get_post_column($page_id, 'post_content') !!}
            </div>
        </div>
    </div>
</div>