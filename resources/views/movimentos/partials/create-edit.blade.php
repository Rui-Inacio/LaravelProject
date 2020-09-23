<h2 class="text-center" style="border: 1px solid black;">Voo</h2>

<div class="form-group">
  <label for="data">Data de voo</label>
  <input required name="data" type="date" class="form-control" placeholder="dd/MM/yyyy"
    id="data_input" value="{{ old('data',$movimento->data) }}">
</div>

<div class="form-group">
  <label for="hora_descolagem">Hora de descolagem</label>
  <input required name="hora_descolagem" type="datetime" placeholder="HH/mm" class="form-control"
    id="hora_descolagem_input"
  value="{{ old('hora_descolagem',$movimento->hora_descolagem) }}">
</div>

<div class="form-group">
  <label for="hora_aterragem">Hora de aterragem</label>
  <input required name="hora_aterragem" placeholder="HH/mm" type="datetime"
    class="form-control" id="hora_aterragem_input"
      value="{{ old('hora_aterragem', $movimento->hora_aterragem) }}">
</div>

<div class="form-group">
  <label for="num_descolagens">Numero de descolagens</label>
  <input required name="num_descolagens" placeholder="number" type="num_descolagens_input"
    class="form-control" id="num_descolagens_input"
      value="{{ old('num_descolagens', $movimento->num_descolagens) }}">
</div>




<div class="form-group">

  Natureza:
  <select form="form" class="form-control" name="natureza" id="natureza_input">
    <option value="N" selected disabled>
      {{old('natureza', $movimento->natureza) == null ? '- Select -' :
        old('natureza', $movimento->natureza) }}
    </option>
    <option value="T">Treino</option>
    <option value="I">Instrução</option>
    <option value="E">Especial</option>
  </select>

</div>

<div class="form-group">
      <label for="aerodromo_partida">Aerodromo de partida</label>
      <input required name="aerodromo_partida" type="text" class="form-control" id="aerodromo_partida_input"
      value="{{old('aerodromo_partida', $movimento->aerodromo_partida) }}">
</div>

<div class="form-group">
  <label for="aerodromo_chegada">Aerodromo de chegada</label>
  <input required name="aerodromo_chegada" type="text" class="form-control" id="aerodromo_chegada_input"
  value="{{old('aerodromo_chegada', $movimento->aerodromo_chegada) }}">
</div>

<div class="form-group">
  <label for="num_aterragens">Numero de aterragens</label>
  <input required name="num_aterragens" type="number" class="form-control" id="num_aterragens_input"
  value="{{ old('num_aterragens',$movimento->num_aterragens) }}">
</div>

<div class="form-group">
  <label for="num_pessoas">Numero de pessoas a bordo</label>
  <input required name="num_pessoas" type="number" class="form-control" id="num_pessoas_input"
  value="{{ old('num_pessoas',$movimento->num_pessoas) }}">
</div>

<div class="form-group">
  <label for="tempo_voo">Tempo voo</label>
  <input required name="tempo_voo" type="time" class="form-control" id="tempo_voo_input"
  value="{{old('tempo_voo', $movimento->tempo_voo) }}">
</div>

<div class="form-group">
  <label for="preco_voo">Preco do voo</label>
  <input required name="preco_voo" type="number" step="0.01"  class="form-control" id="preco_voo_input"
  value="{{ old('preco_voo',$movimento->preco_voo) }}">
</div>

<div class="form-group">
  Modo Pagamento:
  <select form="form" class="form-control" name="modo_pagamento" id="modo_pagamento_input">
    <option selected disabled value="NA">
      {{old('modo_pagamento', $movimento->modo_pagamento) == null ? '- Select -' :
        old('modo_pagamento', $movimento->modo_pagamento) }}
    </option>
    <option value="N">Numerario</option>
    <option value="M">Multibanco</option>
    <option value="T">Transferencia</option>
    <option value="P">Pacote de horas</option>
  </select>
</div>

<div class="form-group">
  <label for="num_recibo">Numero de Recibo</label>
  <input required name="num_recibo" type="text" class="form-control" id="num_recibo"
  value="{{ old('num_recibo',$movimento->num_recibo )}}">
</div>

<div class="form-group">
  Confirmado:
  <select form="form" class="form-control" name="confirmado" id="confirmado_input">
    <option selected disabled value="-1">
      {{old('confirmado', $movimento->confirmado) == null ? '- Select -' :
        old('confirmado', $movimento->confirmado) }}
    </option>
    <option value='1'>Sim</option>
    <option value='0'>Não</option>
  </select>
</div>

<br>
<h2 class="text-center" style="border: 1px solid black;">Piloto</h2>

<div class="form-group">
  <label for="piloto_id">Id</label>
  <input required name="piloto_id" type="text" class="form-control" id="piloto_id_input"
  value="{{ old('piloto_id',$movimento->piloto_id) }}">
</div>

<div class="form-group">
  <label for="num_licenca_piloto">Numero Licença Piloto</label>
  <input required name="num_licenca_piloto" type="number" class="form-control" id="num_licenca_piloto_input"
  value="{{ old('num_licenca_piloto',$movimento->num_licenca_piloto) }}">
</div>



