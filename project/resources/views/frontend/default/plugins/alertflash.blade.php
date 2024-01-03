@if(session()->has('activation_success'))<div class="alert-flash success">{{ session()->get('activation_success') }}</div>@endif
@if(session()->has('activation_error'))<div class="alert-flash error">{{ session()->get('activation_error') }}</div>@endif
@if(session()->has('registered_success'))<div class="alert-flash success">{{ session()->get('registered_success') }}</div>@endif 