@foreach ($upfiles as $item)
<li class="" role="checkbox" data-id="{{$item->at_id}}" aria-checked="true" id="attachment-item-{{$item->at_id}}">
    <div class="check"><div class="media-icon"></div></div>
    <div class="attachment-preview">
        <div class="thumbnail-item"><img src="{{get_media_mimes_thumbnail($item->at_files, $item->at_mimes)}}" /></div>
    </div>
</li>
@endforeach