<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContasFgts extends Model {
    protected $table = "contasfgts";
    private $entity;

    /**
     * Recuperar contas de fgts do banco de dados
     */
    public function get($codProponente){
        $this->entity = $this->where('COD_USUA', '=', $codProponente)->first();
    }

    public function getFgtsTotal($codProponente) {
        if (!is_null($this->entity)) {
            $this->get($codProponente);
            return $this->entity->total;
        } else {
            return 0;
        }
    }
}
