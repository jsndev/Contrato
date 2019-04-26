<?php

namespace App;

use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model {
    protected $table = "vendjursocio";

    private $entity;

    /**
     * Recuperar Socios do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->get();
    }

    public function getTodosSocios() {
        return $this->entity;
    }

    /**
     * Devolve o nome completo do socio
     * @return string
     */
    public function getNome($key) {
        return mb_strtoupper(trim($this->entity[$key]->NOME_VJSOC));
    }

    /**
     * Retorna se o socio e do sexo masculino ou não
     * @return bool
     */
    public function isMasc($key) {
        return $this->entity[$key]->SEXO_VJSOC == "M";
    }

    /**
     * Retorna o codigo do pais do socio
     * @return mixed
     */
    public function getCodigoPais($key) {
        return $this->entity[$key]->COD_PAIS;
    }

    public function getEstadoCivil($key) {
        return $this->entity[$key]->COD_ESTCIV;
    }

    /**
     * Recupera o genero do socio para masculino ou feminino
     * @return string
     */
    public function generoOA($key) {
        return $this->isMasc($key) ? "o" : "a";
    }

    /**
     * Recupera a profissao do socio
     */
    public function getProfissao($key) {
        return mb_strtolower(trim($this->entity[$key]->CARGO_VJSOC));
    }

    public function getRg($key) {
        return $this->entity[$key]->NRRG_VJSOC;
    }

    public function getRgExpedido($key) {
        return $this->entity[$key]->ORGRG_VJSOC;
    }

    public function getCpf($key) {
        return Utils::formatarCPF_CNPJ($this->entity[$key]->CPF_VJSOC);
    }

    public function getEndereco($key, $isCasadoUniaoEstavel) {
        $obj = [
            'UNIAO' => $isCasadoUniaoEstavel,
            'COD' => $this->entity[$key]->COD_LOGR,
            'ENDERECO' => $this->entity[$key]->ENDERECO_VJSOC,
            'NRENDERECO' => $this->entity[$key]->NRENDERECO_VJSOC,
            'BAIRRO' => (empty($this->entity[$key]->BAIRRO_VJSOC) ? Bairro::getBairro($this->entity[$key]->COD_BAIRRO)->NOME_BAIRRO : $this->entity[$key]->BAIRRO_VJSOC),
            'CPENDERECO' => $this->entity[$key]->CPENDERECO_VJSOC,
            'MUNICIPIO' => $this->entity[$key]->COD_MUNICIPIO,
        ];

        return (object) $obj;
    }
}
