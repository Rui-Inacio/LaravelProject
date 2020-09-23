    @extends('layouts.form')

    @section('tittle', 'Editar Socio')

    @section('form_content')
    <form  method="POST" action="{{route('users.update', $user)}}" class="form-group" enctype="multipart/form-data">
    	<input type="hidden" name="_method" value="PUT">
    	@csrf
    	<div class="form-group">
    		<label for="lblNum_Socio">Nº de Sócio: </label>
    		<label>{{ old('num_socio', $user->num_socio) }}</label>
    		<div class="form-group">
              <label for="lblTipoSocio">Tipo de Sócio: </label>
              <label>{{ old('tipo_socio', $user->tipoSocioToStr()) }}</label>
              <div class="form-group">
                  <label for="lblSexo">Sexo: </label>
                  <label>{{ old('sexo', $user->sexoToStr()) }}</label>
                  {{-- @include ('users.partials.create-edit') --}}
                  <div class="form-group">
                    <label for="inputEndereco">Endereço</label>
                    <textarea name="endereco">{{ old('endereco', $user->endereco) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="lblQuotasPorPagar">Quotas: </label>
                    <label>{{ old('quota_paga', $user->quotasToStr($user->quota_paga)) }}</label>
                    <div class="form-group">
                        <label for="lblSocioAtivo">Atividade: </label>
                        <label>{{ old('ativo', $user->ativoToStr()) }}</label>
                        <div class="form-group">
                            <label for="lblDirecao">Direcao: </label>
                            <label>{{ old('direcao', $user->intToStr($user->direcao)) }}</label>
                            <div class="form-group">
                                @include ('users.partials.create-edit')
                                <button type="submit" class="btn btn-success" name="ok">Save</button>
                                <a type="submit" class="btn btn-default" name="cancel" href="{{route('users.index')}}">Cancelar</a>
                            </div>

                        </form>
                        @endsection
