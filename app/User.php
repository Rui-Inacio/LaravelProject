<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail{

    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num_socio', 'name', 'nome_informal', 'sexo', 'email', 'nif', 'data_nascimento',
        'telefone', 'endereco', 'tipo_socio', 'quota_paga', 'ativo', 'direcao', 'aluno', 'instrutor',
        'num_licenca', 'tipo_licenca', 'validade_licenca', 'lincenca_confirmada', 'num_certificado',
        'classe_certificado', 'validade_certificado', 'certificado_confirmado', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ativarSocio()
    {
        $this->ativo= 1;
        $this->save();
    }

    public function tipoSocioToStr()
    {
        switch ($this->tipo_socio) {
            case 'P':
            return 'Piloto';
            case 'NP':
            return 'Não Piloto';
            case 'A':
            return 'Aeromodelista';
        }
    }

    public function intToStr($inteiro)
    {
        switch ($inteiro) {
            case '1':
            return 'Sim';
            case '0':
            return 'Não';
            case NULL:
            return  'Sem dados';
        }
    }

        public function sexoToStr()
        {
            switch ($this->sexo) {
                case 'M':
                return 'Masculino';
                case 'F':
                return 'Feminino';
            }

        }

        public function ativoToStr()
        {
            switch ($this->ativo) {
                case '1':
                return 'Ativo';
                case '0':
                return 'Desativado';
            }

        }

        public function confirmacaoToStr($inteiro)
        {
            switch ($inteiro) {
                case '1':
                return 'Confirmada';
                case '0':
                return 'Não Confirmada';
                case NULL:
                return  'Sem dados';
            }

        }
        

        public function quotasToStr($inteiro)
        {
            switch ($inteiro) {
                case '1':
                return 'Pagas';
                case '0':
                return 'Por pagar';
                case NULL:
                return  'Sem dados';
            }

        }

        public function existeDados($valor)
        {
            if ($valor == null) {
                return 'Sem dados';
            }
            return $valor;

        }




    }
