@extends('home')

@section('content')

<div class="container">
	<div class="jumbotron">
		<div class="text-center">
			<h1 class="title">@yield('tittle')</h1>
		</div>
	</div>
</div>

<div class="row">		
	<div class="col-1"></div>
	<div class="col-10">
		@yield('ops')
		@if(session('success'))
            @include('shared.success')
        @endif
        @if(count($errors))
        	@include('shared.errors')
        @endif
		@yield('noTable')
		<br><br>
		<div class="table-responsive">
		<table class="table" id="myTable">
			<thead class="thead-dark">
				<tr class="text-center">
					@yield('tables_cols')
				</tr>
			</thead>
			<tbody class="text-center">
				<tr>
					@yield('tables_rows')
				</tr>
			</tbody>
		</table>
		</div>
		<div style="padding-left: 25%; background-color: #454d55;" class="text-center">
			@yield('paginate')
		</div>
	</div>
	<div class="col-1"></div>
</div>
<div class="row"></div>

<style>
	.table tr:hover{
		background-color: lightgray;
	}
</style>

@endsection