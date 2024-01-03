<div class="tacf-input mt-3 mb-3">
    <div class="tacf-repeater">
        <table class="tacf-table">
            <tbody class="tacf-ui-sortable">
                @if(is_array($pagedesign) and count($pagedesign))
                    @php $key = 0; @endphp
                    @foreach($pagedesign as $item)
                    <tr class="tacf-row">
                        <td class="tacf-field tacf-col-item">
                            <h3 class="tacf-head-item">
                                <span class="tacf-title-item">{{admin_lang($item['id'])}}</span> 
                                <span class="tacf-row-handle tacf-action-handle order ui-sortable-handle tacf-position-1" title="{{admin_lang('move')}}"><i class="bx bx-move"></i></span>
                                <span class="tacf-status status-button status-button-switch tacf-position-2" title="{{admin_lang('status')}}">
                                    <div class="form-check form-switch form-switch-sm form-switch-success" dir="ltr">
                                        <input class="form-check-input" type="checkbox" name="{{$input_name}}[{{$key}}][status]" value="1" @if(isset($item['status']) and $item['status']) checked="" @endif>
                                    </div>
                                </span>
                                <input type="hidden" name="{{$input_name}}[{{$key}}][id]" value="{{$item['id']}}">
                            </h3>
                        </td>
                    </tr>
                    @php $key++; @endphp
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
