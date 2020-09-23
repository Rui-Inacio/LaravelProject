
    <div class="form-group">
      <label for="marca">Marca</label>
      <input required name="marca" type="text" class="form-control" id="matricula_input"
      value="{{ old('marca', $plane->marca) }}">
    </div>

    <div class="form-group">
      <label for="modelo">Modelo</label>
      <input required name="modelo" type="text" class="form-control" id="modelo_input"
      value="{{ old('modelo', $plane->modelo) }}">
    </div>

    <div class="form-group">
      <label for="num_lugares">Nº de Lugares</label>
      <input required name="num_lugares" type="number" class="form-control" id="num_lugares_input"
      value="{{ old('num_lugares', $plane->num_lugares) }}">
    </div>

    <div class="form-group">
      <label for="conta_horas">Horas</label>
      <input required name="conta_horas" type="number" class="form-control" id="conta-horas_input"
      value="{{ old('conta_horas', $plane->conta_horas) }}">
    </div>

    <div class="form-group">
      <label for="preco_hora">Preço por Hora</label>
      <input required name="preco_hora" type="number" step="0.01" class="form-control" id="preco_hora_input"
      value="{{ old('preco_hora ', $plane->preco_hora) }}">
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success" name="ok">Submit</button> 
      <a href="{{ route('planes.index') }}" class="btn btn-danger">Cancel</a>
    </div>