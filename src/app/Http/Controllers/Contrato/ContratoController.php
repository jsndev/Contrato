<?php

namespace App\Http\Controllers\Contrato;
use App\Financiador;
use App\UsuarioAthos;
use App\Utils\Utils;
use Barryvdh\DomPDF\Facade as PDF;

class ContratoController extends BaseController {
    public function index() {

        $pdf = PDF::setOptions([
            'dpi' => 150,
            'defaultFont' => 'courier',
            'isHtml5ParserEnabled' => true,
            "isPhpEnabled" => true
        ]);


        return $pdf->loadView('contrato.proponentes', $this->getProponentes())->stream();
        //return view('contrato.proponentes', $this->getProponentes());
    }

    private function getProponentes() {

        return [
            "numeroContrato" => $this->proponente->getNumeroContrato(),
            "tipoUniao" => ($this->proponente->isCasado() ? "C" : ($this->proponente->isUniaoEstavel() ? "U" : "S")),
            "generoOAProponente" => $this->proponente->generoOA(),
            "generoEAProponente" => $this->proponente->generoEA(),
            "generoOAProponenteConjuge" => $this->proponenteConjuge->generoOA($this->proponente->isMasc()),
            "generoEAProponenteConjuge" => $this->proponenteConjuge->generoEA($this->proponente->isMasc()),

            "nomeProponente" => $this->proponente->getNome(),
            "nacionalidadeProponente" => $this->getNacionalidade($this->proponente->getCodigoPais(), $this->proponenteConjuge->getCodigoPais(),  $this->proponente->isCasado(), $this->proponente->isUniaoEstavel(), $this->proponente->isMasc()),
            "profissaoProponente" => $this->proponente->getProfissao(),
            "afiliacaoProponente" => $this->getAfiliacao($this->proponente->getFiliacaoPaterna(), $this->proponente->getFiliacaoMaterna(), $this->proponente->generoOA()),
            "estadoCivilProponente" => $this->estadoCivil($this->proponente->getEstadoCivil(), $this->proponente->generoOA()),
            "maiorIdade" => $this->proponente->getMaiorIdade(),
            "numeroRgProponente" => $this->proponente->getRg(),
            "emissaoRgProponente" => $this->proponente->getRgExpedido(),
            "dataEmissaoRgProponente" => $this->proponente->getRgDataExpedicao(),
            "cpfProponente" => $this->proponente->getCpf(),
            "nomeProponenteConjuge" => $this->proponenteConjuge->getNome(),
            "nacionalidadeProponenteConjuge" => $this->getNacionalidade($this->proponenteConjuge->getCodigoPais(),false, $this->proponente->isCasado(), $this->proponente->isUniaoEstavel(), !$this->proponente->isMasc() ),
            "profissaoProponenteConjuge" => $this->proponenteConjuge->getProfissao(),
            "afiliacaoProponenteConjuge" => $this->getAfiliacao($this->proponenteConjuge->getFiliacaoPaterna(), $this->proponenteConjuge->getFiliacaoMaterna(), $this->proponenteConjuge->generoOA($this->proponente->isMasc())),
            "estadoCivilProponenteConjuge" => $this->estadoCivil($this->proponenteConjuge->getEstadoCivil(), $this->proponenteConjuge->generoOA($this->proponente->isMasc())),
            "numeroRgProponenteConjuge" => $this->proponenteConjuge->getRg(),
            "emissaoRgProponenteConjuge" => $this->proponenteConjuge->getRgExpedido(),
            "dataEmissaoRgProponenteConjuge" => $this->proponenteConjuge->getRgDataExpedicao(),
            "cpfProponenteConjuge" => $this->proponenteConjuge->getCpf(),
            "comunhaoBens" => $this->comunhaoBensCompradores($this->proponente->getNumeroProposta(), $this->proponenteConjuge->getRegimeBens(), $this->proponenteConjuge->getDataCasamento()),
            "endereco" => $this->endereco($this->proponente->getEndereco()),
            "email" => $this->proponente->getEmail(),
            "procurador" => $this->proponente->getProcurador(),
            "juridica" => $this->vendedor->isJuridica(),
            "vendedores" => ($this->vendedor->isJuridica() ? $this->recuperarVendedoresJuridica() : (object)$this->recuperarVendedores()),

            "nomeFinanciador" => Financiador::getNomeFinanciado(),
            "dadosFinanciador" => Financiador::getDadosFinanciador(),
            "intermitenteQuitante" => $this->intvQuitante->getQualificacaoIntermitenteQuitante(),
            "qualificacaoImovel" => $this->imovel->getQualificacaoImovel(),
            "informacoesAdicionais" => $this->proposta->getInformacoesAdicionais(),
            "bancoAgencia" => $this->retornoFgts->getBancoAgencia($this->proponente->getNumeroContrato()),
            "bancoConta" => $this->retornoFgts->getBancoConta(),


            "contrato" => (object)[
                "apartamentoCasa" => Utils::formatarMoeda($this->proponente->getValorCompra() - $this->imovel->getVLAVALGAR_IMOV()),
                "garagem" => Utils::formatarMoeda($this->imovel->getVLAVALGAR_IMOV()),
                "total" => Utils::formatarMoeda($this->proponente->getValorCompra()),
                "avaliacao" => Utils::formatarMoeda($this->imovel->getVLAVALIACAO_IMOV()),
                "recursosProprios" => Utils::formatarMoeda($this->proponente->getVLENTRADA_PPNT()),
                "recursosFGTS" => Utils::formatarMoeda($this->contasFgts->getFgtsTotal($this->proponente->getCodProponente())),
                "ressarcimentoSinal" => Utils::formatarMoeda($this->proponente->getRessarcimentoSinal()),
                "recursosFinanciamento" => Utils::formatarMoeda($this->getValorRecursosFinanciamento()),
                "gravame" => $this->credorQuitante->getTPGRAVAME_CRD(),
                "favorecido" => $this->getFavorecido(),
                "numeroRegistro" => $this->credorQuitante->getNRREGISTRO_CRD(),
                "cartorioDeRgi" => $this->credorQuitante->getCARTORIO_CRD(),
                "recursosLiberadosVendedor" => Utils::formatarMoeda($this->getRecursosLiberadosVendedor()),
                "recursosLiberadosCredorQuitante" => Utils::formatarMoeda($this->credorQuitante->getRECURSOS_CRD()),
                "recursosLiberadosDevedor" => Utils::formatarMoeda($this->proponente->getRessarcimentoSinal()),
                "valorFinanciamento" => Utils::formatarMoeda($this->getValorRecursosFinanciamento()),
                "dataPrimeiroPagamento" => $this->proposta->getDataPrimeiroPagamento(),
                "prazoFinal" => $this->listaDeNomes->getPrazoFinal($this->proponente->getNumeroContrato()),
                "primeiroPagamento" => Utils::formatarMoeda($this->listaDeNomes->getValorPrimeiroPagamento()),
                "valorPremioAnual" => Utils::formatarMoeda($this->proposta->getValorPremioAnual()),
                "dataContrato" => $this->proposta->getDataContratoExtenso(),
            ],
            "assinaturaVendedores" => $this->getVendedoresAssinatura()
        ];
    }

