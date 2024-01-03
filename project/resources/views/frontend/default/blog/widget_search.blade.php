<div class="widget search-widget">
    <div class="search-blog-input">
        <form action="">
            <div class="input">
                <input class="search-field" type="search" name="s" value="{{request()->get('s')}}" placeholder="{{lang('search_posts')}}">
                <button class="btn" type="submit"><i class="pe-7s-search"></i></button>
            </div>
        </form>
    </div>
</div>