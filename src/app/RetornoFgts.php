<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetornoFgts extends Model {
    protected $table = "retornofgts";
    private $entity;

    /**
     * Recuperar lista de nomes do banco de dados
     */
    public function get($id_lstn){
        $this->entity = $this->where('participante', '=', $id_lstn)->first();
    }

    public function getBancoAgencia($id_lstn) {
        $this->get($id_lstn);
        return $this->entity->nragencia;
    }

    public function getBancoConta() {
        return intval($this->entity->nrconta);
    }
}
