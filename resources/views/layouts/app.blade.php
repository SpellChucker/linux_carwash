@extends('layouts.base')

@section('main')
	@include('layouts/includes/navbar')

  <div class="wrapper toggled">

    @if (count($errors))
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @include('includes.status')

    <div class="page-content-wrapper">
      <div class="container-fluid" id="{{ $module or 'page-content'}}">
        @yield('content')
      </div>
    </div>

  </div>

@endsection
