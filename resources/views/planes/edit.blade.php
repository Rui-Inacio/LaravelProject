@extends('layouts.form')

@section('tittle', 'Editar Aeronave')

@section('form_content')

	<form method="POST" class="form-group" action="{{ route('planes.update', $plane->matricula) }}">

		<div class="form-group">
	      <label for="matricula">Matricula</label>
	      <input disabled type="text" class="form-control" 
	      value="{{ old('matricula', $plane->matricula) }}">
	      <input class="form-control" name="matricula" type="hidden" id="matricula_input" value="{{old('matricula', $plane->matricula)}}">
	    </div>

		@method('PUT')
		@csrf
		@include ('planes.partials.create-edit')

		<br>
		<div class="form-group">
		<table class="table" id="myTable">
			<thead class="thead-dark">
				<tr class="text-center">
					<td>Unidade Conta Horas</td>
					<td>Minutos</td>
					<td>Preço</td>
				</tr>
			</thead>
			<tbody class="text-center">
					@for($i=0;$i<10;$i++)
						<tr class="text-center">
							<th class="text-center">
								<input disabled name="unidade_conta_horas" class="form-control" type="text" value="{{old('unidade_conta_horas[$i]', $maps[$i]->unidade_conta_horas)}}">
							</th>
							<th>
								<input name="minutos[{{ $i }}]" class="form-control" type="text" value="{{old('minutos[$i]', $maps[$i]->minutos)}}">
							</th>
							<th>
								<input name="preco[{{ $i }}]" class="form-control" type="text" value="{{old('preco[$i]', $maps[$i]->preco)}}">
							</th>
						</tr>
					@endfor
			</tbody>
		</table>
		</div>

	</form>

@endsection
