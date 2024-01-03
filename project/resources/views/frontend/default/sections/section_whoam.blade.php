<div class="about-content mb-60">
    <img src="{{has_option('aboutme', 'avatar')}}" class="img-circle" alt="{{has_option('aboutme', 'about_name')}}">
    <h5>{{has_option('aboutme', 'about_title')}}@if(has_option('aboutme', 'nationality'))<small class="about-location mb-2"><i class="lnr lnr-map-marker"></i> {{has_option('aboutme', 'nationality')}}</small>@endif</h5>
    <p>{{has_option('aboutme', 'whoam')}}</p>
</div>