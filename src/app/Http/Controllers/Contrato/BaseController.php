<?php
/**
 * dw-analytics++
 * Created by Jefferson Fernandes on 17/04/19
 * Copyright © 2018 Jefferson Fernandes. All rights reserved.
 */


namespace App\Http\Controllers\Contrato;
use App\Bairro;
use App\ContasFgts;
use App\CredorQuitante;
use App\Http\Controllers\Controller;
use App\Imovel;
use App\IntvQuitante;
use App\ListaDeNomes;
use App\Logradouro;
use App\Municipio;
use App\Nacionalidade;
use App\Procurador;
use App\Proponente;
use App\ProponenteConjuge;
use App\ProponenteConjugePacto;
use App\Proposta;
use App\RetornoFgts;
use App\Socio;
use App\Utils\Utils;
use App\Utils\WorkData;
use App\Vendedor;
use App\VendedorPessoaFisica;
use App\VendedorPessoaFisicaConjuge;
use App\VendedorPessoaFisicaConjugePacto;
use App\VendedorPessoaJuridica;
use Illuminate\Http\Request;

class BaseController extends Controller {

    protected $proponente;
    protected $vendedor;
    protected $vendedorPessoaFisica;
    protected $proponenteConjuge;
    protected $nacionalidade;
    protected $bairro;
    protected $oa;
    protected $vendedorPessoaFisicaConjuge;
    protected $vendedorPessoaJuridica;
    protected $socio;
    protected $procurador;
    protected $credorQuitante;
    protected $intvQuitante;
    protected $imovel;
    protected $proposta;
    protected $contasFgts;
    protected $listaDeNomes;
    protected $retornoFgts;
    protected $workData;

    public function __construct(Request $request,
                                WorkData $workData,
                                Proponente $proponente,
                                ProponenteConjuge $proponenteConjuge,
                                Nacionalidade $nacionalidade,
                                Bairro $bairro,
                                Vendedor $vendedor,
                                VendedorPessoaFisica $vendedorPessoaFisica,
                                VendedorPessoaFisicaConjuge $vendedorPessoaFisicaConjuge,
                                VendedorPessoaJuridica $vendedorPessoaJuridica,
                                Socio $socio,
                                Procurador $procurador,
                                CredorQuitante $credorQuitante,
                                IntvQuitante $intvQuitante,
                                Imovel $imovel,
                                Proposta $proposta,
                                ContasFgts $contasFgts,
                                ListaDeNomes $listaDeNomes,
                                RetornoFgts $retornoFgts

        ) {
        $this->workData = $workData;
        $this->proponente = $proponente;
        $this->vendedor = $vendedor;
        $this->proponenteConjuge = $proponenteConjuge;
        $this->nacionalidade = $nacionalidade;
        $this->bairro = $bairro;
        $this->vendedorPessoaFisica = $vendedorPessoaFisica;
        $this->vendedorPessoaFisicaConjuge = $vendedorPessoaFisicaConjuge;
        $this->vendedorPessoaJuridica = $vendedorPessoaJuridica;
        $this->socio = $socio;
        $this->procurador = $procurador;
        $this->credorQuitante = $credorQuitante;
        $this->intvQuitante = $intvQuitante;
        $this->imovel = $imovel;
        $this->proposta = $proposta;
        $this->contasFgts = $contasFgts;
        $this->listaDeNomes = $listaDeNomes;
        $this->retornoFgts = $retornoFgts;

        $this->proponente->get($request->proposta);
        $this->proponenteConjuge->get($request->proposta);
        $this->vendedor->get($request->proposta);
        $this->vendedorPessoaJuridica->get($request->proposta);
        $this->socio->get($request->proposta);
        $this->procurador->get($request->proposta);
        $this->credorQuitante->get($request->proposta);
        $this->intvQuitante->get($request->proposta);
        $this->imovel->get($request->proposta);
        $this->proposta->get($request->proposta);
    }

