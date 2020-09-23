@extends('layouts.form')

@section('tittle', 'Adicionar Movimento')

@section('form_content')
<form action="{{ route('movimentos.store', $movimento) }}" name="form" method="POST" class="form-group">

    {{csrf_field()}}

    @include('movimentos.partials.create-edit')

</form>

@endsection
