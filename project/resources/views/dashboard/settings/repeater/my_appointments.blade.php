@foreach($appointments_work as $key => $item)
<div class="megapanel-col-item">
    <div class="row form-group">
        <div class="col-sm-2">
            <label>{{admin_lang($key)}}</label>
            <div class="input-group">
                {!! setting_input_radio(['1' => admin_lang('on'), '0' => admin_lang('off') ], $input_name.'['.$key.'][status]', $item['status'], 'onoff') !!}
            </div>
        </div>
        <div class="col-sm-5">
            <label class="control-label" for="field-1">{{admin_lang('start_time')}}</label>
            <div class="input-group" id="timepicker-input-group-awstart{{$key}}">
                <span class="input-group-text"><i class="bx bx-time-five"></i></span>
                <input type="text" name="{{$input_name}}[{{$key}}][start]" value="{{$item['start']}}" class="form-control timepicker" data-key="awstart{{$key}}" data-template="dropdown" data-show-meridian="true" data-minute-step="5">
            </div>
        </div>
        <div class="col-sm-5">
            <label class="control-label" for="field-1">{{admin_lang('end_time')}}</label>
            <div class="input-group" id="timepicker-input-group-awend{{$key}}">
                <span class="input-group-text"><i class="bx bx-time-five"></i></span>
                <input type="text" name="{{$input_name}}[{{$key}}][end]" value="{{$item['end']}}" class="form-control timepicker" data-key="awend{{$key}}" data-template="dropdown" data-show-meridian="true" data-minute-step="5">
            </div>
        </div>
    </div>
</div>
@endforeach