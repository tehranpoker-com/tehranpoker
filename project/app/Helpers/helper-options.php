<?php
/**
 * options v1.5
 */

function fields_start_options($title){
    return '
    <div class="megapanel-options-head-items">
    <h3><span class="megapanel-title-item">'.$title.'</span><span class="megapanel_tools collapse-button"><i class="fa fa-minus"></i></span></h3>
    <div class="megapanel-options-content megapanel-toggle-content ">
    ';
}

function fields_end_options(){
    return '</div></div>';
}

function field_options_item($input, $echo = true){
    switch($input['type']){
        case"border":
            return '<hr />';
        break;
        case"html":
            return field_option_html($input, $echo);
        break;
        case"label":
            return field_text_label($input, $echo);
        break;
        case"hidden":
            return field_hidden_input($input, $echo);
        break;
        case"link":
            return field_link_input($input, $echo);
        break;
        case"button":
            return field_button_input($input, $echo);
        break;
        case"text":
            return field_text_input($input, $echo);
        break;
        case"fields_groups":
            return fields_groups($input, $echo);
        break;
        case"input_group":
            return field_text_input_group($input, $echo);
        break;
        case"text_group":
            return field_text_group($input, $echo);
        break;
        case"password":
            return field_password_input($input, $echo);
        break;
        case"textarea":
            return field_textarea_input($input, $echo);
        break;
        case"textarea_full":
            return field_textarea_full_input($input, $echo);
        break;
        case"code_editor":
            return field_code_editor_input($input, $echo);
        break;
        case"select":
            return field_select_input($input, $echo);
        break;
        case"checkbox":
            return field_checkbox_input($input, $echo);
        break;
        case"checkbox_group":
            return field_checkbox_group($input, $echo);
        break;
        case"checkbox_array":
            return field_checkbox_array_input($input, $echo);
        break;
        case"text_checkbox":
            return field_text_checkbox_input($input, $echo);
        break;
        case"number":
            //return field_number_input($input, $echo);
        break;
        case"slider_number":
            return field_slider_number_input($input, $echo);
        break;
        case"checkbox_post_types":
            //return field_checkbox_post_types_input($input, $echo);
        break;
        case"radio":
            return field_radio_input($input, $echo);
        break;
        case"color":
            return field_color_input($input, $echo);
        break;
        case"date":
            return field_date_input($input, $echo);
        break;
        case"skinscolor":
            return field_skinscolor_input($input, $echo);
        break;
        case"skinscolor_free":
            return field_skinscolor_input_free($input, $echo);
        break;
        case"upload":
            return field_upload_input($input, $echo);
        break;
        case"fonticon":
            return field_fieldicon_input($input, $echo);
        break;
        case"typography":
            return field_typography_inputs($input, $echo);
        break;
        case"select_animate":
            return field_select_animate($input, $echo);
        break;
    }
}

function field_option_html($input,$echo = true){
    if( $echo ){ echo $input['html']; } else{ return $input['html']; }
}

function get_selected($value, $key){
    if(is_array($value)){
        return (in_array($key, $value))? 'selected=""' : '';
    }
    else {
        return ($value == $key)? 'selected=""' : '';
    }
}

function get_checked($value, $key){
    return ($value === $key)? 'checked=""' : '';
}

function get_checked_in_array($value, $keys, $echo = true){
    return (in_array($value, $keys))? 'checked=""' : '';
}