    private function getVendedoresAssinatura() {
        $vendedores = [];

        foreach ($this->vendedor->getTodosVendedores() as $key => $vend ):
            $this->vendedorPessoaFisica->get($vend->COD_VEND);
            $this->vendedorPessoaFisicaConjuge->get($vend->COD_VEND);

            if ($this->vendedor->isJuridica()) {
                array_push($vendedores,
                    $this->vendedor->getNome($key) . ' - ' . $this->vendedorPessoaJuridica->getCnpj()
                );
            } else {
                if ($this->vendedorPessoaFisica->isCasadoUniaoEstavel()) {

                    array_push($vendedores,
                        $this->vendedor->getNome($key) . ' - ' . $this->vendedorPessoaFisica->getCpf()
                    );
                    array_push($vendedores,
                        $this->vendedorPessoaFisicaConjuge->getNome() . ' - ' . $this->vendedorPessoaFisicaConjuge->getCpf()
                    );
                } else {
                    array_push($vendedores,
                        $this->vendedor->getNome($key) . ' - ' . $this->vendedorPessoaFisica->getCpf()
                    );
                }
            }
        endforeach;

        return $vendedores;

    }

    private function getRecursosLiberadosVendedor() {
        return ($this->getValorRecursosFinanciamento() - $this->credorQuitante->getRECURSOS_CRD()) + $this->contasFgts->getFgtsTotal($this->proponente->getCodProponente()) - $this->proponente->getRessarcimentoSinal();

    }

