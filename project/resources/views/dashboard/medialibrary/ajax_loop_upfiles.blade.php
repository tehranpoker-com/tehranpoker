@foreach ($upfiles as $item)
@if(isset($item['id']))
<li class="" role="checkbox" data-id="{{$item['id']}}" aria-checked="true" id="attachment-item-{{$item['id']}}">
    <div class="check"><div class="media-icon"></div></div>
    <div class="attachment-preview">
        <div class="thumbnail-item">
            <img src="{{$item['url']}}" />
        </div>
    </div>
</li>
@endif
@endforeach