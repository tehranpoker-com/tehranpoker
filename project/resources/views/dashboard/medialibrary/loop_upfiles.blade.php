@foreach ($upfiles as $item)
@if(isset($item['error']))
<div class="alert alert-danger">{!!$item['error']!!}</div>
@else
<div class="media-item" id="media-item-{{$item['id']}}">
    <img class="thump" src="{{$item['url']}}" alt="">
    <a class="edit-attachment" href="{{ get_admin_url('editmedia/'.$item['id']) }}" target="_blank">{{admin_lang('edit')}}</a>
    <div class="filename">{{$item['title']}}</div>
</div>
@endif
@endforeach