<div class="form-group">
    <label>{{ admin_lang('categories') }}</label>
    <select class="form-select" name="term_id">
        @foreach ($categories as $cate)
        <option value="{{ $cate->id }}" @if(isset($post->term_id) and $cate->id == $post->term_id) selected="" @endif>{{ $cate->name }}</option>
        @endforeach
    </select>
</div>