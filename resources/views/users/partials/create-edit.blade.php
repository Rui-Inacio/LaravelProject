    <div class="form-group" style="margin-bottom: 20px">
        <div class="col-md-4 text-center">
            <img src="{{ $user->foto_url == null ? asset('storage/fotos/noimage.jpg') : asset('storage/fotos/' . $user->foto_url)}}" class="img-thumbnail" name="image"/>

            <br/><br/>
            <input type="file" name="file_foto" class="form-control">
        </div>
        <div class="form-group">
            <label for="inputNome_informal">Nome Informal</label>
            <input required name="nome_informal" type="text" class="form-control" id="nome_informal_input" placeholder="Nome Informal" value="{{ old('nome_informal', $user->nome_informal) }}">
        </div>
        <div class="form-group">
            <label for="inputName">Nome</label>
            <input required name="name" type="text" class="form-control" id="name_input" placeholder="Nome" value="{{ old('name', $user->name) }}">
        </div>
        <div class="form-group">
           <label for="inputEmail">Email</label>
           <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email address" value="{{old('email', $user->email)}}"/>
       </div>
       <div class="form-group">
        <label for="inputData_nascimento">Data Nascimento</label>
        <input required name="data_nascimento" type="text" class="form-control" id="data_nascimento_input" placeholder="Data Nascimento" value="{{ old('data_nascimento', $user->data_nascimento) }}">
    </div>
    <div class="form-group">
        <label for="inputNif">Numero de Identificação Fiscal</label>
        <input required name="nif" type="text" class="form-control" id="nif_input" placeholder="Nif" value="{{ old('nif', $user->nif) }}">
    </div>
    <div class="form-group">
        <label for="inputTelefone">Telefone</label>
        <input required name="telefone" type="text" class="form-control" id="telefone_input" placeholder="Telefone" value="{{ old('telefone', $user->telefone) }}">
    </div>
    @can('view', $user)
    <div class="form-group">
        <label for="inputNumeroLicena">Numero da Licença</label>
        <input required name="num_licenca" type="text" class="form-control" id="num_licenca_input" placeholder="Numero da Licença" value="{{ old('num_licenca', $user->num_licenca) }}">
    </div>
    <div class="form-group">
        <label for="inputTipoLicena">Tipo de Licença</label>
        <input required name="tipo_licenca" type="text" class="form-control" id="tipo_licenca_input" placeholder="Tipo de Licença" value="{{ old('tipo_licenca', $user->tipo_licenca) }}">
    </div>
    <div class="form-group">
        <label for="inputValidadeLicenca">Validade Licença</label>
        <input required name="validade_licenca" type="text" class="form-control" id="validade_licenca_input" placeholder="Validade Licença" value="{{ old('validade_licenca', $user->validade_licenca) }}">
    </div>
    <div class="form-group">
        <label for="inputFileLicenca">Imagem da Licença</label>
        <input type="file" name="file_licenca" class="form-control">
    </div>
    <div class="form-group">
        <label for="inputNumeroCertficado">Numero do Certificado</label>
        <input required name="num_certificado" type="text" class="form-control" id="num_certificado_input" placeholder="Numero do Certificado" value="{{ old('num_certificado', $user->num_certificado) }}">
    </div>
    <div class="form-group">
        <label for="inputClasseCertficado">Classe do Certificado</label>
        <input required name="classe_certificado" type="text" class="form-control" id="classe_certificado_input" placeholder="Classe do Certificado" value="{{ old('classe_certificado', $user->classe_certificado) }}">
    </div>
    <div class="form-group">
        <label for="inputValidadeCertificado">Validade Certificado</label>
        <input required name="validade_certificado" type="text" class="form-control" id="validade_certificado_input" placeholder="Validade Certificado" value="{{ old('validade_certificado', $user->validade_certificado) }}">
    </div>
    <div class="form-group">
        <label for="inputFileCertificado">Imagem do Certificado</label>
        <input type="file" name="file_certificado" class="form-control">
    </div>
    @endcan