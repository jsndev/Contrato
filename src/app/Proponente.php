<?php

namespace App;

use App\Utils\Utils;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Proponente extends Model {

    protected $table = "proponente";
    private $entity;

    /**
     * Recuperar Proponente do banco de dados
     */
    public function get($codProposta){
        $this->entity = $this->where('COD_PPST', '=', $codProposta)->first();
    }

    public function getNumeroContrato() {
        return trim(UsuarioAthos::where('COD_USUA', '=', $this->entity->COD_PROPONENTE)->first()->ID_LSTN);
    }

    /**
     * Recupera o genero do Proponente para masculino ou feminino
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
     * Devolve o nome completo do proponente
     * @return string
     */
    public function getNome() {
        return mb_strtoupper(trim(UsuarioAthos::where('COD_USUA', '=', $this->entity->COD_PROPONENTE)->first()->NOME_USUA));
    }

    /**
     * Retorna o codigo do pais do proponente
     * @return mixed
     */
    public function getCodigoPais() {
        return $this->entity->NACIONAL_PPNT;
    }

    /**
     * Se o proponente é casado
     * @return bool
     */
    public function isCasado() {
        return ($this->entity->COD_ESTCIV == 2);
    }

    /**
     * Se o proponente está em uma inião estável
     * @return bool
     */
    public function isUniaoEstavel() {
        return ($this->entity->FLGUNIEST_PPNT == "S");
    }

    /**
     * Retorna se o proponente tem algum tipo de comunhao com alguem
     * pode ser casado ou viver sobre uniao estavel
     * @return bool
     */
    public function isCasadoUniaoEstavel() {
        return $this->isCasado() || $this->isUniaoEstavel();
    }

    /**
     * Retorna se o proponente e do sexo masculino ou não
     * @return bool
     */
    public function isMasc() {
        return $this->entity->SEXO_PPNT == "M";
    }

    /**
     * Recupera a profissao do proponente
     */
    public function getProfissao() {
        return mb_strtolower(trim($this->entity->PROFISSAO_PPNT));
    }

    public function getFiliacaoMaterna() {
    return Utils::formatarNomes($this->entity->FILIACAO_MATERNA_PPNT);
}

    public function getFiliacaoPaterna() {
        return Utils::formatarNomes($this->entity->FILIACAO_PATERNA_PPNT);
    }

    public function getEstadoCivil() {
        return $this->entity->COD_ESTCIV;
    }

    public function getRg() {
        return $this->entity->NRRG_PPNT;
    }

    public function getRgExpedido() {
        return $this->entity->ORGRG_PPNT;
    }

    public function getRgDataExpedicao() {
        return Utils::formatarData($this->entity->DTRG_PPNT);
    }

    public function getCpf() {
        return Utils::formatarCPF_CNPJ($this->entity->CPF_PPNT);
    }

    public function getNumeroProposta() {
        return $this->entity->COD_PPST;
    }

    public function getEndereco() {
        $obj = [
            'UNIAO' => $this->isCasadoUniaoEstavel(),
            'COD' => $this->entity->COD_LOGR,
            'ENDERECO' => $this->entity->ENDERECO_PPNT,
            'NRENDERECO' => $this->entity->NRENDERECO_PPNT,
            'BAIRRO' => (empty($this->entity->BAIRRO_PPNT) ? Bairro::getBairro($this->entity->COD_BAIRRO)->NOME_BAIRRO : $this->entity->BAIRRO_PPNT),
            'CPENDERECO' => $this->entity->CPENDERECO_PPNT,
            'MUNICIPIO' => $this->entity->COD_MUNICIPIO,
        ];

        return (object) $obj;
    }

    public function getEmail() {
        $email = UsuarioAthos::where('COD_USUA', '=', $this->entity->COD_PROPONENTE)->first()->EMAIL_USUA;
        return (!empty($email)? trim($email) : "(não informado)" );
    }

    public function getProcurador() {
        return ($this->entity->FLGPROC_PPNT == "S" ? "neste ato representado por seu bastante procurador " .str_replace("  "," ",str_replace(" ,",", ",$this->entity->PROC_PPNT))   : "");
    }

    public function getMaiorIdade() {
        return (($this->entity->FLGUNIEST_PPNT == "S" && $this->entity->COD_ESTCIV == 1) || $this->entity->FLGUNIEST_PPNT == "N" ? ", maior" : "" );
    }

    public function getValorCompra() {
        return $this->entity->VLCOMPRA_PPNT;
    }

    public function getVLENTRADA_PPNT() {
        return $this->entity->VLENTRADA_PPNT;
    }

    public function getCodProponente() {
        return $this->entity->COD_PROPONENTE;
    }

    public function getRessarcimentoSinal() {
        return $this->entity->VLSINAL_PPNT;
    }
}
