@extends('layouts.tables')

@section('tittle', 'Lista de Aeronaves')

<!-- Criar butoes, janelas de pesquisa, entre outros com o section ops -->

@section('ops')

  <div class="content">
    <div class="row">
      <div class="col-4">
        @can('create', App\Aeronave::class)
        <span>
          <a class="btn btn-primary" href="{{ route('planes.create') }}">Adicionar Aeronave</a>
        </span>
        @endcan
      </div>
      <div class="col-4"></div>
      <div class="col-4">
        <span style="float: right;"><input type="text" id="myInput" onkeyup="myFunction()" placeholder=" Search..."></span>
      </div>
    </div>
  </div>

  <!-- Script for search bar -->

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

@if(count($planes))

  @section('tables_cols')

    <th>Matricula</th>
    <th>Marca</th>
    <th>Modelo</th>
    <th>Nº de Lugares</th>
    <th>Total de horas</th>
    <th>Preço por hora</th>
<!--     <th>Data de criação</th>
    <th>Data de edição</th>
    <th>Data de destruição</th> TODO autenticação para quem ve -->
    <th></th>

  @endsection
  @section('tables_rows')

    @foreach($planes as $plane)
      <tr>
        <td>{{ $plane->matricula }}</td>
        <td>{{ $plane->marca }}</td>
        <td>{{ $plane->modelo }}</td>
        <td>{{ $plane->num_lugares }}</td>
        <td>
          {{ $plane->conta_horas }}
          <br>
          <a href="{{route('planes.graph', $plane)}}">Grafico Tempo</a>
        </td>
        <td>
          {{ $plane->preco_hora }} 
          <br>
          <a href="{{route('planes.times', $plane)}}">Tabela Preços</a>
        </td>
    <!--    <td>{{ $plane->created_at }}</td>
        <td>{{ $plane->updated_at }}</td>
        <td>{{ $plane->deleted_at }}</td> TODO autenticação para quem ve -->
        <td>
          @can('pilotos', $plane)
          <span>
            <a href="{{route('pilotos.index', $plane) }}" type="button" class="btn btn-primary"> Pilotos </a>
          </span>
          @endcan
          @can('edit', $plane)
          <span style="padding-left: 25px;">
            <a type="button" class="btn btn-success" href="{{ route('planes.edit', $plane) }}">Editar</a>
          </span>
          @endcan
          @can('destroy', $plane)
          <span style="float: right;">
            <form action="{{ route('planes.destroy', $plane) }}" method="post">
              @method('delete')
              @csrf
              <input type="submit" class="btn btn-danger" value="Apagar">
            </form>
          </span>
          @endcan
        </td>
      </tr>

    @endforeach

  @endsection

@else
  <div class="content">
    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <h2 class="text-center">Nenhuma aeronave encontrada</h2>
      </div>
      <div class="col-2"></div>
    </div>
  </div>

@endif
