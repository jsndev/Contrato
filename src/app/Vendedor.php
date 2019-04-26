<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model {
    protected $table = "vendedor";
    private $entity;
    
    /**
     * Recuperar Vendedores do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->get();
    }

    public function getTodosVendedores() {
        return $this->entity;
    }

    /**
     * Devolve o nome completo do vendedor
     * @return string
     */
    public function getNome($key) {
        return mb_strtoupper(trim($this->entity[$key]->NOME_VEND));
    }

    public function getEndereco($key, $isCasadoUniaoEstavel) {
        $obj = [
            'UNIAO' => $isCasadoUniaoEstavel,
            'COD' => $this->entity[$key]->COD_LOGR,
            'ENDERECO' => $this->entity[$key]->ENDERECO_VEND,
            'NRENDERECO' => $this->entity[$key]->NRENDERECO_VEND,
            'BAIRRO' => (empty($this->entity[$key]->BAIRRO_VEND) ? Bairro::getBairro($this->entity[$key]->COD_BAIRRO)->NOME_BAIRRO : $this->entity[$key]->BAIRRO_VEND),
            'CPENDERECO' => $this->entity[$key]->CPENDERECO_VEND,
            'MUNICIPIO' => $this->entity[$key]->COD_MUNICIPIO,
        ];

        return (object) $obj;
    }

    public function getEmail($key) {
        return (!empty($this->entity[$key]->EMAIL_VEND)? trim($this->entity[$key]->EMAIL_VEND) : "(não informado)" );
    }

    public function isJuridica() {
        return ($this->entity[0]->TIPO_VEND == 2);
    }

    public function getQualificacao() {
        return $this->entity[0]->QUALIFICACAO_VEND;
    }

    public function getBancoNome($key) {
        return is_null($this->entity[$key]->BANCO_VEND) ? "Banco do Brasil S/A" : $this->entity[$key]->BANCO_VEND;
    }

    public function getBancoAgencia($key) {
        return $this->entity[$key]->NRAG_VEND;
    }

    public function getBancoConta($key) {
        return $this->entity[$key]->NRCC2_VEND ."-". $this->entity[$key]->DVCC_VEND ;
    }

    public function getPercentualVenda($key) {
        return round($this->entity[$key]->PERCENTUALVENDA_VEND,2);
    }



}
