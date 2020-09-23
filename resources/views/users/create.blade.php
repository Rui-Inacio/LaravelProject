@extends('layouts.form')

@section('tittle' , 'Adicionar Socio')

@section('form_content')

<form action="{{route('users.store', $user)}}" method="POST" class="form-group" >
	<div class="form-group">
		<label for="inputNumeroSocio">Numero Socio</label>
		<input required name="num_socio" type="text" class="form-control" id="numSocio_input" placeholder="Numero Socio">
	</div>
	<div>
		<select class="custom-select">
			<option selected disabled>Sexo</option>
			<option value="M">Masculino</option>
			<option value="F">Feminino</option>
		</select>
	</div>
	<div>
		<select class="custom-select">
			<option selected disabled>Tipo Socio</option>
			<option value="NP">Não Piloto</option>
			<option value="P">Piloto</option>
			<option value="A">Aeromodelista</option>
		</select>
	</div>
	<div>
		<select class="custom-select">
			<option selected disabled>Quotas Pagas</option>
			<option value="1">Quotas Pagas</option>
			<option value="0">Quotas Por Pagas</option>
		</select>
	</div>
	<div>
		<select class="custom-select">
			<option selected disabled>Diretor</option>
			<option value="1">Sim</option>
			<option value="0">Não</option>
		</select>
	</div>
	@include('users.partials.create-edit')
	@csrf
	<div class="form-group">
		<button type="submit" class="btn btn-success" name="ok">Adicionar Utilizador</button>
		<a type="submit" class="btn btn-default" name="cancel" href="{{route('users.index')}}">Cancelar</a>
	</div>

	@endsection