function field_slider_number_input($input,$echo = true){
    if(!isset($input['step'])){$input['step'] = '1';}
    if(!isset($input['min'])){$input['min'] = '1';}
    if(!isset($input['max'])){$input['max'] = '20';}
    $input_class    = (isset($input['input_class']))? $input['input_class'] : '' ;
    $checkbox_class = (isset($input['checkbox_class']))? $input['input_class'] : '' ;
    $help           = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $inputid        = str_replace(array('[', ']'), '', $input['id']);
    $box_class = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $html = '<div class="'.$box_class.'">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field-slider">
            <div class="slider_num '.$inputid.'" id="'.$inputid.'"></div>
            <input id="'.$inputid.'_input" class="width80 text-center" type="text" name="'.$input['id'].'" value="'.$input['value'].'">
        </div>
    </div>
    <script>
      jQuery(document).ready(function() {
        jQuery(".'.$inputid.'").slider({
            range:"min", min:'.$input['min'].', max:'.$input['max'].',step:'.$input['step'].', value:'.$input['value'].',
            slide: function(event, ui) {jQuery("#"+jQuery(this).attr("id")+"_input").val(ui.value);}
        });
      });
    </script>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_text_checkbox_input($input, $echo = true){
    $input_class = (isset($input['input_class']))? $input['input_class'] : '' ;
    $checkbox_class = (isset($input['checkbox_class']))? $input['input_class'] : '' ;
    $help  = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $html  = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <input type="text" name="'.$input['input_id'].'" class="'.$input_class.'" value="'.$input['input_value'].'">
            <input type="checkbox" class="checkbox-on-of '.$checkbox_class.'" name="'.$input['checkbox_id'].'" '.get_checked( $input['checkbox_value'], '1', false ).'>
            '.$help.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_text_label($input, $echo = true){
    $html  = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="col-md-9">
            <strong>'.$input['value'].'</strong>
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_hidden_input($input, $echo = true){
    $html  = '<input type="hidden" name="'.$input['id'].'" value="'.$input['value'].'">';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_link_input($input, $echo = true){
    $align  = (isset($input['align']))? $input['align'] : '' ;
    $class  = (isset($input['class']))? 'class="'.$input['class'].'"' : '' ;
    $dir    = (isset($input['dir']))? 'dir="'.$input['dir'].'"' : '' ;
    $url    = (isset($input['url']))?  $input['url'] : 'javascript: void(0);' ;
    $text    = (isset($input['text']))?  $input['text'] : '' ;
    
    $html   = '
    <div class="megapanel-col-item '.$align.'">
        <a href="'.$url.'" '.$class.' '.$dir.'>'.$text.'</a>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_button_input($input, $echo = true){
    $align      = (isset($input['align']))? $input['align'] : '' ;
    $class      = (isset($input['class']))? 'class="'.$input['class'].'"' : '' ;
    $value      = (isset($input['value']))? 'value="'.$input['value'].'"' : '' ;
    $dir        = (isset($input['dir']))? 'dir="'.$input['dir'].'"' : '' ;
    $name       = (isset($input['name']))? 'name="'.$input['name'].'"' : '' ;
    $button     = (isset($input['button']))? 'type="'.$input['button'].'"' : 'type="button"' ;
    $text       = (isset($input['text']))?  $input['text'] : '' ;
    $confirm    = (isset($input['confirm']))?  'onclick="return confirm(\''.$input['confirm'].'\')"' : '' ;
    $html       = '<div class="megapanel-col-item '.$align.'" '.$confirm.'><button '.$button.' '.$name.' '.$value.' '.$class.' '.$dir.'>'.$text.'</button></div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_text_input($input, $echo = true){
    $class  = (isset($input['class']))? $input['class'] : '' ;
    $dir    = (isset($input['dir']))? 'dir="'.$input['dir'].'"' : '' ;
    $desc   = (isset($input['desc']))? '<div class="text-desc">'.$input['desc'].'</div>' : '';
    $help   = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $html   = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <input type="text" name="'.$input['id'].'" class="'.$class.'" '.$dir.' value="'.$input['value'].'">
            '.$desc.'
            '.$help.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_text_input_group($input, $echo = true){
    $options        = (isset($input['options']) and is_array($input['options']))? true : false ;
    $class          = (isset($input['class']))? $input['class'] : '' ;
    $dir            = (isset($input['dir']))? 'dir="'.$input['dir'].'"' : '' ;
    $desc           = (isset($input['desc']))? '<div class="text-desc">'.$input['desc'].'</div>' : '';
    $help           = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $box_class      = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $box_class2     = (isset($input['box_class2']))? $input['box_class2'] : 'megapanel-field';
    $inputgrouptext = (isset($input['grouptext']))? $input['grouptext'] : false;
    
    $html       = '';
    $options_html = '';
   
    if($options){
        if($inputgrouptext){
            $options_html .= '';
        }

        foreach($input['options'] as $option){
            $grouptext      = (isset($option['grouptext']))? $option['grouptext'] : $inputgrouptext;
            $inputbox_class = (isset($option['box_class']))? $option['box_class'] : '';
            $option_name    = (isset($option['name']))? '<label>'.$option['name'].'</label>' : '';
            $option_type    = (isset($option['type']))? $option['type'] : 'text';
            if($inputgrouptext){
               
                $options_html .= '
                <div class="input-group mb-2 '.$inputbox_class.'">
                '.$option_name.'
                <input type="'.$option_type.'" name="'.$option['id'].'" class="'.$class.'" '.$dir.' value="'.$option['value'].'">
                <div class="input-group-text">'.$grouptext.'</div>
                </div>
                ';
            }
            else{
                $options_html .= '
                <div class="mb-2 '.$inputbox_class.'">
                    '.$option_name.'
                    <input type="text" name="'.$option['id'].'" class="'.$class.'" '.$dir.' value="'.$option['value'].'">
                </div>
                ';
            }
        }

        if($inputgrouptext){
            $options_html .= '';
        }
    }
    $html = '<div class="'.$box_class.'">
        <label>'.$input['name'].'</label>
        <div class="'.$box_class2.'">
        '.$options_html.'
        </div>'.$help.'
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function fields_groups($input, $echo = true){
    $options = (isset($input['options']) and is_array($input['options']))? true : false ;
    $options_html = '';
    if($options){
        foreach($input['options'] as $option){
            $options_html .= field_options_item($option, false);
        }
    }

    $html   = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            '.$options_html.'
        </div>
    </div>';
    
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_text_group($input, $echo = true){
    $class  = (isset($input['class']))? $input['class'] : '' ;
    $dir    = (isset($input['dir']))? 'dir="'.$input['dir'].'"' : '' ;
    $desc   = (isset($input['desc']))? '<div class="text-desc">'.$input['desc'].'</div>' : '';
    $grouptext   = (isset($input['grouptext']))? $input['grouptext'] : '';
    $help   = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $html   = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <div class="input-group mb-2 mr-sm-3">
                <div class="input-group-text">'.$grouptext.'</div>
                <input type="text" name="'.$input['id'].'" class="'.$class.'" '.$dir.' value="'.$input['value'].'">
            </div>
            '.$desc.'
            '.$help.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_password_input($input, $echo = true){
    $class = (isset($input['class']))? $input['class'] : '' ;
    $place = (isset($input['place']))? 'placeholder="'.$input['place'].'"' : '' ;
    $autoc = (isset($input['autoc']))? $input['autoc'] : '' ;
    $help  = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $html  = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <input type="password" name="'.$input['id'].'" class="'.$class.'" dir="ltr" '.$place.' '.$autoc.' value="'.$input['value'].'">'.$help.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_textarea_input($input, $echo = true){
    $rows = (isset($input['rows']))? 'rows="'.$input['rows'].'"' : 'rows="3"' ;
    $dir = (isset($input['dir']))? 'dir="'.$input['dir'].'"' : '' ;
    
    $class = (isset($input['class']))? $input['class'] : '' ;
    $help = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $html = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <textarea name="'.$input['id'].'" class="'.$class.'" type="textarea" '.$dir.' '.$rows.'>'.$input['value'].'</textarea>'.$help.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_textarea_full_input($input, $echo = true){
    $rows       = (isset($input['rows']))? 'rows="'.$input['rows'].'"' : 'rows="3"' ;
    $id         = (isset($input['id']))? 'name="'.$input['id'].'"' : '' ;
    $help       = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $htmlmore   = (isset($input['htmlmore']))? $input['htmlmore'] : '' ;
    $label      = (isset($input['name']))? '<label>'.$input['name'].'</label>' : '';
    $setid      = (isset($input['setid']))? ' id="'.$input['setid'].'"' : '';
    $html = '<div class="megapanel-col-item">
        '.$label.'
        <div class="clearfix-5"></div>
        <div class="megapanel-field megapanel-full-field">
            <textarea '.$id.' '.$setid.' type="textarea" '.$rows.'>'.$input['value'].'</textarea>'.$help.'
            '.$htmlmore.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_code_editor_input($input, $echo = true){
    $settings = array(
        'tabSize'       => 2,
        'lineNumbers'   => true,
        'theme'         => 'default',
        'mode'          => 'htmlmixed',
        'cdnURL'        => 'https://cdn.jsdelivr.net/npm/codemirror@5.59.2',
      );

    $rows       = (isset($input['rows']))? 'rows="'.$input['rows'].'"' : 'rows="3"' ;
    $id         = (isset($input['id']))? 'name="'.$input['id'].'"' : '' ;
    $help       = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $htmlmore   = (isset($input['htmlmore']))? $input['htmlmore'] : '' ;
    $html = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="clearfix-5"></div>
        <div class="megapanel-field megapanel-full-field">
            <textarea '.$id.' type="textarea" '.$rows.' data-editor="'.json_encode( $settings ).'">'.$input['value'].'</textarea>'.$help.'
            '.$htmlmore.'
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_select_input($input, $echo = true){
    $help = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $class = (isset($input['class']))? $input['class'] : '' ;
    $multiple = (isset($input['multiple']))? 'multiple' : '' ;
    $box_class = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $box_class2 = ($box_class == 'megapanel-col-item')? 'class="megapanel-field"' : '';
    $html = '<div class="'.$box_class.'">
    <label>'.$input['name'].'</label>
    <div '.$box_class2.'><select name="'.$input['id'].'" class="'.$class.'" '.$multiple.'>';
    if(isset($input['options_html']))
    {
        $html .= $input['options_html'];
    }
    else
    {
        foreach($input['options'] as $key => $value)
        {
            if(isset($input['options_type']) and $input['options_type'] == 'posts') {
                $html .= '<option value="'.$value->id.'" '.get_selected( $input['value'], $value->id, false ).'>'.$value->post_title.'</option>';
            }
            else {
                $html .= '<option value="'.$key.'" '.get_selected( $input['value'], $key, false ).'>'.$value.'</option>';
            }
        }
    } 
    $html .= '<select>'.$help.'</div></div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_checkbox_input($input, $echo = true){
    $options    = (isset($input['options']) and is_array($input['options']))? true : false ;
    $help       = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $on_active  = (get_checked( $input['value'], '1', false ))? 'active' : '';
    $off_active = (get_checked( $input['value'], '0', false ))? 'active' : '';
    $ontext     = (isset($input['ontext']))? $input['ontext'] : admin_lang('on') ;
    $offtext    = (isset($input['offtext']))? $input['offtext'] : admin_lang('off') ;
    $box_class = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $html = '<div class="'.$box_class.'">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <div class="megapanel-buttons-options">
                <button type="button" data-value="1" class="option-on '.$on_active.'">'.$ontext.'</button>
                <button type="button" data-value="0" class="option-off '.$off_active.'">'.$offtext.'</button>
                <input type="hidden" name="'.$input['id'].'" value="'.$input['value'].'">
            </div>
        </div>
        '.$help.'
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_checkbox_group($input, $echo = true){
    $options    = (isset($input['options']) and is_array($input['options']))? true : false ;
    $help       = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    
    
    $options_html = '';
    if($options){
        foreach($input['options'] as $option){
            $ontext     = (isset($option['ontext']))? $option['ontext'] : admin_lang('on') ;
            $offtext    = (isset($option['offtext']))? $option['offtext'] : admin_lang('off') ;
            $on_active  = (get_checked( $option['value'], '1', false ))? 'active' : '';
            $off_active = (get_checked( $option['value'], '0', false ))? 'active' : '';

            $options_html .= '
            <div class="megapanel-buttons-options mb-3">
                <button type="button" data-value="1" class="option-on '.$on_active.'">'.$ontext.'</button>
                <button type="button" data-value="0" class="option-off '.$off_active.'">'.$offtext.'</button>
                <input type="hidden" name="'.$option['id'].'" value="'.$option['value'].'">
                '.$option['name'].'
            </div>
            ';
        }
    }

    $html = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            '.$options_html.'
        </div>'.$help.'
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_checkbox_array_input($input, $echo = true){
    $options    = (isset($input['options']) and is_array($input['options']))? true : false ;
    $help       = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $ontext     = (isset($input['ontext']))? $input['ontext'] : admin_lang('on') ;
    $offtext    = (isset($input['offtext']))? $input['offtext'] : admin_lang('off') ;
    $box_class  = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    if($options)
    {
        $input['value'] = (isset($input['value']))? $input['value'] : array();
        $counoption = count($input['options']);
        $checkbox = '';
        $i = 0;
        foreach($input['options'] as $option)
        {
            $i++;
            if($i > 1 ) {
                $checkbox .= '<br />';
            }
            $checkbox .= '
                <input type="checkbox" name="'.$option['id'].'" id="'.$option['id'].'-'.$i.'" value="'.$option['value'].'" '.get_checked_in_array( $option['value'], $input['value'], false ).'>&nbsp;&nbsp;
                <strong><label for="'.$option['id'].'-'.$i.'">'.$option['name'].'</label></strong> 
            ';
        }
    }

    $html = '<div class="'.$box_class.'">
        <label>'.$input['name'].'</label>
        <div class="megapanel-buttons-options">
            '.$checkbox.'
        </div>'.$help.'
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_boxs_sortable_input($input, $echo = true){
    $options   = (isset($input['options']) and is_array($input['options']))? $input['options'] : [];
    $box_class = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $modal_title    = (isset($input['modal_title']))? $input['modal_title'] : '-';
    $modal_size     = (isset($input['modal_size']))? $input['modal_size'] : 'normal';
    $modal_search   = (isset($input['modal_search']))? $input['modal_search'] : '';
    $data_key       = (isset($input['option_key']))? $input['option_key'] : '';
    $data_name      = (isset($input['option_name']))? $input['option_name'] : '';
    $data_action    = (isset($input['option_action']))? $input['option_action'] : '';

    $checkbox  = '';
    $i = 0;
    foreach($options as $option){
        $checkbox .= '
        <li class="tacf-row-sub">
        <span class="ui-sortable-handle-sub" title="move"><i class="bx bx-move"></i></span>
        <span class="tacf-remove-sub" title="Remove"><i class="bx bxs-trash-alt"></i></span>
            <input type="hidden" name="'.$input['id'].'" value="'.$option['id'].'">
            <label>'.$option['title'].'</label>
        </li>
        ';
    }

    $html = '<div class="'.$box_class.'">
        <label>'.$input['name'].'</label>
        <span class="add-element-widget-boxs" data-modal-title="'.$modal_title.'" data-modal-size="'.$modal_size.'" data-modal-search="'.$modal_search.'" data-action="'.$data_action.'" data-opkey="'.$data_key.'" data-opname="'.$data_name.'">'.admin_lang('add_box').'</span>
        <div class="megapanel-sortable-options">
            <ul class="tacf-boxs-sortable ul-element-widget">'.$checkbox.'</ul>
        </div>
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }

}

function field_radio_input($input, $echo = true){
    $help = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '' ;
    $box_class = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $label_name = (isset($input['name']))? '<label>'.$input['name'].'</label>' : '';
    $html = '<div class="'.$box_class.'">'.$label_name.'<div class="megapanel-buttons-options">';
    $counoption = count($input['options']);
    $i = 0;
    $labelafter = (isset($labelafter))? $labelafter : '';
    $class = '';
    
    foreach($input['options'] as $key => $value){
        $i++;
        if(is_array($value)){
            if(isset($value['img'])){
                $class = 'boximg';
                $width = (isset($input['options_width']))? 'width="'.$input['options_width'].'"' : '';
                $labelafter = '<div class="option-boximg"><img src="'.$value['img'].'" '.$width.' /></div>';
            }
            else{
                $class = (isset($value['boxcolor']))? 'boxcolor' : '';
            }
            if(isset($value['boxcolor'])){
                $labelafter = '<div class="option-boxcolor" style="background: '.$value['boxcolor'].'"></div>';
            }
            $label = (isset($value['label']))? $value['label'] : '';
        }
        else{
            $label = (isset($value))? $value : '';
        }
        $label_html = ($label)? '<label>'.$label.'</label>' : '';

        $active = ($key == $input['value'])? 'active' : '' ;

        $class_color = (in_array($key, ['0', 'off']))? 'option-off' : 'option-on';
        $html .= '<button type="button" data-value="'.$key.'" class="'.$class_color.' '.$class.' '.$active.'">'.$labelafter.$label_html.'</button>';
    }
    
    $html .= $help.'<input type="hidden" name="'.$input['id'].'" value="'.$input['value'].'"></div></div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_color_input($input, $echo = true){
    $help = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $class      = (isset($input['class']))? 'class="'.$input['class'].'"' : 'class="color-picker"' ;
    $alpha      = (isset($input['alpha']))? 'data-alpha="true"' : 'data-alpha="false"' ;
    $default    = (isset($input['default']))? 'data-default-color="'.$input['default'].'"' : '' ;
    $depend     = (isset($input['depend']))? 'data-depend-id="'.$input['depend'].'"' : '' ;
    $html = '<div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <input type="text" name="'.$input['id'].'" value="'.$input['value'].'" class="'.$class.'" '.$alpha.' '.$depend.' '.$default.' />
        </div>
        '.$help.'
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_date_input($input, $echo = true){
    $help = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $class      = (isset($input['class']))? 'class="'.$input['class'].'"' : 'class="color-picker"' ;
    $format      = (isset($input['format']))? $input['format'] : 'dd-mm-yyyy' ;
    $html = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <input type="text" name="'.$input['id'].'" value="'.$input['value'].'" class="'.$class.'" placeholder="'.$format.'"  data-date-format="'.$format.'" data-provide="datepicker" data-date-autoclose="true">
        </div>
        '.$help.'
    </div>
    ';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_skinscolor_input($input, $echo = true){
    $description    = (isset($input['desc']))? '<div class="text-desc">'.$input['desc'].'</div>' : '';
    $html = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].' '.$description.'</label>
        <div class="megapanel-buttons-options">';
        $i = 0;
        foreach($input['options'] as $color){
            $i++;
            $active = ($color == $input['value']) ? 'active' : '';
            $html .= '<button type="button" data-value="'.$color.'" class="option-on boxcolor '.$active.'">
            <div class="option-boxcolor" style="background: '.$color.'"><i class="bx bx-check"></i></div>
            </button>';
        }
        $html .= '<input type="hidden" name="'.$input['id'].'" value="'.$input['value'].'">';
        
        $html .= '</div></div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_skinscolor_input_free($input, $echo = true){
    $description    = (isset($input['desc']))? '<div class="text-desc">'.$input['desc'].'</div>' : '';
    $html = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].' '.$description.'</label>
        <div class="megapanel-buttons-colors">';
        foreach($input['options'] as $color){
            $html .= '<button type="button" data-color="'.$color.'" class="option-on boxcolor"><div class="option-boxcolor" style="background: '.$color.'"></div></button>';
        }
        $html .= '<input type="text" name="'.$input['id'].'" value="'.$input['value'].'" class="form-control mt-3 colorpicker width-100">';
        
        $html .= '</div></div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_fieldicon_input($input, $echo = true){
    $help = (isset($input['help']))? '<span class="feature-details" original-title="'.$input['help'].'">?</span>' : '';
    $class = (isset($input['class']))? $input['class'] : '' ;
    $html = '<div class="megapanel-col-item" data-value="true">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <div class="megapanel-icon-select">
                <span class="megapanel-icon-preview"><i class="'.$input['value'].'"></i></span>
                <button type="button" class="btn btn-primary megapanel-icon-add">'.admin_lang('changes').'</button>
                <button type="button" class="btn btn-secondary megapanel-icon-default" data-geticon="'.$input['value'].'">'.admin_lang('default').'</button>
                <button type="button" class="btn btn-danger btn-remove megapanel-icon-remove">'.admin_lang('remove').'</button>
                <input type="hidden" name="'.$input['id'].'" value="'.$input['value'].'" class="megapanel-icon-value '.$class.'">
            </div>
        </div>
        '.$help.'
    </div>';
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_upload_input($input, $echo = true){
    $class          = (isset($input['class']))? $input['class'] : '' ;
    $description    = (isset($input['desc']))? '<div class="text-desc">'.$input['desc'].'</div>' : '';
    $id             = str_replace(array('[', ']'), array('',''), $input['id']);
    $value          = $input['value'];
    $image          = (isset($input['image']))? $input['image'] : '';
    $src            = (isset($input['src']))? $input['src'] : true;
    $size           = (isset($input['size']))? $input['size'] : 'full';
    $library        = (isset($input['library']))? $input['library'] : 'image';
    
    $html_view_file    = '';


    if($library == 'audio'){
        $mimes = '';
        $display = ($value)? '' : 'd-none';
        $html_view_file = '
        <div class="upload-'.$id.'-player-audio '.$display.'">
            <div id="sound-player" class="jp-jplayer"></div>
            <div id="sound-container" class="jp-audio top-player">
                <div class="player-nine">
                    <div class="jp-type-single">
                        <div class="jp-gui jp-interface">
                            <div class="player-container-left">
                                <div class="player-buttons">
                                    <a class="jp-play" tabindex="1" title="Play"></a>
                                    <a class="jp-pause" tabindex="1" title="Pause"></a>
                                </div>
                                <div class="player-repeat">
                                    <a class="jp-repeat" tabindex="1" title="Repeat" onclick="repeatSong(1)"></a>
                                    <a class="jp-repeat-off" tabindex="1" title="Repeat Off" onclick="repeatSong(0)"></a>
                                    <div class="d-none" id="repeat-song">0</div>
                                </div>
                            </div>
                            <div class="player-container-middle">
                                <div class="jp-current-time" id="current-time"></div>
                                <div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div>
                                <div class="jp-duration" id="duration-time"></div>
                            </div>
                            <div class="player-container-right">
                                <a class="jp-mute" tabindex="1" title="Mute"></a>
                                <a class="jp-unmute" tabindex="1" title="Unmute"></a>
                                <div class="jp-volume-bar" onclick="playerVolume()" title="Volume"><div class="jp-volume-bar-value"></div></div>
                            </div>
                        </div>
                    <div class="jp-no-solution"></div>
                    </div>
                </div>
            </div>
        </div>';
    }
    elseif($library == 'files')
    {
        $html_view_file = '';
    }

    $html = '
    <div class="megapanel-col-item">
        <label>'.$input['name'].' '.$description.'</label>
        <div class="megapanel-field">
            <input class="form-control '.$class.'" data-toggle="fileupload" data-type="'.$library.'" data-field="'.$id.'" data-image="'.$image.'" data-src="'.$src.'" data-size="'.$size.'" type="text" name="'.$input['id'].'" value="'.$value.'" >
            '.$html_view_file.'
        </div>
    </div>';

    if($value and $library == 'audio'){
        $mimes = File::extension($value);
        $html .= '<script>jQuery(document).ready(function() {playSong("'.$value.'", "'.$mimes.'");});</script>';
    }

    if( $echo ){ echo $html; } else{ return $html; }
}

function field_typography_inputs($input, $echo = true){
    $html           = '';
    $elements       = (isset($input['elements']) and is_array($input['elements']))? $input['elements'] : [];
    foreach($elements as $key => $element){
        $html .= '
        <div class="megapanel-col-item">
            <label>'.$element['title'].'</label>
            <div class="megapanel-field">
            
            </div>
        </div>';
    }
    if( $echo ){ echo $html; } else{ return $html; }
}

function field_select_animate($input, $echo = true){
    $html ='';
    $class = (isset($input['class']))? $input['class'] : '' ;
    $multiple = (isset($input['multiple']))? 'multiple' : '' ;
    $box_class = (isset($input['box_class']))? $input['box_class'] : 'megapanel-col-item';
    $box_class2 = ($box_class == 'megapanel-col-item')? 'class="megapanel-field"' : '';


    $html .='
    <div class="megapanel-col-item overflow-hidden">
        <label>'.$input['name'].'</label>
        <div class="megapanel-field">
            <select name="'.$input['id'].'" class="input js-animations tahb-animate-effect">
                <option value="none" selected="">--Select an animate--</option>
                <optgroup label="Most Popular">
                    <option value="fadeIn" '.get_selected( $input['value'], 'fadeIn', false ).'>fadeIn</option>
                    <option value="fadeInUp" '.get_selected( $input['value'], 'fadeInUp', false ).'>fadeInUp</option>
                    <option value="fadeInDown" '.get_selected( $input['value'], 'fadeInDown', false ).'>fadeInDown</option>
                    <option value="fadeInLeft" '.get_selected( $input['value'], 'fadeInLeft', false ).'>fadeInLeft</option>
                    <option value="fadeInRight" '.get_selected( $input['value'], 'fadeInRight', false ).'>fadeInRight</option>
                    <option value="bounceIn" '.get_selected( $input['value'], 'bounceIn', false ).'>bounceIn</option>
                    <option value="bounceInLeft" '.get_selected( $input['value'], 'bounceInLeft', false ).'>bounceInLeft</option>
                    <option value="bounceInRight" '.get_selected( $input['value'], 'bounceInRight', false ).'>bounceInRight</option>
                </optgroup>
                <optgroup label="Attention Seekers">
                    <option value="bounce" '.get_selected( $input['value'], 'bounce', false ).'>bounce</option>
                    <option value="flash" '.get_selected( $input['value'], 'flash', false ).'>flash</option>
                    <option value="pulse" '.get_selected( $input['value'], 'pulse', false ).'>pulse</option>
                    <option value="rubberBand" '.get_selected( $input['value'], 'rubberBand', false ).'>rubberBand</option>
                    <option value="shake" '.get_selected( $input['value'], 'shake', false ).'>shake</option>
                    <option value="swing" '.get_selected( $input['value'], 'swing', false ).'>swing</option>
                    <option value="tada" '.get_selected( $input['value'], 'tada', false ).'>tada</option>
                    <option value="wobble" '.get_selected( $input['value'], 'wobble', false ).'>wobble</option>
                    <option value="jello" '.get_selected( $input['value'], 'jello', false ).'>jello</option>
                </optgroup>
                <optgroup label="Bouncing Entrances">
                    <option value="bounceIn" '.get_selected( $input['value'], 'bounceIn', false ).'>bounceIn</option>
                    <option value="bounceInDown" '.get_selected( $input['value'], 'bounceInDown', false ).'>bounceInDown</option>
                    <option value="bounceInLeft" '.get_selected( $input['value'], 'bounceInLeft', false ).'>bounceInLeft</option>
                    <option value="bounceInRight" '.get_selected( $input['value'], 'bounceInRight', false ).'>bounceInRight</option>
                    <option value="bounceInUp" '.get_selected( $input['value'], 'bounceInUp', false ).'>bounceInUp</option>
                </optgroup>
                <optgroup label="Fading Entrances">
                    <option value="fadeIn" '.get_selected( $input['value'], 'fadeIn', false ).'>fadeIn</option>
                    <option value="fadeInDown" '.get_selected( $input['value'], 'fadeInDown', false ).'>fadeInDown</option>
                    <option value="fadeInDownBig" '.get_selected( $input['value'], 'fadeInDownBig', false ).'>fadeInDownBig</option>
                    <option value="fadeInLeft" '.get_selected( $input['value'], 'fadeInLeft', false ).'>fadeInLeft</option>
                    <option value="fadeInLeftBig" '.get_selected( $input['value'], 'fadeInLeftBig', false ).'>fadeInLeftBig</option>
                    <option value="fadeInRight" '.get_selected( $input['value'], 'fadeInRight', false ).'>fadeInRight</option>
                    <option value="fadeInRightBig" '.get_selected( $input['value'], 'fadeInRightBig', false ).'>fadeInRightBig</option>
                    <option value="fadeInUp" '.get_selected( $input['value'], 'fadeInUp', false ).'>fadeInUp</option>
                    <option value="fadeInUpBig" '.get_selected( $input['value'], 'fadeInUpBig', false ).'>fadeInUpBig</option>
                </optgroup>
                <optgroup label="Flippers">
                    <option value="flip" '.get_selected( $input['value'], 'flip', false ).'>flip</option>
                    <option value="flipInX" '.get_selected( $input['value'], 'flipInX', false ).'>flipInX</option>
                    <option value="flipInY" '.get_selected( $input['value'], 'flipInY', false ).'>flipInY</option>
                </optgroup>
                <optgroup label="Lightspeed">
                    <option value="lightSpeedIn" '.get_selected( $input['value'], 'lightSpeedIn', false ).'>lightSpeedIn</option>
                </optgroup>
                <optgroup label="Rotating Entrances">
                    <option value="rotateIn" '.get_selected( $input['value'], 'rotateIn', false ).'>rotateIn</option>
                    <option value="rotateInDownLeft" '.get_selected( $input['value'], 'rotateInDownLeft', false ).'>rotateInDownLeft</option>
                    <option value="rotateInDownRight" '.get_selected( $input['value'], 'rotateInDownRight', false ).'>rotateInDownRight</option>
                    <option value="rotateInUpLeft" '.get_selected( $input['value'], 'rotateInUpLeft', false ).'>rotateInUpLeft</option>
                    <option value="rotateInUpRight" '.get_selected( $input['value'], 'rotateInUpRight', false ).'>rotateInUpRight</option>
                </optgroup>
                <optgroup label="Sliding Entrances">
                    <option value="slideInUp" '.get_selected( $input['value'], 'slideInUp', false ).'>slideInUp</option>
                    <option value="slideInDown" '.get_selected( $input['value'], 'slideInDown', false ).'>slideInDown</option>
                    <option value="slideInLeft" '.get_selected( $input['value'], 'slideInLeft', false ).'>slideInLeft</option>
                    <option value="slideInRight" '.get_selected( $input['value'], 'slideInRight', false ).'>slideInRight</option>
                </optgroup>
                <optgroup label="Zoom Entrances">
                    <option value="zoomIn" '.get_selected( $input['value'], 'zoomIn', false ).'>zoomIn</option>
                    <option value="zoomInDown" '.get_selected( $input['value'], 'zoomInDown', false ).'>zoomInDown</option>
                    <option value="zoomInLeft" '.get_selected( $input['value'], 'zoomInLeft', false ).'>zoomInLeft</option>
                    <option value="zoomInRight" '.get_selected( $input['value'], 'zoomInRight', false ).'>zoomInRight</option>
                    <option value="zoomInUp" '.get_selected( $input['value'], 'zoomInUp', false ).'>zoomInUp</option>
                </optgroup>
                <optgroup label="Specials">
                    <option value="rollIn" '.get_selected( $input['value'], 'rollIn', false ).'>rollIn</option>
                </optgroup>
            </select>
        </div>
        <div class="tahb-animate-preview animated '.$input['value'].'">
            Animate preview
            <small>It happens when scroll over</small>
        </div>
    </div>
    ';

    if( $echo ){ echo $html; } else{ return $html; }
}