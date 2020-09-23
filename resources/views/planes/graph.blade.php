@extends('master')

@section('tittle', 'Linha Temporal')


<div class="container">
	<div class="jumbotron">
		<div class="text-center">
			<h1 class="title">@yield('tittle')</h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-4"></div>
	<div class="col-4">
		<div class="text-center">
			<form action="{{route('planes.makeGraph', $plane)}}">
				<select onchange="this.form.submit()" form="form" class="selectpicker" data-style="btn-primary" name="mySelect" id="select">
					<option selected value="1">Dias</option>
					<option value="2">Semanas</option>
					<option value="3">Meses</option>
				</select>
			</form>
		</div>
	</div>
	<div class="col-4"></div>
</div>
<br><br>
<div class="row">
	<div class="col-2"></div>
	<div class="col-8">
		<div class="text-center">
			<h2>Ola</h2>			
		</div>
	</div>
	<div class="col-2"></div>
</div>