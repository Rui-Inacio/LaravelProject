@extends('layouts.form')

@section('tittle', 'Adicionar Aeronave')

@section('form_content')

  <form method="POST" class="form-group" action="{{ route('planes.store', $plane) }}">
  	<div class="form-group">
      <label for="matricula">Matricula</label>
      <input required name="matricula" type="text" class="form-control" id="matricula_input" placeholder="AB-CDE" 
      value="{{ old('matricula', $plane->matricula) }}">
    </div>

    @csrf
    @include('planes.partials.create-edit')

@endsection




