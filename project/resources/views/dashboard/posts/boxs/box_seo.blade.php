<div class="form-group">
    <label>{{ admin_lang('tags') }}</label>
    <div class="megapanel-field">
        <input type="text" name="post_tags" placeholder="{{admin_lang('tags')}}" value="{{$post_tags}}" class="form-control" />
    </div>
</div>
<div class="form-group">
    <label>{{ admin_lang('meta_description') }}</label>
    <div class="megapanel-field">
        <textarea name="postmeta[meta_desc]" placeholder="{{admin_lang('meta_description')}}" class="form-control">{{$meta_desc}}</textarea>
    </div>
</div>