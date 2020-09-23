<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model{

	protected $guarded=[
	];


    public function naturezaToStr(){
        switch ($this->natureza) {
            case 'T':
                return 'Treino';
            break;

            case 'I':
                return 'Instrução';
            break;

            case 'E':
                return 'Especial';
            break;

            default:
                return 'Natureza desconhecida';
            break;
        }
    }

    public function pagamentoToStr(){
        switch($this->modo_pagamento){
            case 'N':
                return 'Numerário';
            break;

            case 'M':
                return 'Multibanco';
            break;

            case 'T':
                return 'Transferência';
            break;

            case 'P':
                return 'Pacote de horas';
            break;

            default:
                return 'Modo desconhecido';
            break;
        }
    }

    public function confirmadoToStr(){
    	if($this->confirmado == '1'){
    		return 'Sim';
    	}else{
    		return 'Não';
    	}
    }

    public function hasObs(){
    	if($this->observacoes == null){
    		return 'Sem observações';
    	}
    }

    public function hora_aterragem_right(){
    	$str = $this->hora_aterragem;
    	$time = substr($str, -8);
    	return (string) $time;
    }

    public function hora_descolagem_right(){
    	$str = $this->hora_descolagem;
    	$time = substr($str, -8);
    	return (string) $time;
    }

    private function timeOfFlight(){
    	$this->tempo_voo = $this->conta_horas_fim - $this->conta_horas_inicio;
    }

    public function nomePiloto($id){
        $user = User::find($id);
        return $user->nome_informal;
    }

    public function nomeInstrutor($id){
        $user = User::find($id);
        if($user->instrutor_id != null){
            return $user->nome_informal;
        }
    }

    public function instrucaoTipo($id){
        $in = Movimento::find($id);
        switch ($in->tipo_instrucao) {
            case null:
                return 'NA';
                break;
            
            default:
                return $in->tipo_instrucao;
                break;
        }
    }

}
