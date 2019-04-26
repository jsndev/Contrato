<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaDeNomes extends Model {
    protected $table = "listadenomes";
    private $entity;

    /**
     * Recuperar lista de nomes do banco de dados
     */
    public function get($id_lstn){
        $this->entity = $this->where('id_lstn', '=', $id_lstn)->first();
    }

    public function getPrazoFinal($numeroContrato) {
        $this->get($numeroContrato);
        return $this->entity->PRZAPROVADO;
    }

    public function getValorPrimeiroPagamento() {
        return $this->entity->PARCAPROVADA;
    }
}
