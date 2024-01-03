
<div class="tacf-input mt-3">
    <div class="tacf-repeater">
        <table class="tacf-table">
            <tbody class="tacf-ui-sortable">
                @if(is_array($widgets) and count($widgets))
                    @php $key = 0; @endphp
                    @foreach($widgets as $item)
                    <tr class="tacf-row">
                        <td class="tacf-field tacf-col-item">
                            <h3 class="tacf-head-item">
                                <span class="tacf-title-item">{{admin_lang($item['id'])}}</span> 
                                @if($item['toggle']) <span class="tacf-collapse-button tacf-position-1"><i class="fas fa-minus"></i></span> @else <span class="tacf-collapse-button"><i class="fas fa-plus"></i></span> @endif
                                <span class="tacf-row-handle tacf-action-handle order ui-sortable-handle tacf-position-2" title="{{admin_lang('move')}}"><i class="bx bx-move"></i></span>
                                <span class="tacf-status status-button status-button-switch  tacf-position-3" title="{{admin_lang('status')}}">
                                    <div class="form-check form-switch form-switch-sm form-switch-success" dir="ltr">
                                        <input class="form-check-input" type="checkbox" name="{{$input_name}}[{{$key}}][status]" value="1" @if(isset($item['status']) and $item['status']) checked="" @endif>
                                    </div>
                                </span>
                                <input type="hidden" name="{{$input_name}}[{{$key}}][id]" value="{{$item['id']}}">
                                <input type="hidden" class="tacf-toggle-input" name="{{$input_name}}[{{$key}}][toggle]" value="{{$item['toggle']}}">
                            </h3>
                            <div class="tacf-input tacf-toggle-content fadeIn @if(!$item['toggle']) d-none @endif">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{admin_lang('title')}}</label>
                                            <input type="text" name="{{$input_name}}[{{$key}}][title]" class="form-control tacf_toggle_title" value="{{$item['title']}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{admin_lang('icon')}}</label>
                                            <div class="megapanel-icon-select">
                                                <span class="megapanel-icon-preview"><i class="{{$item['icon']}}"></i></span>
                                                <button type="button" class="btn btn-primary waves-effect waves-light megapanel-icon-add" data-modal-title="{{admin_lang('icons')}}">{{admin_lang('changes')}}</button>
                                                <button type="button" class="btn  btn-danger waves-effect waves-light megapanel-icon-remove">{{admin_lang('remove')}}</button>
                                                <input type="hidden" name="{{$input_name}}[{{$key}}][icon]" value="{{$item['icon']}}" class="megapanel-icon-value tacf-input-key">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @php $key++; @endphp
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>