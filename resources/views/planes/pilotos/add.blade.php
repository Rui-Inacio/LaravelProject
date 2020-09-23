@extends('layouts.tables')

@section('tittle', 'Adicionar piloto')

@section('ops')
	<div class="container">
		<div class="row">
			<div class="col-4"></div>
			<div class="col-4">
				<div class="text-center">
					<input type="text" id="myInput" placeholder="Search...">
				</div>
			</div>
		</div>
	</div>

	<script>
	$(document).ready(function(){
	  $("#myInput").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#myTable tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });
	});
	</script>
@endsection

@section('tables_cols')
	<th>Nº Sócio</th>
	<th>Nome</th>
	<th>Email</th>
	<th>Data nascimento</th>
	<th>Telefone</th>
	<th>Nif</th>
	<th></th>
@endsection

@section('tables_rows')
	@foreach($users as $user)
		<tr>
			<td>{{$user->num_socio}}</td>
			<td>{{$user->nome_informal}}</td>
			<td>{{$user->email}}</td>
			<td>{{$user->data_nascimento}}</td>
			<td>{{$user->telefone}}</td>
			<td>{{$user->nif}}</td>
			<td>
				<form action="{{route('pilotos.store', [$plane, $user])}}" method="post">
					@csrf
					<input type="submit" class="btn btn-success" value="Adicionar">
				</form>
			</td>
		</tr>
	@endforeach
@endsection
