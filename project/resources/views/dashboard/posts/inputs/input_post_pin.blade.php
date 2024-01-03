<div class="form-group">
    <label>{{admin_lang('post_pin')}}</label>
    <div>
        <input type="checkbox" name="post_pin" value="1" class="custom-control-input" switch="bool" id="post_pin_switch" @if($post_pin) checked @endif>
        <label for="post_pin_switch" data-on-label="ON" data-off-label="OFF"></label>
    </div>
</div>