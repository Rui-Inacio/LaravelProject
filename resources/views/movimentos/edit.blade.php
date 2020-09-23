@extends('layouts.form')

@section('tittle', 'Editar Movimento')

@section('form_content')

	<form action="{{ route('movimentos.update', $movimento) }}" method="post" class="form-group">

		@method('put')
		@csrf
		@include ('movimentos.partials.create-edit')

	</form>

@endsection