    private function getValorRecursosFinanciamento() {
        return $this->proponente->getValorCompra() - $this->proponente->getVLENTRADA_PPNT() - $this->contasFgts->getFgtsTotal($this->proponente->getCodProponente());
    }

    private function getFavorecido() {
        if ($this->credorQuitante->getFlgCrd()):
            return !is_null($this->intvQuitante->getNomeIntQ()) ? $this->intvQuitante->getNomeIntQ() : "Caixa de Previdência dos Funcionários do Banco do Brasil";
         else:
            return "não há";
        endif;
    }

    private function recuperarSocios() {
        $socios = [];

        foreach ($this->socio->getTodosSocios() as $key => $socio ):

            array_push($socios, (object) [
                "nomeSocio" => $this->socio->getNome($key),
                "isMasc" => $this->socio->isMasc($key),
                "nacionalidadeSocio" => $this->getNacionalidade($this->socio->getCodigoPais($key),false, false, false, $this->socio->isMasc($key)),
                "estadoCivilSocio" => $this->estadoCivil($this->socio->getEstadoCivil($key), $this->socio->generoOA($key), true),
                "profissaoSicio" => $this->socio->getProfissao($key),
                "numeroRgSocio" => $this->socio->getRg($key),
                "emissaoRgSocio" => $this->socio->getRgExpedido($key),
                "cpfSocio" => $this->socio->getCpf($key),
                "enderecoSocio" => $this->endereco($this->socio->getEndereco($key,false)),
            ]);

        endforeach;
        return $socios;
    }

    private function recuperarVendedoresJuridica() {
        $vendedores = [];
        foreach ($this->vendedor->getTodosVendedores() as $key => $vend):
            array_push($vendedores, (object)[
                "comVersao" => $this->vendedorPessoaJuridica->comVersao(),
                "nomeVendedor" => $this->vendedor->getNome($key),
                "endereco" => $this->endereco($this->vendedor->getEndereco($key, false)),
                "cnpj" => $this->vendedorPessoaJuridica->getCnpj(),
                "versao" => $this->vendedorPessoaJuridica->versao(),
                "versaoData" => $this->vendedorPessoaJuridica->getDataVersao(),
                "registradaEm" => $this->vendedorPessoaJuridica->getRegistradaEm(),
                "numeroRegistro" => $this->vendedorPessoaJuridica->getNumeroRegistro(),
                "socios" => $this->recuperarSocios(),
                "procurador" => $this->recuperarProcurador(),
                "email" => $this->vendedor->getEmail($key),
                "bancoNome" => $this->vendedor->getBancoNome($key),
                "bancoAgencia" => $this->vendedor->getBancoAgencia($key),
                "bancoConta" => $this->vendedor->getBancoConta($key),
                "percentualVenda" => $this->vendedor->getPercentualVenda($key)

            ]);
        endforeach;
        return $vendedores;
    }

    private function recuperarProcurador() {
        if ($this->procurador->isProcurador()):
            return $this->procurador->getProcurador();
        endif;
    }

