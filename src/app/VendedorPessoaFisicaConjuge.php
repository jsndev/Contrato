<?php

namespace App;

use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class VendedorPessoaFisicaConjuge extends Model {
    protected $table = "vendfisconjuge";
    private $entity;

    /**
     * Recuperar conjuge Vendedor do banco de dados
     */
    public function get($codVendedor){
        $this->entity = $this->where('COD_VEND', '=', $codVendedor)->first();
    }

    public function generoOA($generoVendedor) {
        return $generoVendedor ? "a" : "o";
    }

    public function generoEA($generoVendedor) {
        return $generoVendedor ? "a" : "e";
    }

    /**
     * Retorna o nome completo do conjuge
     * @return mixed
     */
    public function getNome() {
        return mb_strtoupper(trim($this->entity->NOME_VFCJ));
    }

    /**
     * Retorna o codigo do pais do do conjuge do vendedor
     * @return mixed
     */
    public function getCodigoPais() {
        return $this->entity->COD_PAIS;
    }

    public function getProfissao() {
        return mb_strtolower(trim($this->entity->CARGOEMP_VFCJ));
    }

    public function getRg() {
        return $this->entity->NRRG_VFCJ;
    }

    public function getRgExpedido() {
        return $this->entity->ORGRG_VFCJ;
    }

    public function getRgDataExpedicao() {
        return Utils::formatarData($this->entity->DTRG_VFCJ);
    }

    public function getCpf() {
        return Utils::formatarCPF_CNPJ($this->entity->CPF_PCCJ);
    }

    public function getFiliacaoMaterna() {
        return Utils::formatarNomes($this->entity->NOME_MAE_CJ);
    }

    public function getFiliacaoPaterna() {
        return Utils::formatarNomes($this->entity->NOME_PAI_CJ);
    }

    public function getEstadoCivil() {
        return $this->entity->COD_ESTCIV;
    }

    public function getRegimeBens() {
        return $this->entity->REGIMEBENS_VFCJ;
    }

    public function getDataCasamento() {
        return $this->entity->DTCASAMENTO_VFCJ;
    }
}
