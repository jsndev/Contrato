<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model {
    protected $table = "imovel";
    private $entity;

    /**
     * Recuperar imovel do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function getQualificacaoImovel() {
        $qualificacao = strip_tags($this->entity->QUALIFICACAO_IMOV);
        $qualificacao = str_replace("&nbsp;", "", $qualificacao);
        return $qualificacao;
    }

    public function getVLAVALGAR_IMOV() {
        return $this->entity->VLAVALGAR_IMOV;
    }

    public function getVLAVALIACAO_IMOV() {
        return $this->entity->VLAVALIACAO_IMOV;
    }
}