<div class="form-group">
  Tipo Licença Piloto
  <select form="form" class="form-control" name='tipo_licenca_instrutor' id="licenca_input">
    <option selected disabled value="0">
      {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == null ? '- Select - ' :
       old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) }}
    </option>
    <option value="1">Aluno - Private Pilot License Airplane</option>
    <option value="2">Aluno - Piloto de Ultraleve</option>
    <option value="3">Airline Transport Pilot License</option>
    <option value="4">Comercial Pilot License Airplane</option>
    <option value="5">Private Pilot License Airplane</option>
    <option value="6">Piloto de Ultraleve</option>
  </select>
</div>

<div class="form-group">
  <label for="validade_licenca_piloto">Validade Licença Piloto</label>
  <input required name="validade_licenca_piloto" type="text" class="form-control" id="validade_licenca_piloto_input"
  value="{{ old('validade_licenca_piloto',$movimento->validade_licenca_piloto) }}">
</div>

<div class="form-group">
  <label for="num_certificado_piloto">Numero Certificado Medico</label>
  <input required name="num_certificado_piloto" type="number" class="form-control" id="num_certificado_piloto_input"
  value="{{ old('num_certificado_piloto',$movimento->num_certificado_piloto) }}">
</div>

<div class="form-group">
  <label for="classe_certificado_piloto">Classe Certificado Medico</label>
  <input required name="classe_certificado_piloto" type="text" class="form-control" id="classe_certificado_piloto_input"
  value="{{ old('num_certificado_piloto',$movimento->num_certificado_piloto) }}">
</div>

<div class="form-group">
  <label for="validade_certificado_piloto">Validade Certificado Piloto</label>
  <input required name="validade_certificado_piloto" type="date" class="form-control" id="validade_certificado_piloto_input"
  value="{{ old('validade_certificado_piloto',$movimento->validade_certificado_piloto) }}">
</div>
<br>
<h2 class="text-center" style="border: 1px solid black;">Instrutor</h2>

<div class="form-group">
  <label for="instrutor_id">Instrutor Id</label>
  <input required name="instrutor_id" type="number" class="form-control" id="instrutor_id_input"
    value="{{ old('instrutor_id',$movimento->instrutor_id) }}">
</div>

<div class="form-group">
  <label for="num_licenca_instrutor">Numero licenca Instrutor</label>
  <input name="num_licenca_instrutor" type="number" class="form-control"
    id=" num_licenca_instrutor_input"
      value="{{ old('num_licenca_instrutor',$movimento->num_licenca_instrutor) }}">
</div>

<div class="form-group">
  <label for="tipo_licenca_instrutor">Tipo licenca Instrutor</label>
  <select name="" id=""></select>
</div>


<div class="form-group">
  Natureza:
  <select form="form" class="form-control" name="tipo_instrucao" id="tipo_instrucao_input">
    <option selected disabled value="NA">
      {{old('tipo_instrucao', $movimento->tipo_instrucao) == null ? '- Select -' :
        old('tipo_instrucao', $movimento->tipo_instrucao) }}
    </option>
    <option value="D">Duplo Comando</option>
    <option value="S">Solo</option>
  </select>
</div>

<div class="form-group">
  <label for="validade_licenca_instrutor">Validade licenca instrutor</label>
  <input name="validade_licenca_instrutor" type="date" class="form-control"
    id="validade_licenca_instrutor_input"
      value="{{ old('validade_licenca_instrutor',$movimento->validade_licenca_instrutor) }}">
</div>

<br>
<h2 class="text-center" style="border: 1px solid black;">Aeronave</h2>

<div class="form-group">
  <label for="aeronave">Aeronave</label>
  <input required name="aeronave" type="text" class="form-control" id="aeronave_input"
    value="{{ old('aeronave',$movimento->aeronave) }}">
</div>

<div class="form-group">
  <label for="num_diario">Numero Diario</label>
  <input required name="num_diario" type="number" class="form-control" id="num_diario_input"
    value="{{ old('num_diario',$movimento->num_diario) }}">
</div>

<div class="form-group">
  <label for="num_servico">Numero Serviço</label>
  <input required name="num_servico" type="number" class="form-control" id="num_servico_input"
    value="{{ old('num_servico',$movimento->num_servico) }}">
</div>

<div class="form-group">
  <label for="conta_horas_inicio">Conta horas inicial</label>
  <input required name="conta_horas_inicio" type="number" class="form-control"
    id="conta_horas_inicio_input"
      value="{{ old('conta_horas_inicio',$movimento->conta_horas_inicio) }}">
</div>

<div class="form-group">
  <label for="conta_horas_fim">Conta horas fim</label>
  <input required name="conta_horas_fim" type="number" class="form-control"
    id="conta_horas_fim_input"
      value="{{ old('conta_horas_fim',$movimento->conta_horas_fim) }}">
</div>


<h2>Observaçoes</h2>
<div class="form-group">
  <label for="observacoes">Observaçoes</label>
  <textarea name="observacoes" type="textarea" class="form-control" id="observacoes_input"
    value="{{ old('observacoes',$movimento->observacoes) }}">
</div>


<div class="form-group">
  <button type="submit" class="btn btn-success" name="ok">Submit</button>
  <a href="{{ route('movimentos.index') }}" class="btn btn-danger">Cancel</a>
</div>
