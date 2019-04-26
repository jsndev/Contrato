<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntvQuitante extends Model {
    protected $table = "intvquitante";
    private $entity;

    /**
     * Recuperar intvquitante
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function getNomeIntQ() {
        if (!is_null($this->entity)) {
            return $this->entity->NOME_INTQ;
        }
    }

    public function getQualificacaoIntermitenteQuitante() {
        if (!is_null($this->entity)) {
            $qualificacao = strip_tags($this->entity->QUALIFICACAO_INTQ);
            $qualificacao = str_replace("&nbsp;", "", $qualificacao);
            $primeiraParte = explode(',', $qualificacao)[0];
            $qualificacao = "<b>$primeiraParte</b>" . str_replace($primeiraParte, '',$qualificacao );
            return $qualificacao;
        }
    }
}