    /**
     * Recupera o estado civil
     * @param $estadoCivil
     * @return string
     */
    protected function estadoCivil($estadoCivil, $genero, $ocultarPlural = false) {
        switch ($estadoCivil) {
            case 1:// solteira
                return "solteir{$genero}";
                break;
            case 2:// casados
                return "casado" . ($ocultarPlural ? '' : 's');
                break;
            case 3:// separado judicialmente
                return "separad{$genero} judicialmente";
                break;
            case 4:// divorciada
                return "divorciad{$genero}";
                break;
            case 5:// viuvo
                return "Viuv{$genero}";
                break;
        }
    }

    /**
     * Recupera a nacionalidade dos compradores
     * @return string
     */
    protected function getNacionalidade($codigoPais, $codPaisConjuge, $isCasado, $isUniaoEstavel, $isMasc) {
        return $this->nacionalidade->get($codigoPais, $codPaisConjuge, $isCasado, $isUniaoEstavel, $isMasc);
    }

    protected function getComunhaoBens() {
        return $this->comunhaoBensCompradores($this->codProposta, ProponenteConjuge::getRegimeBens(), ProponenteConjuge::getDataCasamento());
    }

    protected function comunhaoBensCompradores($codigoProposta, $regimeBens, $dataCasamento) {
        $pacto = ProponenteConjugePacto::where('COD_PPST', '=', $codigoProposta)->first();
        return $this->comunhao($regimeBens, $dataCasamento, $pacto);
    }

    protected function comunhaoBensVendedores($codigoVendedor, $regimeBens, $dataCasamento) {
        $pacto = VendedorPessoaFisicaConjugePacto::where('COD_VEND', '=', $codigoVendedor)->first();
        return $this->comunhao($regimeBens, $dataCasamento, $pacto);
    }

    /**
     * @param $regimeBens
     * @param $dataCasamento
     * @param $pacto
     * @return mixed
     */
    protected function comunhao($regimeBens, $dataCasamento, $pacto) {
        $pacto = (object)array_merge($pacto->toArray(), ['DATA' => Utils::formatarData($dataCasamento)]);
        return str_replace(" ,", ",", Utils::replaceString($this->getRegimeBens($regimeBens, $pacto), $pacto));
    }

    /**
     * @param $regimeBens
     * @param $pacto
     * @return string
     */
    protected function getRegimeBens($regimeBens, $pacto): string {
        switch ($regimeBens) {
            case 1: // Comunhao parcial de bens antes da lei H
                return "pelo regime de Comunhão Parcial de Bens, em #DATA#, conforme escritura de pacto antenupcial lavrada no #LOCALLAVRACAO_PCPA#, no Livro #LIVRO_PCPA#, Folhas #FOLHA_PCPA#, em #DATA_PCPA#, registrada sob o n°. #NUMEROREGISTRO_PCPA#" . $this->getHabes($pacto);
                break;
            case 2: // Comunhao universal de bens antes da lei
                return "pelo regime de Comunhão Universal de Bens, anteriormente a Lei n° 6.515/77, em #DATA#";
                break;
            case 3: // Comunhao universal de bens depois da lei H
                return "pelo regime de Comunhão Universal de Bens, na vigência da Lei n° 6.515/77, em #DATA#, conforme escritura de pacto antenupcial lavrada no #LOCALLAVRACAO_PCPA#, no Livro #LIVRO_PCPA#, Folhas #FOLHA_PCPA#, em #DATA_PCPA#, registrada sob o n°. #NUMEROREGISTRO_PCPA#" . $this->getHabes($pacto);
                break;
            case 5: // Separacao de bens com pacto H
                return "pelo regime de Separação de Bens, em #DATA#, conforme escritura de pacto antenupcial lavrada no #LOCALLAVRACAO_PCPA#, no Livro #LIVRO_PCPA#, Folhas #FOLHA_PCPA#, em #DATA_PCPA#, registrada sob o n°. #NUMEROREGISTRO_PCPA#" . $this->getHabes($pacto);
                break;
            case 6: // Separacao de bens obrigatoria
                return "pelo regime de Separação Obrigatória de bens, nos termos do artigo 1641 do Código Civil Brasileiro, em #DATA#";
                break;
            case 7: // Comunhao parcial de bens depois da lei
                return "pelo regime de Comunhão Parcial de Bens, em #DATA#";
                break;
            default: // União estável
                return "convivendo em união estável, nos termos da Lei nº. 9.278/96 e alterações do art. 1.723 do Código Civil Brasileiro" . (!empty($pacto->LOCALLAVRACAO_PCPA) ? ", conforme escritura de declaração lavrada no #LOCALLAVRACAO_PCPA#, no Livro #LIVRO_PCPA#, Folhas #FOLHA_PCPA#, em #DATA_PCPA#, registrada sob o n°. #NUMEROREGISTRO_PCPA#" : "");
                break;
        }
    }

