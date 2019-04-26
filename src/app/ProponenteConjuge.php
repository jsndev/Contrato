<?php

namespace App;

use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class ProponenteConjuge extends Model {

    protected $table = "proponenteconjuge";
    private $entity;

    /**
     * Recuperar Proponente do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    /**
     * Retorna o codigo do pais do do conjuge do proponente
     * @return mixed
     */
    public function getCodigoPais() {
        return $this->entity->COD_PAIS;
    }

    /**
     * Retorna o nome completo do conjuge
     * @return mixed
     */
    public function getNome() {
        return mb_strtoupper(trim($this->entity->NOME_PPCJ));
    }

    public function getProfissao() {
        return mb_strtolower(trim($this->entity->CARGOEMP_PPCJ));
    }

    public function generoOA($generoProponente) {
        return $generoProponente ? "a" : "o";
    }

    public function generoEA($generoProponente) {
        return $generoProponente ? "a" : "e";
    }

    public function getFiliacaoMaterna() {
        return Utils::formatarNomes($this->entity->FILIACAO_MATERNA_PPCJ);
    }

    public function getFiliacaoPaterna() {
        return Utils::formatarNomes($this->entity->FILIACAO_PATERNA_PPCJ);
    }

    public function getEstadoCivil() {
        return $this->entity->COD_ESTCIV;
    }

    public function getRg() {
        return $this->entity->NRRG_PPCJ;
    }

    public function getRgExpedido() {
        return $this->entity->ORGRG_PPCJ;
    }

    public function getRgDataExpedicao() {
        return Utils::formatarData($this->entity->DTRG_PPCJ);
    }

    public function getCpf() {
        return Utils::formatarCPF_CNPJ($this->entity->CPF_PCCJ);
    }

    public function getRegimeBens() {
        return $this->entity->REGIMEBENS_PPCJ;
    }

    public function getDataCasamento() {
        return $this->entity->DTCASAMENTO_PPCJ;
    }
}
