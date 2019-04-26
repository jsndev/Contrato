<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Proposta extends Model {
    protected $table = "proposta";
    private $entity;

    /**
     * Recuperar Proponente do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function getInformacoesAdicionais() {
        return $this->entity->INFOADICIONAISFORT_PPST;
    }

    public function getDataPrimeiroPagamento() {
        if (is_null($this->entity->DTASSCONTRATO_PPST)) {
            return "--";
        } else {
            $data = new DateTime($this->entity->DTASSCONTRATO_PPST);
            $mes = $data->format('m');
            $ano = $data->format('Y');
            $novaData = new DateTime('20-'.$mes.'-'.$ano);
            $novaData->modify('+1 month');
            return $novaData->format('d/m/Y');
        }
    }

    public function getValorPremioAnual() {
        return $this->entity->VALORSEGURO_PPST;
    }

    public function getDataContratoExtenso(){

        if (is_null($this->entity->DTASSCONTRATO_PPST)) {
            return "--";
        } else {
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            return strftime('%A, %d de %B de %Y', strtotime($this->entity->DTASSCONTRATO_PPST));
        }


    }
}