    private function recuperarVendedores() {
        $vendedores = [];

        foreach ($this->vendedor->getTodosVendedores() as $key => $vend ):
            $this->vendedorPessoaFisica->get($vend->COD_VEND);
            $this->vendedorPessoaFisicaConjuge->get($vend->COD_VEND);

            array_push($vendedores, (object) [
                "tipoUniao" => ($this->vendedorPessoaFisica->isCasado() ? "C" : ($this->vendedorPessoaFisica->isUniaoEstavel() ? "U" : "S")),
                "generoOAVendedor" => $this->vendedorPessoaFisica->generoOA(),
                "generoEAVendedor" => $this->vendedorPessoaFisica->generoEA(),
                "generoOAVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->generoOA($this->vendedorPessoaFisica->isMasc()),
                "generoEAVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->generoEA($this->vendedorPessoaFisica->isMasc()),

                "nomeVendedor" => $this->vendedor->getNome($key),
                "nacionalidadeVendedor" => $this->getNacionalidade($this->vendedorPessoaFisica->getCodigoPais(), $this->vendedorPessoaFisicaConjuge->getCodigoPais(),  $this->vendedorPessoaFisica->isCasado(), $this->vendedorPessoaFisica->isUniaoEstavel(), $this->vendedorPessoaFisica  ->isMasc()),
                "profissaoVendedor" => $this->vendedorPessoaFisica->getProfissao(),
                "afiliacaoVendedor" => $this->getAfiliacao($this->vendedorPessoaFisica->getFiliacaoPaterna(), $this->vendedorPessoaFisica->getFiliacaoMaterna(), $this->vendedorPessoaFisica->generoOA()),
                "estadoCivilVendedor" => $this->estadoCivil($this->vendedorPessoaFisica->getEstadoCivil(), $this->vendedorPessoaFisica->generoOA()),
                "numeroRgVendedor" => $this->vendedorPessoaFisica->getRg(),
                "emissaoRgVendedor" => $this->vendedorPessoaFisica->getRgExpedido(),
                "dataEmissaoRgVendedor" => $this->vendedorPessoaFisica->getRgDataExpedicao(),
                "cpfVendedor" => $this->vendedorPessoaFisica->getCpf(),
                "nomeVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->getNome(),
                "nacionalidadeVendedorConjuge" => $this->getNacionalidade($this->vendedorPessoaFisicaConjuge->getCodigoPais(),false, $this->vendedorPessoaFisica->isCasado(), $this->vendedorPessoaFisica->isUniaoEstavel(), !$this->vendedorPessoaFisica->isMasc() ),
                "profissaoVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->getProfissao(),
                "afiliacaoVendedorConjuge" => $this->getAfiliacao($this->vendedorPessoaFisicaConjuge->getFiliacaoPaterna(), $this->vendedorPessoaFisicaConjuge->getFiliacaoMaterna(), $this->vendedorPessoaFisicaConjuge->generoOA($this->vendedorPessoaFisica->isMasc())),
                "estadoCivilVendedorConjuge" => $this->estadoCivil($this->vendedorPessoaFisicaConjuge->getEstadoCivil(), $this->vendedorPessoaFisicaConjuge->generoOA($this->vendedorPessoaFisica->isMasc())),
                "numeroRgVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->getRg(),
                "emissaoRgVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->getRgExpedido(),
                "dataEmissaoRgVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->getRgDataExpedicao(),
                "cpfVendedorConjuge" => $this->vendedorPessoaFisicaConjuge->getCpf(),
                "comunhaoBens" => $this->comunhaoBensVendedores($vend->COD_VEND, $this->vendedorPessoaFisicaConjuge->getRegimeBens(), $this->vendedorPessoaFisicaConjuge->getDataCasamento()),
                "endereco" => $this->endereco($this->vendedor->getEndereco($key,$this->vendedorPessoaFisica->isCasadoUniaoEstavel())),
                "email" => $this->vendedor->getEmail($key),
                "procurador" => "",
                "maiorIdade" => "",
                "bancoNome" => $this->vendedor->getBancoNome($key),
                "bancoAgencia" => $this->vendedor->getBancoAgencia($key),
                "bancoConta" => $this->vendedor->getBancoConta($key),
                "percentualVenda" => $this->vendedor->getPercentualVenda($key)
            ]);
        endforeach;
        return $vendedores;

    }
}
