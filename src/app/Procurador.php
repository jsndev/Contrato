<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procurador extends Model {
    protected $table = "vendprocurador";

    private $entity;

    /**
     * Recuperar procurador do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function isProcurador() {
        return !is_null($this->entity);
    }

    public function getProcurador() {
        return $this->entity->PROC_VPROC;
    }
}
