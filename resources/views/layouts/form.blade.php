@extends('home')

@section('content')

	<div class="container">
		<div class="jumbotron">
			<div class="text-center">
				<h1>@yield('tittle')</h1>
			</div>
		</div>
	</div>

	@if (session('success'))
            @include('shared.success')
        @endif

	@if(count($errors))
		@include('shared.errors')
	@endif

	<div class="content">
		<div class="row">
			<div class="col-2"></div>
			<div class="col-8">
				@yield('form_content')
			</div>
			<div class="col-2"></div>
		</div>
	</div>
	
@endsection