<?php

namespace App;

use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class VendedorPessoaJuridica extends Model {
    protected $table = "vendjur";

    private $entity;

    /**
     * Recuperar Vendedor do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function comVersao() {
        return ($this->entity->VERSAOESTAT_VJUR != null);
    }

    public function versao() {
        return $this->entity->VERSAOESTAT_VJUR;
    }

    public function getCnpj() {
        return Utils::formatarCPF_CNPJ($this->entity->CNPJ_VJUR);
    }

    public function getDataVersao() {
        return Utils::formatarData($this->entity->DTESTAT_VJUR);
    }

    public function getRegistradaEm() {
        return $this->entity->LOCESTAT_VJUR;
    }
    public function getNumeroRegistro() {
        return $this->entity->NRREGESTAT_VJUR;
    }
}
