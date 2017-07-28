@if(Session::has('message'))
  <div class="alert alert-{{ Session::get('status') }}">
    {{ Session::get('message') }}
  </div>
@endif
