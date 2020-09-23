@extends('layouts.tables')

@section('tittle', 'Estatisticas Movimentos')

@section('ops')
	<div class="content">
		<div class="row">
			<div class="col-4"></div>
			<div class="col-4">

				<form id="choose" action="{{route('movimentos.estatisticasPost')}}"
					method="POST">
					@csrf
					<select form="choose" name="tipo" id="tipo_input">
						<option value="aeronave">Aeronaves</option>
						<option value="piloto">Pilotos</option>
					</select>
					<label for="data_input">Mes:</label>
					<select form="choose" name="mes" id="data_input">
						<option value="none">-Ano-</option>
						<option value="01">Janeiro</option>
						<option value="02">Fevereiro</option>
						<option value="03">Março</option>
						<option value="04">Abril</option>
						<option value="05">Maio</option>
						<option value="06">Junho</option>
						<option value="07">Julho</option>
						<option value="08">Agosto</option>
						<option value="09">Setembro</option>
						<option value="10">Outubro</option>
						<option value="11">Nomvembro</option>
						<option value="12">Dezembro</option>
					</select>
					<label for="data_input">Ano:</label>
						<select form="choose" name="ano" id="data_input">
						<option disabled selected value="0"> -Select- </option>
						<option value="2012">2012</option>
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
					</select>
					<br>
					<input style="float: right;" type="submit" class="btn btn-primary" value="Pesquisar">
				</form>

			</div>
			<div class="col-4"></div>
		</div>
	</div>

@endsection

@section('tables_cols')
	<tr class="text-center">
		<th>Id</th>
		<th>Data de Voo</th>
		<th></th>
		<th>Data de voo</th>
		<th>Tempo de voo</th>
		<th></th>
		<th>Piloto</th>
		<th>Tempo de voo</th>
	</tr>

	<style>
		.black{
			background-color: #454d55;
		}
	</style>

@endsection

@section('tables_rows')

@endsection
