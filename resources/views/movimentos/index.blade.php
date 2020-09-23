@extends('layouts.tables')

@section('tittle', 'Lista de Movimentos')

@section('ops')

  <div class="content">
    <div class="row">
      <div class="col-4">
        <span>
        	<a class="btn btn-primary" href="{{ route('movimentos.create') }}">Adicionar Movimento</a>
        </span>

          <span>
            <a type="button" class="btn btn-primary" href="{{ route('movimentos.estatisticas') }}">Estatisticas</a>
          </span>
      </div>

      <div class="col-2"></div>
      <div class="col-6">
        <form action="{{route('movimentos.indexPost')}}">
          <div style="float: left; padding-top: 3px;">
            Filtrar por:
            <select form="anotherForm" name="filtro" id="select">
              <option disabled selected value="0"> - Select -</option>
              <option value="1">Id do Movimento</option>
              <option value="2">Aeronave</option>
              <option value="3">Piloto</option>
              <option value="4">Data de voo</option>
              <option value="5">Natureza</option>
              <option value="6">Confirmado</option>
            </select>
          </div>
          <span>
            <input type="text" id="myInput" form="anotherForm" name="search" 
              placeholder=" Search...">
          </span>
          <input type="submit" class="btn btn-primary" value="Pesquisar">
        </form>
      </div>
    </div>
  </div>

@endsection

@if(count($movimentos))

@section('tables_cols')

	<th>Id</th>
	<th>Piloto</th>
	<th>Nome Informal</th>
	<th>Aeronave</th>
	<th>Natureza do voo</th>
	<th>Data do voo</th>
	<th>Hora de descolagem</th>
	<th>Hora de aterragem</th>
  <th>Tempo de Voo</th>
  <th>Natureza do Voo</th>
  <th>Aerodromo de Partida</th>
  <th>Aerodromo de Chegada</th>
  <th>Nº de aterragens</th>
  <th>Nº de descolagens</th>
  <th>Nº diario</th>
  <th>Nº de serviço</th>
  <th>Conta-horas Inicial</th>
  <th>Conta-horas Final</th>
  <th>Nº de pessoas</th>
  <th>Tipo de instrução</th>
  <th>Instrutor</th>
  <th>Confirmado</th>
  <th>Observações</th>
  <th></th>
  <th></th>

@endsection

@section('tables_rows')

	@foreach($movimentos as $movimento)
		<tr style="cursor: pointer;" class="table-row table-hover">
			<td>{{$movimento->id}}</td>
			<td>{{$movimento->piloto_id}}</td>
      <td>{{$movimento->nomePiloto($movimento->piloto_id)}}</td>
			<td>{{$movimento->aeronave}}</td>
			<td>{{$movimento->naturezaToStr()}}</td>
			<td>{{$movimento->data}}</td>
			<td>{{$movimento->hora_descolagem_right()}}</td>
			<td>{{$movimento->hora_aterragem_right()}}</td>
      <td>{{$movimento->tempo_voo}}</td>
      <td>{{$movimento->natureza}}</td>
      <td>{{$movimento->aerodromo_partida}}</td>
      <td>{{$movimento->aerodromo_chegada}}</td>
      <td>{{$movimento->num_aterragens}}</td>
      <td>{{$movimento->num_descolagens}}</td>
      <td>{{$movimento->num_diario}}</td>
      <td>{{$movimento->num_servico}}</td>
      <td>{{$movimento->conta_horas_inicio}}</td>
      <td>{{$movimento->conta_horas_fim}}</td>
      <td>{{$movimento->num_pessoas}}</td>
      <td>{{$movimento->tipo_instrucao}}</td>
      <td>{{$movimento->instrutor_id}}</td>
      <td>{{$movimento->confirmado}}</td>
      <td>{{$movimento->observacoes}}</td>

      <td>
        <span>
          <a type="button" class="btn btn-success" href="{{ route('movimentos.edit', $movimento) }}">Editar</a>
        </span>
      </td>
      <td>
        <span>
          <form action="{{ route('movimentos.destroy', $movimento) }}" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-danger" value="Apagar">
          </forms>
        </span>
      </td>
		</tr>



		<script>

			$(document).ready(function($) {
			    $(".table-row").click(function() {
			        window.document.location = $(this).data("href");
			    });
			});


		</script>
	@endforeach

@endsection

@section('paginate')
  {{$movimentos->links()}}
@endsection

@else

	<h1>Não há movimentos para mostrar</h1>

@endif
