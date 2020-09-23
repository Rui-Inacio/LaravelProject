@extends('layouts.tables')

@section('tittle', 'Lista de pilotos')

@section('ops')
	<div class="container">
		<div class="row">
			<div class="col-4">
				<form action="{{route('pilotos.add', $plane)}}">
					<input type="submit" class="btn btn-primary" value="Adicionar Piloto">
				</form>
			</div>
			<div class="col-4">
				<div class="text-center">
					<h2>Aeronave {{$plane->matricula}}</h2>
				</div>
			</div>
			<div class="col-4"></div>
		</div>
	</div>
@endsection

@if(count($pilotos))

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
		
		@foreach($pilotos as $piloto)
			<tr>
				<td>{{$piloto->num_socio}}</td>
				<td>{{$piloto->nome_informal}}</td>
				<td>{{$piloto->email}}</td>
				<td>{{$piloto->data_nascimento}}</td>
				<td>{{$piloto->telefone}}</td>
				<td>{{$piloto->nif}}</td>
				<td>
					<form action="{{route('pilotos.delete', [$plane, $piloto])}}" method="post">
						@method('delete')
						@csrf
						<input type="submit" class="btn btn-danger" value="Apagar">
					</form>
				</td>
			</tr>
		@endforeach

	@endsection

@else

	@section('noTable')
		<div class="container">
			<div class="row">
				<div class="col-4"></div>
				<div class="col-4">
					<div class="text-center">
						<h2>Não existem pilotos associados a esta aeronave</h2>
					</div>
				</div>
				<div class="col-4"></div>
			</div>
		</div>
	@endsection

@endif