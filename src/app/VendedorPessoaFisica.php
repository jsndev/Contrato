<?php

namespace App;

use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class VendedorPessoaFisica extends Model  {
    protected $table = "vendfis";
    private $entity;

    /**
     * Recuperar Vendedor do banco de dados
     */
    public function get($codVendedor){
        $this->entity = $this->where('COD_VEND', '=', $codVendedor)->first();
    }

    /**
     * Se o vendedor é casado
     * @return bool
     */
    public function isCasado() {
        return ($this->entity->COD_ESTCIV == 2);
    }

    /**
     * Se o vendedor está em uma inião estável
     * @return bool
     */
    public function isUniaoEstavel() {
        return ($this->entity->FLGUNIEST_VFISICA == "S");
    }

    /**
     * Retorna se o vendedor tem algum tipo de comunhao com alguem
     * pode ser casado ou viver sobre uniao estavel
     * @return bool
     */
    public function isCasadoUniaoEstavel() {
        return $this->isCasado() || $this->isUniaoEstavel();
    }

    /**
     * Retorna se o vendedor e do sexo masculino ou não
     * @return bool
     */
    public function isMasc() {
        return $this->entity->SEXO_VFISICA == "M";
    }

    /**
     * Recupera o genero do vendedor para masculino ou feminino
     * @return string
     */
    public function generoOA() {
        return $this->isMasc() ? "o" : "a";
    }

    /**
     * Recupera o genero do Proponente para masculino ou feminino
     * @return string
     */
    public function generoEA() {
        return $this->isMasc() ? "e" : "a";
    }

    /**
     * Retorna o codigo do pais do vendedor
     * @return mixed
     */
    public function getCodigoPais() {
        return $this->entity->COD_PAIS;
    }

    public function getEstadoCivil() {
        return $this->entity->COD_ESTCIV;
    }

    /**
     * Recupera a profissao do Vendedor
     */
    public function getProfissao() {
        return mb_strtolower(trim($this->entity->PROFISSAO_VFISICA));
    }

    public function getRg() {
        return $this->entity->NRRG_VFISICA;
    }

    public function getRgExpedido() {
        return $this->entity->ORGRG_VFISICA;
    }

    public function getRgDataExpedicao() {
        return Utils::formatarData($this->entity->DTRG_VFISICA);
    }

    public function getCpf() {
        return Utils::formatarCPF_CNPJ($this->entity->CPF_VFISICA);
    }

    public function getFiliacaoMaterna() {
        return Utils::formatarNomes($this->entity->NOMEMAE_VFISICA);
    }

    public function getFiliacaoPaterna() {
        return Utils::formatarNomes($this->entity->NOMEPAI_VFISICA);
    }
}