    private function getHabes($pacto) {
        $habes = " -Registro Auxiliar do #HABENSCART_PCPA#o. Cartório de Registro de Imóveis de #HABENSLOCCART_PCPA#, em #HABENSDATA_PCPA#";
        return ($pacto->HABENS_PCPA == "S" ? Utils::replaceString($habes, $pacto) : '');
    }

    public function endereco($object) {
        $stringCasado = "no(a) %#TIPO#% %#LOGRADOURO#%, nº. #NUMERO#, %#COMPLEMENTO#%, %#BAIRRO#%, %#CIDADE#%, #ESTADO#";
        $stringSolteiro = "no(a) %#TIPO#% %#LOGRADOURO#%, nº. #NUMERO#, %#COMPLEMENTO#%, %#BAIRRO#%, %#CIDADE#%, #ESTADO#";

        list($tipoEndereco, $logradouro, $numero, $bairro, $complemento, $cidade, $estado) = $this->extrairDadosEndereco($object);

        $obj = (object) array(
            'TIPO' => $tipoEndereco,
            'LOGRADOURO' => $logradouro,
            'NUMERO' => $numero,
            'BAIRRO' => $bairro,
            'CIDADE' => $cidade,
            'ESTADO' => $estado,
            'COMPLEMENTO' => $complemento,
        );

        $enderecoCompleto = Utils::replaceString(($object->UNIAO ? $stringCasado : $stringSolteiro ), $obj );
        $enderecoCompleto = str_replace(", ,",",",$enderecoCompleto);

        return $enderecoCompleto;
    }

    /**
     * Extrai dados de endereco de uma pessoa
     * @param $object
     * @return array
     */
    public function extrairDadosEndereco($object): array {
        $tipoEndereco = Logradouro::getTipoLogradouro($object->COD)->DESC_LOGR;
        $logradouro = $object->ENDERECO;
        $numero = $object->NRENDERECO;
        $bairro = $object->BAIRRO;
        $complemento = (empty($object->CPENDERECO)? "" : $object->CPENDERECO);
        $cidade = Municipio::getMunicipio($object->MUNICIPIO)->NOME_MUNICIPIO;
        $estado = Municipio::getMunicipio($object->MUNICIPIO)->COD_UF;
        return array($tipoEndereco, $logradouro, $numero, $bairro, $complemento, $cidade, $estado);
    }


    public function getAfiliacao($nomePai, $nomeMae, $genero) {
        $genero =  "filh" . $genero . " de ";

        if (!empty($nomeMae) && !empty($nomePai)){
            return $genero . Utils::formatarNomes($nomePai). " e " . Utils::formatarNomes($nomeMae);
        } elseif(!empty($nomePai)) {
            return $genero . Utils::formatarNomes($nomePai);
        } elseif(!empty($nomeMae)) {
            return $genero . Utils::formatarNomes($nomeMae);
        }
    }
}
