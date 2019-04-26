<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CredorQuitante extends Model {
    protected $table = "credorquitante";
    private $entity;

    /**
     * Recuperar credor quitante
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function getFlgCrd() {
        return $this->entity->FLG_CRD == "S";
    }

    public function getTPGRAVAME_CRD() {
        return $this->getFlgCrd() ? $this->entity->TPGRAVAME_CRD : "não há";
    }

    public function getNRREGISTRO_CRD() {
        return $this->getFlgCrd() ? $this->entity->NRREGISTRO_CRD : "não há";
    }

    public function getCARTORIO_CRD() {
        return $this->getFlgCrd() ? $this->entity->CARTORIO_CRD : "não há";
    }

    public function getRECURSOS_CRD() {
        $this->entity->RECURSOS_CRD;
    }
}
