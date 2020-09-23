@extends('layouts.tables')

@section('tittle', 'Lista de Socios')

@section('ops')

<div class="content">
    <div class="row">
      <div class="col-4">  
        <span><a class="btn btn-primary" href="{{ route('users.create') }}">Adicionar Utilizador</a></span>
    </div>
    <div>
        <form action="{{action('UserController@index')}}" method="GET">
            <input name="num_socio" placeholder="Numero Socio">
            <input name="nome_informal" placeholder="Nome Informal">
            <input name="email" placeholder="Email">
            <input name="direcao" placeholder="Direção">
            <input name="tipo" placeholder="Tipo Socio">
            <input type="submit" class="btn-primary" value="Search" >
        </form>
    </div>
</div>
</div>

@endsection

@if(count($users))

@section('tables_cols')
<th>Foto</th>
<th>Num Sócio</th>
<th>Nome Completo</th>
<th>Nome Informal</th>
<th>Sexo</th>
<th>Email</th>
<th>Nif</th>
<th>Data Nascimento</th>
<th>Telefone</th>
<th>Endereço</th>
<th>Tipo Sócio</th>
<th>Quotas</th>
<th>Atividade</th>
<th>Direção</th>
<th>Aluno</th>
<th>Instrutor</th>
<th>Num Licença</th>
<th>Tipo Licença</th>
<th>Validade Licença</th>
<th>Confirmação Licença</th>
<th>Num Certificado</th>
<th>Classe Certificado</th>
<th>Validade Certificado</th>
<th>Confirmação Certificado</th>
<th></th>
<th></th>
@endsection
@section('tables_rows')

@foreach ($users as $user)
<tr>
    <td>
        @if (empty($user->foto_url))
        <img href="#" width="125" height="125"  src="{{ asset('storage/fotos/noimage.jpg') }}">
        @else
        <img href="#" width="125" height="125"  src="{{ asset('storage/fotos/' . $user->foto_url) }}">
        @endif
    </td>
    <td>{{$user->existeDados($user->num_socio)}}</td>
    <td>{{$user->existeDados($user->name)}}</td>
    <td>{{$user->existeDados($user->nome_informal)}}</td>
    <td>{{$user->sexoToStr()}}</td>
    <td>{{$user->existeDados($user->email)}}</td>
    <td>{{$user->existeDados($user->nif)}}</td>
    <td>{{$user->existeDados($user->data_nascimento)}}</td>
    <td>{{$user->existeDados($user->telefone)}}</td>
    <td>{{$user->existeDados($user->endereco)}}</td>
    <td>{{$user->tipoSocioToStr()}}</td>
    <td>{{$user->quotasToStr($user->quota_paga)}}</td>
    <td>{{$user->ativoToStr()}}</td>
    <td>{{$user->intToStr($user->direcao)}}</td>
    <td>{{$user->intToStr($user->aluno)}}</td>
    <td>{{$user->intToStr($user->instrutor)}}</td>
    <td>{{$user->existeDados($user->num_licenca)}}</td>
    <td>{{$user->existeDados($user->tipo_licenca)}}</td>
    <td>{{$user->existeDados($user->validade_licenca)}}</td>
    <td>{{$user->confirmacaoToStr($user->licenca_confirmada)}}</td>
    <td>{{$user->existeDados($user->num_certificado)}}</td>
    <td>{{$user->existeDados($user->classe_certificado)}}</td>
    <td>{{$user->existeDados($user->validade_certificado)}}</td>
    <td>{{$user->confirmacaoToStr($user->certificado_confirmado)}}</td>
    <td>
        <span>
            <a type="button" class="btn btn-primary" href="{{ route('users.edit', $user) }}">Editar</a>
        </span>
    </td>
    <td>
        <span>
          <form action="{{ route('users.destroy', $user) }}" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-danger" value="Apagar">
        </form>
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
{{$users->links()}}
@endsection
@else
<h2>No users found</h2>
@endif
