<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <style>
        @page {
            margin-top: 180px;
            margin-bottom: 70px;
            margin-right: 50px;
            margin-left: 50px;
        }

        table {
            background-color: #1f6fb2;
        }

        tr {
            line-height: 25px;
            min-height: 5px;
            height: 25px;
        }

        .header {
            position: fixed;
            left: -50px;
            top: -180px;
            right: -50px;
            height: 170px;
            text-align: center;
        }

        .footer {
            border-color: #5a6268;
            border-style: solid;
            border-width: thin;
            position: fixed;
            left: 0px;
            bottom: -50px;
            right: 0px;
            height: 50px;
            text-align: center;
        }

        .footer .pagenum:before {
            font-size: 9pt;
            content: "Pagina - " counter(page)
        }

        .table-condensed {
            font-size: 8pt;
        }

        .table-assinatura tr {
            line-height: 5px;
            min-height: 5px;
            height: 50px;
        }

        .athos-font {
            font-family: 'Helvetica';
            font-size: 11pt;
            font-weight: 400;
            line-height: 1.5 !important;
        }

        bup {
            text-transform: uppercase;
            font-weight: bold;
        }

        @font-face {
            font-family: "Helvetica";
        }

        .page-break {
            page-break-before: always!important;
        }

    </style>
    <title>Contrato</title>
</head>
<body>

<!-- Define header and footer blocks before your content -->

<div class="header">
    <img src="{{ public_path('image/top.png') }}" width="100%" height="100%"/>
</div>
<div class="footer">
    <table class="table table-condensed">
        <tbody>
        <tr>
            <td class="text-left">Rubrica das partes:</td>
            <td class="text-right pagenum"></td>
        </tr>
        </tbody>
    </table>
</div>
<div class="row ">
    <div class="col-lg-12  font-weight-bold border">
        <h6 class="text-center">
            CONTRATO DE COMPRA E VENDA DE IMÓVEL COM FINANCIAMENTO, ALIENAÇÃO FIDUCIÁRIA DE IMÓVEL E OUTRAS AVENÇAS -
            Nº {{ $numeroContrato }}
        </h6>
    </div>
</div>
<br>
<br>

<div class="row ">
    <div class="col col-lg-12 font-weight-bold">
        <p>PREÂMBULO</p>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            COMPRADOR(A,ES):
            <br>
            @if ( $tipoUniao == "C")
                @yield('proponentes.casados')
            @elseif($tipoUniao == "U")
                @yield('proponentes.uniao.estavel')
            @else
                @yield('proponentes.solteiro')
            @endif
        </p>
    </div>
</div>

<div class="row ">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            VENDEDOR(A,ES):
            <br>
            {{--debug--}}
            {{--{{ dd(get_defined_vars()) }}--}}

            @if($juridica)
                @foreach($vendedores as $key => $vendedor)
                    @if($vendedor->comVersao)
                        @include('contrato.vendedores.juridica.com-versao')
                    @else
                        @include('contrato.vendedores.juridica.sem-versao')
                    @endif
                    @if(is_null($vendedor->procurador))
                        @foreach($vendedor->socios as $keySocio => $socio)
                            @include('contrato.vendedores.juridica.socio')
                        @endforeach
                    @else
                        @include('contrato.vendedores.juridica.procurador')
                    @endif
                @endforeach
            @else
                @foreach($vendedores as $key => $vendedor)
                    @php
                        $contador = (count((array)$vendedores) > 1 ) ? $key + 1 . "- " : "";
                    @endphp
                    <b>{{ $contador }}</b>
                    @if ( $vendedor->tipoUniao == "C")
                        @include('contrato.vendedores.fisica.casados')
                    @elseif($vendedor->tipoUniao == "U")
                        @include('contrato.vendedores.fisica.uniao-estavel')
                    @else
                        @include('contrato.vendedores.fisica.solteiro')
                    @endif
                @endforeach
                @include('contrato.vendedores.fisica.doravente ')
            @endif
        </p>
    </div>
</div>

<div class="row ">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            FINANCIADOR - CREDOR FIDUCÍARIO:
            <br>
            @include('contrato.financiador ')
        </p>
    </div>
</div>

@if($intermitenteQuitante)
    <div class="row">
        <div class="col col-lg-12">
            <p class="athos-font text-justify">
                INTERVENIENTE QUITANTE:
                <br>
                {!!html_entity_decode($intermitenteQuitante)!!}
            </p>
        </div>
    </div>
@endif

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO II - IMÓVEL OBJETO DESTE CONTRATO:
            <br>
            {{--{!!html_entity_decode($qualificacaoImovel) !!}--}}
        </p>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO III – PREÇO DA COMPRA E VENDA
        </p>
        <table class="table table-condensed table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">Apartamento/Casa</th>
                <th scope="col">Garagem</th>
                <th scope="col">Total</th>
                <th scope="col">Avaliação</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $contrato->apartamentoCasa }}</td>
                <td>{{ $contrato->garagem }}</td>
                <td>{{ $contrato->total }}</td>
                <td>{{ $contrato->avaliacao }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO IV – ORIGEM DOS RECURSOS PARA PAGAMENTO DA COMPRA E VENDA
        </p>
        <table class="table table-condensed table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">Recursos Próprios</th>
                <th scope="col">Recursos FGTS</th>
                <th scope="col">Ressarcimento de Sinal</th>
                <th scope="col">Recursos Financiamento</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $contrato->recursosProprios }}</td>
                <td>{{ $contrato->recursosFGTS }}</td>
                <td>{{ $contrato->ressarcimentoSinal }}</td>
                <td>{{ $contrato->recursosFinanciamento }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO V – GRAVAMES EXISTENTES SOBRE O IMÓVEL
        </p>
        <table class="table table-condensed table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">Gravame</th>
                <th scope="col">Favorecido</th>
                <th scope="col">N° do Registro</th>
                <th scope="col">Cartório de R.G.I</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $contrato->gravame }}</td>
                <td>{{ $contrato->favorecido }}</td>
                <td>{{ $contrato->numeroRegistro }}</td>
                <td>{{ $contrato->cartorioDeRgi }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">QUADRO VI – FORMA DE LIBERAÇÃO DOS RECURSOS DO FINANCIAMENTO</p>

        @php $multiplasContas = (count((array)$vendedores) > 1); @endphp
        <table class="table table-condensed table-bordered text-left">
            <tbody>
            <tr>
                <td colspan="4">1. Recursos liberados ao VENDEDOR (FGTS + Financiamento):</td>
                <td>{{ $contrato->recursosLiberadosVendedor }}</td>
            </tr>
            <tr>
                <td colspan="4">2. Recursos liberados ao CREDOR QUITANTE (recursos do Financiamento):</td>
                <td>{{ $contrato->recursosLiberadosCredorQuitante }}</td>
            </tr>
            <tr>
                <td colspan="4">3. Recursos liberados ao DEVEDOR (em caso de ressarcimento de sinal):</td>
                <td>{{ $contrato->recursosLiberadosDevedor }}</td>
            </tr>


            <tr>
                <td colspan="5">4. Credito em conta corrente:</td>
            </tr>
            <tr>
                <td colspan="5">4.1 Vendedor{{ $multiplasContas? "(a,es)" : "" }}:</td>
            </tr>
            <tr>
                <td>Nome</td>
                <td>Banco</td>
                <td class="text-center">Agência</td>
                <td class="text-center">Conta Corrente-DV</td>
                <td class="text-right">%</td>
            </tr>


            @foreach($vendedores as $key => $vendedor)
                <tr>
                    <td>{{ $vendedor->nomeVendedor }}</td>
                    <td>{{ $vendedor->bancoNome }}</td>
                    <td class="text-center">{{ $vendedor->bancoAgencia }}</td>
                    <td class="text-center">{{ $vendedor->bancoConta }}</td>
                    <td class="text-right">{{ $vendedor->percentualVenda }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="5">4.2 Comprador{{ $multiplasContas? "(a,es)" : "" }}: </td>
            </tr>
            <tr>
                <td colspan="2">Nome</td>
                <td>Banco</td>
                <td class="text-center">Agência</td>
                <td class="text-center">Conta Corrente-DV</td>
            </tr>
            <tr>
                <td colspan="2">{{ $vendedor->nomeVendedor }}</td>
                <td>{{ $vendedor->bancoNome }}</td>
                <td class="text-center">{{ $bancoAgencia }}</td>
                <td class="text-center">{{ $bancoConta }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO VII – CONDIÇÕES DO FINANCIAMENTO
            <br>
        </p>
        <table class="table table-condensed table-bordered text-left">
            <tbody>
            <tr>
                <td>1. Valor do Financiamento:</td>
                <td>{{ $contrato->valorFinanciamento }}</td>
                <td>2. Prazo total do Financiamento:</td>
                <td>{{ $contrato->prazoFinal }} meses</td>
            </tr>
            <tr>
                <td>3. Índice de atualização Monetária:</td>
                <td>INPC</td>
                <td>4. Taxa Efetiva Anual de Juros:</td>
                <td>5,000 %</td>
            </tr>
            <tr>
                <td>5. Taxa Efetiva Mensal de Juros:</td>
                <td>0,407%</td>
                <td>6. Fundo de Liquidez (FL):</td>
                <td>0,24% a.a</td>
            </tr>
            <tr>
                <td>7. Fundo de Quitação por Morte (FQM):</td>
                <td colspan="3"> 0,25% a.a. até 59 anos  ou 1,80% a.a. a partir de 60 anos</td>
            </tr>
            <tr>
                <td>8. Data primeiro pagamento:</td>
                <td>{{ $contrato->dataPrimeiroPagamento }}</td>
                <td>9. Valor primeiro pagamento:</td>
                <td>{{ $contrato->primeiroPagamento }}</td>
            </tr>
            <tr>
                <td>10. Forma de pagamento:</td>
                <td>Consignação em folha BB, Previ ou INSS</td>
                <td>11. taxa adm. mensal:</td>
                <td>R$ 19,00</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO VIII – SEGURO DE DANOS FÍSICOS AO IMÓVEL
            <br>
        </p>
        <table class="table table-condensed table-bordered text-left">
            <tbody>
            <tr>
                <td>1. Valor do primeiro prêmio anual:</td>
                <td>{{ $contrato->valorPremioAnual }}</td>
                <td>2. Data de pagamento:</td>
                <td>{{ $contrato->dataPrimeiroPagamento }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            QUADRO IX – CLÁUSULAS ADICIONAIS
            <br>
            {{ $informacoesAdicionais }}
        </p>

    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            <b>REÚNEM-SE</b> as Partes, anteriormente nomeadas e qualificadas, para, de mútuo acordo, celebrar, por meio
            deste instrumento particular com força de escritura pública, o presente CONTRATO DE COMPRA E VENDA
            DE IMÓVEL COM FINANCIAMENTO, GARANTIA DE ALIENAÇÃO FIDUCIÁRIA E OUTRAS
            AVENÇAS (“Contrato”), integrado para todos os efeitos de direito pelos Quadros que se encontram
            preenchidos no preâmbulo, garantido por alienação fiduciária de imóvel, constituída nos termos da Lei nº
            9.514/97, e regido pelas cláusulas, termos e condições a seguir:
            <br>
            <br>

            <b>CLÁUSULA 1 – COMPRA E VENDA DO IMÓVEL</b>
            <br>
            O VENDEDOR, na qualidade de proprietário e legítimo possuidor do imóvel descrito e caracterizado no
            Quadro II (“Imóvel”), pelo presente Contrato, vende e transfere ao DEVEDOR, que compra e adquire referido
            Imóvel, pelo preço certo e ajustado constante do Quadro III, na forma mencionada no Quadro VI, por meio dos
            recursos mencionados no Quadro IV.
            <br>
            <br>

            <b>Declarações do VENDEDOR</b>
            <br>
            1.1. O VENDEDOR declara que: i) o Imóvel encontra-se livre e desembaraçado de quaisquer ônus, gravames
            ou restrições, pessoais ou reais, de qualquer origem, inclusive fiscal, judicial ou negocial extrajudicial, exceto
            os gravames descritos no Quadro V, os quais são liberados conforme previsto na cláusula 2 deste Contrato; ii)
            não existem, contra si ou contra qualquer dos antigos proprietários do Imóvel, ações reais ou pessoais
            reipersecutórias, conforme certidões expedidas pelo Registro de Imóveis competente; iii) sobre o Imóvel não
            pesam débitos fiscais, condominiais ou de contribuições devidas a associação que congregue os moradores do
            conjunto imobiliário a que pertence o Imóvel.
            <br>
            <br>

            1.1.1. O VENDEDOR declara, ainda, que o seu estado civil é aquele que se encontra descrito no Quadro I.
            Caso viva em união estável, seu(sua) companheiro(a), qualificado(a) também no Quadro I, assina este Contrato,
            expressando sua integral anuência com a presente compra e venda, sem que tal concordância tenha qualquer
            reflexo de caráter registrário, pois não infringidos os princípios da especialidade subjetiva e da continuidade.
            <br>
            <br>

            <b>Quitação do preço do Imóvel</b>
            <br>
            1.2. Considerando que receberá o pagamento do preço da presente compra e venda diretamente da PREVI, à
            exceção dos valores já pagos a título de sinal pelo DEVEDOR, conforme descrito no Quadro IV, nos termos
            deste Contrato, o VENDEDOR, neste ato, dá ao DEVEDOR a mais plena, geral, rasa e irrevogável quitação do
            preço do Imóvel, para dele nada mais reclamar com respeito a tal preço, podendo, tão somente, reclamar da
            PREVI a liberação dos recursos do Financiamento e do Fundo de Garantia do Tempo de Serviço - FGTS, na
            forma do Quadro VI, que ocorrerá conforme os termos e condições deste Contrato.
            <br>
            <br>

            <b>Transferência da posse sobre o Imóvel</b>
            <br>
            1.3. Em decorrência da compra e venda e da transferência do domínio sobre o Imóvel, efetuadas na forma do
            caput desta cláusula, o VENDEDOR cede e transfere, neste ato, ao DEVEDOR, que os adquire, toda a posse
            que exerce sobre o Imóvel, bem como todos os direitos, pretensões e ações, inclusive possessórias, de sua
            titularidade, relativas ao Imóvel, para que o DEVEDOR dele use, goze e livremente disponha, como
            proprietário exclusivo que passa a ser.
            <br>
            <br>

            <b>Responsabilidade pela evicção</b>
            <br>
            1.4. O VENDEDOR obriga-se por si, seus herdeiros e sucessores, a qualquer título, a fazer esta venda sempre
            boa, firme e valiosa e a responder pela evicção de direito na forma da lei.
            <br>
            <br>

            <b>Responsabilidade por tributos e contribuições</b>
            <br>
            1.5. Por força da aquisição do Imóvel, correrão por conta exclusiva do DEVEDOR todos os tributos e
            contribuições que, a partir desta data, venham a incidir sobre a propriedade, posse ou utilização do Imóvel.
            <br>
            <br>
            1.5.1. Caso o Imóvel integre condomínio de utilização ou qualquer conjunto imobiliário administrado por
            associação de moradores, todas as contribuições relativas ao condomínio de utilização ou contribuições devidas
            à referida associação de moradores, a partir desta data, passam a ser de responsabilidade do DEVEDOR.
            <br>
            <br>
            <b>Imposto sobre Transmissão de Bens Imóveis – ITBI</b>
            <br>
            1.6. É anexada à primeira via deste Contrato a guia de recolhimento do Imposto sobre Transmissão de Bens
            Imóveis – ITBI, devidamente paga pelo DEVEDOR, referente à transmissão do Imóvel por força da presente
            compra e venda.
            <br>
            <br>
            <b>CLÁUSULA 2 – DO GRAVAME SOBRE O IMÓVEL</b>
            <br>
            Caso, nesta data, exista gravame hipotecário ou de alienação fiduciária sobre o Imóvel, conforme mencionado
            no Quadro V, constituído em favor do CREDOR QUITANTE para garantir o cumprimento de obrigação do
            VENDEDOR, este, neste ato, autoriza expressamente a PREVI a entregar ao CREDOR QUITANTE, do
            montante do financiamento ora concedido, o valor mencionado no item 2 do Quadro VI, quitando as obrigações
            do VENDEDOR perante o CREDOR QUITANTE, e remindo, dessa forma, o gravame existente sobre o
            Imóvel. O montante entregue ao CREDOR QUITANTE será deduzido do valor a ser entregue ao VENDEDOR
            por força do financiamento ora concedido, conforme disposto na cláusula 3.2.
            <br>
            <br>
            <b>Quitação das obrigações e liberação do gravame</b>
            <br>
            2.1. O CREDOR QUITANTE, concordando com a compra e venda do Imóvel ora contratada e recebendo da
            PREVI, neste ato, por meio de pagamento em cheque, conforme descrito no Quadro VI, os recursos
            correspondentes ao pagamento de seu crédito, dá ao VENDEDOR a mais plena, rasa e irrevogável quitação
            com relação a tal dívida e autoriza expressamente o Sr. Oficial do Cartório de Registro de Imóveis competente
            a proceder o cancelamento do referido gravame existente sobre o Imóvel, desde que o faça concomitantemente
            com registro da propriedade fiduciária constituída em favor da PREVI nos termos da cláusula 13.
            <br>
            <br>
            <b>Custos e despesas com o cancelamento</b>
            <br>
            2.2. O DEVEDOR arcará com todos os custos e despesas referentes ao cancelamento do gravame existente
            sobre o Imóvel mencionado nesta cláusula, pagando-os diretamente ao Oficial do Cartório de Registro de
            Imóveis competente.
            <br>
            <br>
            <b>Condição suspensiva</b>
            <br>
            2.3. Além das condições estipuladas na cláusula 3.1, a liberação dos recursos referentes ao Financiamento,
            conforme descrito nos itens 1 e 3 do Quadro VI, encontra-se suspensivamente condicionada à comprovação à
            PREVI, por meio da entrega da ficha de matrícula atualizada do Imóvel, do efetivo cancelamento do gravame
            existente sobre o Imóvel em favor do CREDOR QUITANTE.
            <br>
            <br>
            <b>CLÁUSULA 3 – FINANCIAMENTO</b>
            <br>
            Para possibilitar o pagamento do preço do Imóvel, a PREVI, neste ato, concede ao DEVEDOR um
            financiamento, no valor total estipulado no Quadro VII (“Financiamento”), utilizando-se, para tanto, de
            recursos próprios, oriundos dos recursos garantidores do Plano de Benefícios ao qual o DEVEDOR encontra-se
            vinculado na data da assinatura deste contrato, administrado pela PREVI.
            <br>
            <br>
            <b>Condição suspensiva</b>
            <br>
            3.1. Sem prejuízo das demais condições estipuladas neste Contrato, a entrega dos recursos do Financiamento ao
            VENDEDOR e ao DEVEDOR, no caso de ressarcimento de sinal, fica suspensivamente condicionada à
            comprovação à PREVI do efetivo e perfeito registro, junto à matrícula do Imóvel, da garantia de alienação
            fiduciária constituída nos termos da cláusula 13, que será realizado pelo Oficial de Registro de Imóveis
            competente. A comprovação do registro referido nesta cláusula dar-se-á pela entrega da ficha de matrícula
            atualizada do Imóvel.
            <br>
            <br>
            <b>Verificação da condição suspensiva</b>
            <br>
            3.2. Verificada a condição suspensiva estipulada na cláusula 3.1, a PREVI liberará os recursos referentes ao
            Financiamento, entregando-os diretamente ao VENDEDOR, a título de pagamento do preço do Imóvel,
            observado sempre o disposto na cláusula 2.1.
            <br>
            <br>
            3.2.1. Caso parte do preço do Imóvel seja pago pela utilização de recursos do Fundo de Garantia do Tempo de
            Serviço – FGTS do DEVEDOR, a PREVI liberará tais recursos diretamente ao VENDEDOR ou ao CREDOR
            QUITANTE, após satisfeita a condição suspensiva estipulada na cláusula 2.3, acima, ou após tê-los recebidos
            da Caixa Econômica Federal – CEF, o que ocorrer depois.
            <br>
            <br>
            <b>Prorrogação de Prazo</b>
            <br>
            3.3. Se ao final do prazo ajustado no Quadro VII, item 2, houver saldo devedor remanescente, o prazo de
            amortização do financiamento será prorrogado para até 420 meses, deste que não ultrapasse a data em que o
            devedor completar 85 (oitenta e cinco) anos de idade.
            <br>
            <br>
            <b>CLÁUSULA 4 – ATUALIZAÇÃO DO SALDO DEVEDOR</b>
            <br>
            O montante total do Saldo Devedor (conforme definido na cláusula 4.1.) será atualizado, desde a presente data,
            e com periodicidade mensal, pela aplicação da variação mensal do índice atuarial utilizado para a remuneração
            básica dos recursos garantidores do Plano de Benefícios da PREVI ao qual o DEVEDOR encontra-se vinculado
            na data de assinatura deste contrato, com defasagem de 2 (dois) meses da data de atualização do saldo devedor.
            <br>
            <br>
            <b>Saldo Devedor</b>
            <br>
            4.1. Para os fins deste Contrato, “Saldo Devedor” significa o valor de principal do Financiamento ainda não
            amortizado, atualizado na forma prevista na cláusula 4.
            <br>
            <br>
            <b>Forma da atualização do Saldo Devedor</b>
            <br>
            4.2. O índice de atualização monetária, definido no item 3 do Quadro VII, incidirá sobre o Saldo Devedor antes
            da aplicação, sobre este, dos juros e encargos incorridos naquele mês, e antes da imputação dos pagamentos
            efetuados pelo DEVEDOR naquele mês.
            <br>
            <br>
            4.2.1. Para todos os efeitos deste Contrato, as quantias devidas por força da atualização do Saldo Devedor serão
            acrescidas ao valor do principal do Financiamento.
            <br>
            <br>
            <b>Substituição do índice</b>
            <br>
            4.3. Caso o índice mencionado no item 3 do Quadro VII venha a ser substituído por outro índice de cunho
            nacional, e que se enquadre como referencial para a reavaliação atuarial do Plano de Benefícios da PREVI ao
            qual o DEVEDOR encontra-se vinculado na data da assinatura deste contrato, este novo índice será utilizado
            para efeito de atualização monetária, na forma e periodicidade estabelecida neste instrumento, a partir de sua
            adoção.
            <br>
            <br>
            4.3.1. No caso de substituição do índice mencionado no item 3 do Quadro VII, a PREVI divulgará, por meio de
            seus canais de comunicação institucionais, o novo índice a ser utilizado.
            <br>
            <br>
            <b>CLÁUSULA 5 – JUROS</b>
            <br>
            Sobre o Saldo Devedor (conforme definido na cláusula 4.1.), acrescido da atualização monetária nos termos da
            cláusula 4, incidirão, desde a presente data, e com periodicidade mensal, juros à taxa efetiva mensal estipulada
            no item 5 do Quadro VII deste Contrato correspondentes aos juros atuariais e previstos no Regulamento do
            Plano de Benefícios , da PREVI ao qual o DEVEDOR encontra-se vinculado na data da assinatura deste
            contrato, os quais deverão ser pagos mensalmente, conforme previsto na cláusula 7.
            <br>
            <br>
            <b>Alteração da taxa efetiva de juros</b>
            <br>
            5.1. Caso a taxa de juros atuarial do Plano de Benefícios da PREVI, ao qual o DEVEDOR encontra-se
            vinculado na data de contratação, venha a ser alterada, esta nova taxa de juros será aplicada sobre o Saldo
            Devedor, nos termos da cláusula 4, a partir de sua adoção.
            <br>
            <br>
            5.2. A taxa de juros a que se refere a cláusula 5 será acrescida de 2% (dois pontos percentuais ao ano) se o
            DEVEDOR se desligar do Plano de Benefícios, administrado pela PREVI, e deixar de receber proventos da
            Patrocinadora do respectivo Plano de Benefícios, adequando-se o valor da prestação à nova condição
            contratual.
            <br>
            <br>
            <b>CLÁUSULA 6 - FUNDOS</b>
            <br>
            Será também cobrado mensalmente, a título de contribuição, para o Fundo de Liquidez e para o Fundo de
            Quitação por Morte, percentual sobre o Saldo Devedor, diferenciado de acordo com a idade e o Plano de
            Benefícios, ao qual o DEVEDOR encontre-se vinculado na data da assinatura deste contrato.
            <br>
            <br>
            <b>Fundo de Liquidez</b>
            <br>
            6.1. O Fundo de Liquidez (FL) será formado por contribuições mensais calculadas sobre o valor do saldo
            devedor atualizado, pela aplicação do percentual definido no item 6.1 do Quadro VII, e serão destinadas a
            quitar eventual resíduo do Saldo Devedor existente após o pagamento da última prestação da prorrogação de
            prazo que alude a Cláusula Terceira item 3.3, desde que o referido resíduo não tenha sido causado por
            inadimplemento do DEVEDOR.
            <br>
            <br>
            <b>Fundo de Quitação por Morte</b>
            <br>
            6.2. O Fundo de Quitação por Morte (FQM) será formado por contribuições mensais calculadas sobre o valor
            do Saldo Devedor atualizado e em percentual definido em função da idade e o Plano de Benefícios ao qual o
            DEVEDOR encontre-se vinculado na data da assinatura deste contrato, pela aplicação dos percentuais definidos
            no item 6.2 do Quadro VII e se destinará a quitar todas as obrigações vincendas em caso de morte do
            DEVEDOR.
            <br>
            <br>
            6.2.1. - O percentual relativo ao FQM será alterado automaticamente, durante a vigência do contrato, em função
            da mudança de idade do DEVEDOR, conforme definido no item 6.2 do Quadro VII.
            6.2.2 Havendo mais de um DEVEDOR, o FQM quitará apenas as parcelas vincendas relativas ao DEVEDOR
            falecido, na proporção indicada no Quadro XI.
            <br>
            <br>
            <b>Alteração dos percentuais devidos aos Fundos</b>
            <br>
            6.3. A PREVI poderá rever, periodicamente, em virtude da ocorrência de alteração do risco a ser coberto, as
            taxas do Fundo de Liquidez (FL) e do Fundo de Quitação por Morte (FQM), visando manter seu equilíbrio.
            Será dada ampla divulgação, por meio dos canais de comunicação institucionais da PREVI, a mudança do
            percentual aplicado, visto que esta poderá resultar em alteração do valor da prestação mensal.
            <br>
            <br>
            <b>CLÁUSULA 7 – PAGAMENTO</b>
            <br>
            O DEVEDOR obriga-se a: i) reembolsar a PREVI os prêmios de seguro por ela pagos, na forma da cláusula 11;
            ii) pagar mensalmente as despesas de administração referidas na cláusula 12; e iii) pagar a prestação que
            vencerá em cada mês, calculada na forma da cláusula 7.1.2.
            <br>
            <br>
            <b>Prestação mensal</b>
            <br>
            7.1. A prestação, composta pela soma dos valores relativos à amortização do capital, juros e contribuições aos
            Fundos de Liquidez e de Quitação por Morte, deverá ser paga em parcelas mensais, consecutivas e
            postecipadas, sendo a primeira vencível no dia 20 do mês seguinte ao da celebração do contrato e as demais no
            dia 20 dos meses subseqüentes.
            <br>
            <br>
            7.1.1. No pagamento da primeira prestação serão cobrados, pro-rata dia, os encargos constantes nas cláusulas 5
            e 6, devidos no período compreendido entre a data do contrato e a data do vencimento da primeira prestação.
            <br>
            <br>
            7.1.2. O valor das prestações será recalculado mensalmente, de acordo com a fórmula abaixo:
            <br>
            <br>
            <img src="{{ public_path('image/formula.png') }}" width="592px" height="86px"/>
            <br>
            a - Prestação mensal;
            <br>
            b - Saldo devedor;
            <br>
            c - Prazo remanescente em meses;
            <br>
            d - taxa do índice atuarial, com defasagem de 2 (dois) meses;
            <br>
            e - taxa mensal equivalente aos juros atuariais estabelecidos para o Plano de Benefícios;
            <br>
            f - taxa mensal equivalente do Fundo de Liquidez (FL);
            <br>
            g - taxa mensal equivalente do Fundo de Quitação Por Morte (FQM);
            <br>
            h - percentual de aplicação da taxa do índice atuarial, de no mínimo 1%, calculado pela divisão de 1 pelo prazo
            do financiamento em meses. Esse percentual se elevará mensalmente por igual valor (em pontos percentuais)
            até atingir 100%.
            <br>
            <br>
            <b>Vencimento pelo decurso do prazo</b>
            <br>
            7.2. O vencimento das obrigações do DEVEDOR decorrentes deste Contrato dar-se-á nas datas estipuladas
            nesta cláusula, independentemente de qualquer comunicação, notificação ou interpelação, aplicando-se o
            previsto no art. 397 do Código Civil.
            <br>
            <br>
            7.2.1. O vencimento da primeira prestação, bem como da taxa de administração e do prêmio de seguro, dar-seão na data mencionada na cláusula 7.1, ainda que, até essa data, não tenham sido liberados, total ou
            parcialmente, ao VENDEDOR ou ao CREDOR QUITANTE os recursos referentes ao Financiamento, uma vez
            que: i) por força da quitação dada pelo VENDEDOR relativa ao preço da compra e venda, a PREVI já está,
            desde esta data, obrigada a liberar ao VENDEDOR os recursos do Financiamento, tendo reservado em sua
            tesouraria tais recursos; e ii) a posse direta, bem como o uso e gozo do Imóvel já foram transferidos ao
            DEVEDOR, fruindo este plenamente, desde já, os efeitos econômicos deste Financiamento.
            <br>
            <br>
            <b>Forma de pagamento</b>
            <br>
            7.3. O DEVEDOR obriga-se a pagar todas as obrigações decorrentes deste Contrato por meio de consignação
            em folha de pagamento de salários ou benefícios pagos pelo Banco do Brasil S.A., PREVI e/ou INSS, ficando a
            PREVI, desde já, em caráter irrevogável e irretratável, autorizada a consignar na folha de pagamento do
            DEVEDOR, conforme mencionado no item 8 do Quadro VII, quaisquer obrigações decorrentes deste Contrato.
            <br>
            <br>
            7.3.1. Caso o DEVEDOR, no curso deste Contrato, receba salário insuficiente e/ou deixe de receber salário ou
            benefício do Banco do Brasil S.A., PREVI e/ou INSS, a forma de pagamento das obrigações do DEVEDOR
            prevista no item 8 do Quadro VII, será alterada, de forma que tais pagamentos passem a ser efetuados por meio
            de débito na conta corrente indicada pelo DEVEDOR no item 4.2 do Quadro VI. Dessa forma, o DEVEDOR,
            desde logo, autoriza, em caráter irrevogável e irretratável, para todos os efeitos legais e contratuais, que o
            Banco do Brasil S.A., sob pedido da PREVI, efetue o débito em sua conta corrente de todo e qualquer valor
            decorrente das obrigações assumidas.
            <br>
            <br>
            7.3.2. Para efeito do disposto na cláusula 7.3.1 o DEVEDOR obriga-se a manter conta-corrente no Banco do
            Brasil S.A., cabendo a ele informar à PREVI a agência e o número da conta corrente quando houver qualquer
            alteração do número da mesma.
            <br>
            <br>
            7.3.3. A PREVI, a seu critério, poderá alterar a forma de pagamento para liquidação por meio de boleto de
            cobrança bancária. Neste caso, a PREVI passará a enviar os respectivos boletos ao DEVEDOR, os quais
            deverão ser liquidados na forma neles estabelecida. A falta de recebimento de qualquer dos boletos não eximirá
            o DEVEDOR de realizar os pagamentos na data em que forem devidos, devendo ser realizados na forma
            indicada pela PREVI.
            <br>
            <br>
            7.3.4. O DEVEDOR que, por qualquer motivo, deixar de receber os benefícios do INSS por meio da folha de
            pagamentos da PREVI, neste ato expressamente autoriza a PREVI a consignar o desconto das prestações
            mensais, no todo ou em parte, diretamente na folha daquele Instituto.
            <br>
            <br>
            <b>Imputação do pagamento</b>
            <br>
            7.4. Os pagamentos realizados pelo DEVEDOR imputar-se-ão nas obrigações devidas na seguinte ordem: i) a
            taxa de administração nos termos da cláusula 12; ii) o reembolso dos prêmios de seguro pagos pela PREVI, nos
            termos da cláusula 11; iii) a contribuição devida aos Fundos; iv) a liquidação dos juros remuneratórios; v) a
            liquidação dos juros e encargos moratórios, eventualmente devidos; e vi) a amortização do principal.
            <br>
            <br>
            <b>Limitação do valor das prestações</b>
            <br>
            7.5. O valor da prestação mensal, conforme definido na cláusula 7.1 ficará limitado a, no máximo, 30% (trinta
            por cento) dos proventos brutos mensais contidos na folha de pagamentos do mês anterior à data do
            vencimento. A presente limitação não se estende às obrigações acessórias, como a taxa de administração e as
            despesas de seguros.
            <br>
            <br>
            7.5.1. Para o DEVEDOR aposentado ou pensionista considera-se como proventos brutos a soma dos benefícios
            recebidos da PREVI e do INSS. Caso o DEVEDOR não receba os benefícios do INSS via folha de pagamentos
            da PREVI e na ausência de comprovação do benefício recebido por aquele Instituto, será utilizado para compor
            o total de proventos brutos, para os fins desta cláusula, o valor do teto vigente de benefícios definido pelo
            INSS.
            <br>
            <br>
            7.5.2. Para o DEVEDOR aposentado ou pensionista que receba apenas o benefício do INSS pela PREVI, será
            considerado como proventos brutos, para fins da limitação de que trata esta cláusula, a renda bruta que serviu
            de base para a concessão do financiamento, devidamente atualizada pelo índice previsto na cláusula 4.
            <br>
            <br>
            7.5.3. Ao DEVEDOR que recebe da PREVI a antecipação da complementação de aposentadoria, sem o
            benefício do INSS, será considerado como proventos brutos, para fins da limitação de que trata esta cláusula, a
            renda bruta que serviu de base para a concessão do financiamento, devidamente atualizada pelo índice previsto
            na cláusula 4.
            <br>
            <br>
            7.5.4. Se o DEVEDOR, por qualquer motivo, deixar de receber proventos do Banco do Brasil S.A., da PREVI
            ou do INSS será considerada como renda bruta, para fins da limitação prevista na cláusula 7.5 a renda bruta que
            serviu de base para a concessão do financiamento, devidamente atualizada pelo índice previsto na cláusula 4.
            <br>
            <br>
            7.5.5. Caso o DEVEDOR que tiver rompido o vínculo empregatício com o Banco do Brasil S.A. e cancelado
            sua inscrição junto à PREVI vier a reingressar nos quadros do Banco do Brasil S.A., independentemente de
            nova adesão à PREVI, será considerada, para os efeitos de limitação previstos na cláusula 7.5 a renda bruta que
            serviu de base para a concessão do financiamento, devidamente atualizada pelo índice previsto na cláusula 4.
            <br>
            <br>
            7.5.6. Eventual resíduo existente ao final do contrato, considerando o disposto na Cláusula Terceira item 3.3,
            decorrente da limitação tratada nesta cláusula, será liquidado com recursos do Fundo de Liquidez, previsto na
            cláusula 6.1.
            <br>
            <br>
            7.5.7. A limitação dos 30% (trinta por cento) não se estende aos valores cobrados relativos a obrigações de
            competências anteriores à vigente, em decorrência de reprocessamento ou acerto.
            <br>
            <br>
            <b>CLÁUSULA 8 – PAGAMENTOS ANTECIPADOS</b>
            <br>
            O DEVEDOR que não se encontrar em mora com qualquer de suas obrigações decorrentes deste Contrato
            poderá realizar amortizações extraordinárias do Saldo Devedor.
            <br>
            <b><i>Juros pro rata die 8.1.</i></b> Caso a data da realização da amortização extraordinária não coincida com a data de vencimento de
            qualquer das prestações, prevista na cláusula 7, ao Saldo Devedor a ser amortizado serão acrescidos, para todos
            os efeitos desta cláusula, a atualização, na forma da cláusula 4, o Fundo de Liquidez, Fundo de Quitação por
            Morte e os juros incorridos desde a data de vencimento da parcela de principal imediatamente anterior à
            amortização extraordinária até a data em que essa se realizar, calculados pelo critério pro rata die.
            <br>
            <br>
            <b>Imputação das amortizações extraordinárias</b>
            <br>
            8.2. Os valores efetivamente pagos pelo DEVEDOR a título de amortização extraordinária serão deduzidos do
            Saldo Devedor total, acrescido dos montantes referidos na cláusula 8.1, mantendo-se o prazo original do
            Financiamento e reduzindo-se, dessa forma, proporcionalmente, o valor da prestação mensal.
            <br>
            <br>
            8.3. Os recálculos mencionados nesta cláusula serão realizados de forma independente do recálculo previsto na
            cláusula 7.1.2.
            <br>
            <br>
            8.4. Caso o DEVEDOR venha a desligar-se do Plano de Benefícios, será utilizado para quitar ou amortizar o
            presente financiamento imobiliário o valor total disponibilizado para pagamento ou transferência das reservas
            acumuladas no Plano. O DEVEDOR, neste ato expressamente autoriza a utilização destes valores para
            compensação com a dívida oriunda do financiamento imobiliário.
            <br>
            <br>
            8.5. Caso, em função de evento de perda de renda, a PREVI tenha se abstido de consignar o valor integral da
            prestação devida para respeitar a limitação máxima de 30% (trinta por cento) prevista na cláusula 7.5. e o
            DEVEDOR venha a manifestar intenção de quitar antecipadamente sua dívida, o Fundo de Liquidez, nesta
            hipótese, não poderá ser invocado por este para cobrir saldo das diferenças geradas pelo evento.
            <br>
            <br>
            <b>CLÁUSULA 9 – JUROS E ENCARGOS MORATÓRIOS</b>
            <br>
            Caso o DEVEDOR não pague, na data de seu vencimento, qualquer obrigação pecuniária, de qualquer natureza,
            principal ou acessória, serão devidos à PREVI: i) atualização monetária dos valores não pagos pelo índice
            previsto no item 3 do Quadro VII; ii) juros contratuais previstos no item 4 do Quadro VII; iii) multa não
            indenizatória de 2% (dois por cento) e juros moratórios de 1% a.m. (um por cento ao mês) sobre os valores em
            atraso atualizados acrescidos dos juros definidos no item 4 do Quadro VII; e iv) despesas de cobrança e
            honorários advocatícios.
            <br>
            <br>
            9.1. No caso da excussão da garantia de alienação fiduciária ora constituída, o DEVEDOR arcará com todos os
            custos e despesas dela decorrentes e demais cominações legais e convencionais.
            <br>
            <br>
            <b>CLÁUSULA 10 – VENCIMENTO ANTECIPADO</b>
            <br>
            A PREVI poderá considerar antecipadamente vencidas e imediatamente exigíveis todas as obrigações do
            DEVEDOR decorrentes deste Contrato, caso ocorra qualquer das seguintes hipóteses:
            <br>
            <br>
            I – se o DEVEDOR ceder ou transferir a terceiros os seus direitos e obrigações decorrentes deste Contrato, ou
            vender ou prometer vender, por qualquer outra forma, o Imóvel, ou sobre ele constituir quaisquer ônus ou
            gravames, sem prévio e expresso consentimento da PREVI;
            <br>
            II – se o DEVEDOR incorrer em mora, total ou parcial, com relação ao pagamento de qualquer obrigação
            decorrente deste Contrato e o referido inadimplemento não for saldado dentro de 90 (noventa) dias;
            <br>
            III – se contra o DEVEDOR for movida qualquer ação ou execução real ou reipersecutória cujo objeto seja o
            Imóvel, ou caso este seja objeto de qualquer medida constritiva, judicial ou administrativa, tais como penhora,
            sequestro ou arresto;
            <br>
            IV – se o DEVEDOR tiver sua insolvência civil decretada ou, se for empresário, requerer recuperação judicial
            ou extrajudicial, ou falência, ou tiver sua falência requerida por terceiros;
            <br>
            V – se qualquer das declarações feitas pelo DEVEDOR ou pelo VENDEDOR neste Contrato revelar-se
            errônea, enganosa, falsa ou inverídica;
            <br>
            VI – se houver o descumprimento pelo DEVEDOR de qualquer obrigação por ele assumida neste Contrato,
            inclusive daquelas relativas à garantia de alienação fiduciária ora constituída;
            <br>
            VII – se o DEVEDOR deixar de apresentar à PREVI, anualmente, ou quando solicitado para tanto, os recibos
            comprobatórios do pagamento dos impostos e taxas, despesas condominiais, bem como quaisquer outros
            tributos incidentes sobre o Imóvel;
            <br>
            VIII – se o Imóvel for desapropriado, no todo ou em parte;
            <br>
            IX – se o DEVEDOR não mantiver o Imóvel em perfeito estado de conservação, segurança e habitabilidade, ou
            nele realizar, sem o prévio e expresso consentimento da PREVI, obras de demolição, alteração ou acréscimo;
            <br>
            X – se ocorrer qualquer das hipóteses previstas no artigo 333 do Código Civil;
            <br>
            XI – se houver utilização indevida da indenização do seguro conforme especificado na cláusula 11.7;
            <br>
            XII – se, por qualquer forma, se constatar que o DEVEDOR se furtou à finalidade a que o financiamento
            objetivou, dando ao imóvel outra destinação que não seja a sua ocupação residencial.
            <br>
            <br>
            10.1. Na hipótese de imóvel financiado para mais de um DEVEDOR, conforme previsto na cláusula 19, o
            vencimento antecipado se dará em relação a todos os DEVEDORES.
            <br>
            <br>
            <b>Pagamento no caso de vencimento antecipado</b>
            <br>
            10.2. Ocorrendo o vencimento antecipado de suas obrigações, nos termos aqui previstos, e caso a PREVI não
            tenha iniciado, ainda, o procedimento de excussão da garantia, fazendo intimar o DEVEDOR nos termos da
            cláusula 15, o DEVEDOR deverá pagar à PREVI a totalidade do Saldo Devedor, acrescido dos juros,
            contribuições para os Fundos, taxa de administração e prêmio de seguro até então incorridos, 24 (vinte e quatro)
            horas após ser extrajudicialmente notificado para tanto, por simples carta enviada com Aviso de Recebimento
            ou por qualquer outro meio hábil, sob pena de incorrer em mora com relação a tais quantias, passando a incidir
            sobre elas os juros e encargos moratórios previstos na cláusula 9, e sob pena de consolidação da propriedade do
            Imóvel em nome da PREVI, nos termos da cláusula 15.
            <br>
            <br>
            <b>CLÁUSULA 11 – SEGURO</b>
            <br>
            Durante a vigência deste contrato e até a amortização definitiva da dívida, o DEVEDOR autoriza a PREVI a
            contratar, junto à companhia seguradora de primeira linha, seguro contra danos físicos ao imóvel, somente
            PRÉDIO, conforme condições das coberturas do seguro, anexas ao contrato, figurando a PREVI como única e
            exclusiva beneficiária do seguro, podendo exigir e receber as respectivas indenizações.
            <br>
            <br>
            11.1. A PREVI não se responsabiliza por danos causados ao imóvel em decorrência de riscos não cobertos pelo
            seguro contratado.
            <br>
            <br>
            11.2. A cobertura do seguro se dará a partir da assinatura deste instrumento, regendo-se pelas cláusulas e
            condições constantes da Apólice estipulada pela PREVI.
            <br>
            <br>
            11.3. O seguro contra morte do DEVEDOR fica, para este financiamento, substituído por contribuições ao
            Fundo de Quitação por Morte, previsto na cláusula 6.2 deste Contrato.
            <br>
            <br>
            11.4. Não será exigida do DEVEDOR a contratação de seguro para cobertura de invalidez permanente enquanto
            este mantiver contratado com a PREVI plano de aposentadoria que assegure a complementação do salário na
            situação de aposentadoria por invalidez permanente. Entretanto, o DEVEDOR autoriza a PREVI a contratar em
            seu nome seguro para cobertura de Morte e Invalidez Permanente com cláusula beneficiária à PREVI, na
            hipótese de desvinculação do DEVEDOR do plano de aposentadoria contratado com a PREVI, obrigando-se a
            reembolsar a PREVI dos montantes pagos, devendo tal reembolso deverá ser feito juntamente com a prestação
            mensal no mês subsequente ao pagamento do prêmio do seguro e suas renovações durante o período do
            financiamento. Esse valor considerar-se-á automaticamente alterado quando, por qualquer motivo, for
            modificado pela companhia seguradora.
            <br>
            <br>
            <b>Pagamento dos prêmios do seguro</b>
            <br>
            11.5. O DEVEDOR, neste ato, autoriza a PREVI a pagar, em seu nome, diretamente à companhia seguradora, o
            prêmio do seguro contratado, nos termos desta cláusula, obrigando-se a reembolsá-la dos montantes pagos,
            sendo certo que tal reembolso deverá ser feito juntamente com a prestação mensal no mês subsequente ao
            pagamento do prêmio do seguro e suas renovações, durante o período do financiamento, sendo certo que esse
            valor considerar-se-á automaticamente alterado quando, por qualquer motivo, for modificado pela companhia
            seguradora.
            <br>
            <br>
            11.6. No primeiro ano de vigência do contrato, o seguro será cobrado, pro-rata dia, desde a data da contratação
            do financiamento até a data do vencimento da apólice em vigor.
            <br>
            <br>
            <b>Utilização do seguro</b>
            <br>
            11.7. Em caso de sinistro, as partes obrigam-se a utilizar os montantes recebidos da companhia seguradora,
            conforme definido nas condições gerais da apólice, para repor o Imóvel ao estado em que este se encontrava
            anteriormente à ocorrência de tais danos ou, caso tal reposição não seja possível, a indenização deverá ser
            utilizada para amortizar ou liquidar todas as obrigações oriundas deste Contrato, restituindo-se ao DEVEDOR o
            montante que, eventualmente, sobejar.
            <br>
            <br>
            11.7.1. Caso venha a seguradora, na indenização de seguro de natureza material, optar pelo pagamento em
            espécie, a PREVI não assumirá qualquer obrigação de financiar possível diferença entre o custo orçado na nova
            obra e o valor da indenização recebida.
            <br>
            <br>
            <b>Obrigações do DEVEDOR referentes ao seguro</b>
            <br>
            11.8. São obrigações do DEVEDOR em relação aos seguros contratados nos termos desta cláusula:
            <br>
            a. formalizar comunicação à companhia seguradora e à PREVI, imediatamente, a ocorrência de sinistro coberto
            pela respectiva apólice, relatando todos os fatos a ele relacionados de modo a permitir sua completa elucidação;
            <br>
            b. tomar todas as providências necessárias para a limitação das conseqüências do sinistro;
            <br>
            c. caso o sinistro seja imputável a terceiros, o DEVEDOR deverá fornecer os documentos necessários para que
            a companhia seguradora exerça os seus direitos contra tais terceiros, inclusive com outorga de mandato com os
            necessários poderes para tal fim;
            <br>
            d. dar conhecimento aos seus descendentes, ascendentes, cônjuge ou companheiro(a), da existência dos seguros
            aqui referidos e da obrigatoriedade de comunicação imediata à companhia seguradora e à PREVI caso ocorra
            qualquer sinistro coberto por tais seguros.
            <br>
            <br>
            11.9. O DEVEDOR declara que recebeu, juntamente com o presente instrumento, cópia da Apólice de seguro
            estipulada pela PREVI, tomando ciência das condições pactuadas.
            <br>
            <br>
            <b>CLÁUSULA 12 – TAXA DE ADMINISTRAÇÃO</b>
            <br>
            O DEVEDOR pagará à PREVI, juntamente com a prestação mensal, a Taxa de Administração mencionada no
            item 2 do Quadro VIII, a título de ressarcimento dos custos pela administração, gestão da cobrança do
            Financiamento e de todos os processos a eles vinculados, nos termos da regulamentação vigente, cujo valor
            poderá ser revisto periodicamente pela PREVI.
            <br>
            <br>
            <b>CLÁUSULA 13 – ALIENAÇÃO FIDUCIÁRIA</b>
            <br>
            Para garantir o cumprimento de todas e quaisquer obrigações principais e acessórias, inclusive as referentes à
            restituição de principal e ao pagamento de juros, encargos, comissões, tarifas, reembolso dos prêmios de seguro
            pagos na forma da cláusula 11.5, multas e encargos moratórios, por si assumidas neste Contrato (“Obrigações
            Garantidas”), o DEVEDOR, neste ato, nos termos e para os efeitos dos arts. 22 e seguintes da Lei nº 9.514/97,
            transfere à PREVI, em caráter fiduciário, a propriedade resolúvel e a posse indireta sobre o Imóvel, que foi
            adquirido pelo DEVEDOR por compra e venda, nos termos deste Contrato. O DEVEDOR, enquanto
            adimplente, manterá consigo a posse direta sobre o Imóvel, podendo utilizá-lo livremente, por sua conta e risco.
            <br>
            <br>
            <b>Compreensão e extinção da propriedade resolúvel da PREVI</b>
            <br>
            13.1. Por força da alienação fiduciária ora contratada, a PREVI passa a deter a propriedade resolúvel e a posse
            indireta sobre o Imóvel e todas as acessões, melhoramentos, construções e instalações nele existentes e que a
            ele forem acrescidas. A propriedade fiduciária detida pela PREVI sobre o Imóvel será eficaz até o final e total
            pagamento de todas as Obrigações Garantidas, e resolver-se-á de pleno direito com o cancelamento do registro
            da propriedade fiduciária, o qual será feito pelo Oficial de Registro de Imóveis competente, mediante a exibição
            de termo de quitação, entregue pela PREVI ao DEVEDOR, nos termos da cláusula 14.
            <br>
            <br>
            <b>Impostos e contribuições</b>
            <br>
            13.2. O DEVEDOR obriga-se a pagar pontualmente todos os impostos, taxas e quaisquer outras contribuições
            ou encargos que incidam ou venham a incidir sobre a posse ou sobre a propriedade resolúvel do Imóvel, tais
            como Imposto Predial e Territorial Urbano – IPTU, contribuições devidas ao condomínio de utilização do
            edifício ou a associação que congregue os moradores do conjunto imobiliário respectivo, exibindo os
            respectivos comprovantes à PREVI, anualmente, ou quando solicitado.
            <br>
            <br>
            13.2.1. Caso o DEVEDOR não pague em dia todos os impostos e demais tributos que incidam ou venham a
            incidir sobre o Imóvel, poderá a PREVI fazê-lo, ficando o DEVEDOR obrigado a reembolsá-la das quantias
            despendidas no prazo de 24 (vinte e quatro) horas após recebimento de notificação encaminhada por esta, sob
            pena de, sobre tais quantias, incidirem os juros e encargos moratórios estipulados na cláusula 9. O reembolso
            devido à PREVI pelo DEVEDOR, nos termos desta cláusula, fica garantido pela presente alienação fiduciária.
            <br>
            <br>
            <b>Conservação do Imóvel</b>
            <br>
            13.3. O DEVEDOR compromete-se a manter e conservar o Imóvel em perfeito estado de segurança e
            habitabilidade, bem como a realizar às suas custas, dentro do prazo que lhe for determinado para tanto, as obras
            e os reparos julgados necessários, ficando vedada a realização de qualquer obra de modificação ou acréscimo
            no Imóvel sem o prévio consentimento da PREVI. O cumprimento dessa obrigação poderá ser fiscalizado pela
            PREVI, obrigando-se o DEVEDOR a permitir o ingresso de pessoa credenciada para executar as vistorias
            periódicas.
            <br>
            <br>
            <b>Desapropriação do Imóvel</b>
            <br>
            13.4. O DEVEDOR, desde já, de forma irrevogável e irretratável, autoriza a PREVI a receber, em seu nome,
            todas as quantias referentes a indenizações pagas pelo poder expropriante por força de desapropriação, integral
            ou parcial, do Imóvel, por qualquer forma ou motivo, aplicando tais valores na amortização ou liquidação das
            Obrigações Garantidas, colocando o remanescente, se houver, à disposição do DEVEDOR, na forma prevista
            na cláusula 16.5.
            <br>
            <br>
            13.4.1. O DEVEDOR, pelo presente Contrato e na melhor forma de direito, nomeia e constitui a PREVI sua
            procuradora, na forma do artigo 684 do Código Civil, com amplos e irrevogáveis poderes para, em juízo ou fora
            dele, representá-lo junto aos órgãos públicos federais, municipais ou estaduais, bancos, autarquias e demais
            entidades públicas e privadas, bem como perante Agentes Financeiros ou companhias de seguros em todos os
            assuntos referentes à desapropriação e aos seguros, para receber importâncias em casos de sinistros ou
            desapropriação amigável ou judicial, total ou parcial, decorrentes de pagamento de seu crédito, podendo, ainda,
            assinar, reconhecer, aceitar, dar quitação, receber, endossar, requerer, impugnar, concordar, recorrer, desistir,
            transigir, firmar compromissos e substabelecer. A presente outorga de poderes será eficaz até o pagamento final
            e total das Obrigações Garantidas.
            <br>
            <br>
            <b>Retenção e indenização por benfeitorias</b>
            <br>
            13.5. Nos termos do disposto nos parágrafos 4º e 5º do artigo 27 da Lei 9.514/97, jamais haverá direito de
            retenção por benfeitorias realizadas pelo DEVEDOR no Imóvel, mesmo que tenham caráter de necessárias ou
            úteis, ou que tenham sido autorizadas pela PREVI.
            <br>
            <br>
            13.5.1. Nos termos do §4º ao art. 27 da lei 9.514/97, na hipótese de a propriedade do imóvel dado em garantia
            consolidar-se em nome da PREVI, a indenização por benfeitorias resumir-se-á, sempre, ao saldo que sobejar do
            preço pago pelo Imóvel, depois de liquidadas as Obrigações Garantidas e as demais despesas e acréscimos
            legais, sendo certo que, não ocorrendo a venda do imóvel nos leilões extrajudiciais, e extinguindo-se as
            obrigações do DEVEDOR decorrentes deste Contrato, nos termos da cláusula 16.6, não haverá nenhum direito
            de indenização pelas benfeitorias.
            <br>
            <br>
            <b>CLÁUSULA 14 – QUITAÇÃO DAS OBRIGAÇÕES DO DEVEDOR</b>
            <br>
            Mediante solicitação formal do DEVEDOR, a PREVI enviará no prazo de 30 (trinta) dias, a contar da data da
            solicitação o respectivo termo de quitação, correspondente às obrigações assumidas pelo DEVEDOR neste
            Contrato.
            <br>
            <br>
            <b>Cancelamento da propriedade fiduciária</b>
            <br>
            14.1. Enviado o termo de quitação aqui mencionado, fica o DEVEDOR autorizado a requerer, ao Oficial de
            Registro de Imóveis competente, o cancelamento do registro da propriedade fiduciária, com a respectiva
            restituição ao DEVEDOR da propriedade sobre o Imóvel.
            <br>
            <br>
            14.1.1. O envio do termo de quitação pela PREVI, nos termos aqui previstos, simbolizará a transferência ao
            DEVEDOR da posse indireta exercida pela PREVI sobre o Imóvel, consolidando-se, dessa forma, na pessoa do
            DEVEDOR, a posse plena sobre esse.
            <br>
            <br>
            <b>Pagamento com recursos oriundos do FGTS</b>
            <br>
            14.2. Caso o DEVEDOR utilize seus recursos do Fundo de Garantia do Tempo de Serviço – FGTS para
            liquidar as Obrigações Garantidas, tais obrigações apenas considerar-se-ão quitadas após o efetivo recebimento,
            pela PREVI, dos referidos recursos, os quais lhe serão entregues pela Caixa Econômica Federal – CEF.
            <br>
            <br>
            <b>CLÁUSULA 15 – MORA E CONSOLIDAÇÃO DA PROPRIEDADE FIDUCIÁRIA</b>
            <br>
            Verificada a mora do DEVEDOR com relação a qualquer obrigação por ele assumida, nos termos deste
            Contrato, e decorrido o prazo de carência de 90 (noventa) dias, contados da data em que se verificou a mora,
            sem que haja a sua purgação, a PREVI poderá fazer intimar o DEVEDOR, nos termos do art. 26, §1º e §3º, da
            Lei nº 9.514/1997, ou, ainda, de acordo com o art. 26, §3°-A, da Lei nº 9.514/1997, incluído pela Lei nº
            13.465/2017, que estabelece previsão, segundo a qual, quando, por duas vezes, o oficial de registro de imóveis
            ou de registro de títulos e documentos ou o serventuário por eles credenciado houver procurado o intimando em
            seu domicílio ou residência sem o encontrar, deverá, havendo suspeita motivada de ocultação, intimar qualquer
            pessoa da família ou, em sua falta, qualquer vizinho de que, no dia útil imediato, retornará ao imóvel, a fim de
            efetuar a intimação, na hora que designar, aplicando-se subsidiariamente o disposto nos arts. 252, 253 e 254 da
            Lei no 13.105, de 16 de março de 2015 (Código de Processo Civil), fixando o prazo de até 15 (quinze) dias para
            que purgue a mora, pagando ao Oficial de Registro de Imóveis competente o montante equivalente ao valor de
            todas as suas obrigações decorrentes deste Contrato que se encontrem vencidas e não pagas, inclusive aquelas
            que vencerem no curso da intimação, acrescido dos juros e encargos moratórios conforme pactuados neste
            Contrato e de todos os custos e despesas de intimação, bem como tributos e contribuições condominiais e
            associativas que porventura se encontrarem vencidos na data da purgação da mora.
            <br>
            <br>
            <b>Pagamento parcial</b>
            <br>
            15.1. O pagamento do valor de principal das obrigações em mora sem que haja o respectivo pagamento de juros
            e encargos, inclusive moratórios, dos custos e despesas havidos com sua intimação, não exonerará o
            DEVEDOR da responsabilidade de liquidar a totalidade de suas obrigações em mora, sendo certo que o saldo
            devedor restante de tais obrigações deverá ser pago juntamente com o pagamento da parcela de principal cujo
            vencimento seja imediatamente subsequente a tal purgação parcial, sob pena de a PREVI poder requerer ao
            Oficial de Registro de Imóveis que certifique a não purgação da mora no prazo assinado e, assim, consolide a
            propriedade do Imóvel em nome da PREVI.
            <br>
            <br>
            <b>Forma de realização da intimação</b>
            <br>
            15.2. A realização da intimação do DEVEDOR, referida nesta cláusula, caberá ao Oficial de Registro de
            Imóveis que, a seu critério, poderá fazê-lo: i) pessoalmente; ii) por preposto seu; iii) através do Serviço de
            Registro de Títulos e Documentos da Comarca da situação do Imóvel ou do domicílio do DEVEDOR; ou,
            ainda, iv) pelo Correio, desde que enviada com Aviso de Recebimento – AR, a ser firmado pessoalmente pelo
            DEVEDOR ou por seu representante.
            <br>
            <br>
            15.2.1. O Oficial de Registro de Imóveis providenciará a realização da intimação do DEVEDOR após
            requerimento da PREVI, a qual indicará ao Oficial o valor das obrigações do DEVEDOR vencidas e não pagas,
            acrescidas dos juros e encargos moratórios, incidentes nos termos da cláusula 9.
            <br>
            <br>
            <b>Recebimento da intimação e intimação por edital</b>
            <br>
            15.3. A intimação deverá ser recebida pessoalmente pelo DEVEDOR ou por seu representante regularmente
            constituído, sendo certo que, caso o DEVEDOR encontre-se em local incerto e não sabido, assim certificado
            pelo Oficial de Registro de Imóveis ou pelo Oficial de Títulos e Documentos, conforme o caso, competirá ao
            primeiro promover a intimação do DEVEDOR por edital.
            <br>
            <br>
            15.3.1. O edital de intimação será publicado por 3 (três) dias, ao menos, consecutivos ou não, em um dos
            jornais de maior circulação editados no local do Imóvel ou, se no local do Imóvel não houver imprensa com
            circulação diária, editado em outra comarca de fácil acesso, sendo certo que o prazo de 15 (quinze) dias para a
            purgação da mora será contado a partir da última publicação do edital.
            <br>
            <br>
            <b>Purgação da mora ao Oficial de Registro de Imóveis</b>
            <br>
            15.4. O DEVEDOR poderá efetuar a purgação da mora aqui referida: i) entregando, em dinheiro, ao Oficial do
            Registro de Imóveis competente o valor necessário para a purgação da mora; ou ii) entregando, ao Oficial do
            Registro de Imóveis competente, cheque administrativo, emitido por banco comercial, intransferível por
            endosso e nominativo à PREVI ou a quem expressamente indicado na intimação, no valor necessário para a
            purgação da mora. Nessa hipótese, a entrega do cheque ao Oficial do Registro de Imóveis será feita sempre em
            caráter pro solvendo, de forma que a purgação da mora ficará condicionada ao efetivo pagamento do cheque
            pela instituição financeira sacada. Recusado o pagamento do cheque, a mora será tida por não purgada,
            podendo a PREVI requerer que o Oficial do Registro de Imóveis certifique, nos termos do art. 26, §7º da Lei nº
            9.514/97, que a mora não restou purgada e promova a consolidação, em nome da PREVI, da propriedade
            fiduciária.
            <br>
            <br>
            15.4.1. O Oficial do Registro de Imóveis receberá o pagamento efetuado pelo DEVEDOR por conta da PREVI
            e entregará a esta as importâncias recebidas.
            <br>
            <br>
            <b>Consolidação da propriedade em nome da PREVI</b>
            <br>
            15.5. Caso não haja a purgação da mora no prazo determinado na intimação referida nesta cláusula, a PREVI
            poderá, conforme previsto no § 7o do artigo 26 da Lei nº 9.514/1997, com a apresentação do devido
            recolhimento do imposto sobre transmissão inter vivos e, se for o caso, do laudêmio, requerer ao Oficial de
            Registro de Imóveis, de acordo com o art. 26-A, § 1o, da Lei nº 9.514/1997, incluído pela Lei nº 13.465/2017,
            a consolidação da propriedade em seu nome, que será averbada no registro de imóveis trinta dias após a
            expiração do prazo para purgação da mora de que trata o § 1o do art. 26 da Lei nº 9.514/1997.
            <br>
            <br>
            <b>Desocupação do Imóvel</b>
            <br>
            15.6. O DEVEDOR deverá desocupar o Imóvel no dia seguinte ao da consolidação da propriedade plena em
            nome da PREVI, deixando-o livre e desimpedido de pessoas e coisas, sob pena de pagamento à PREVI, ou
            àquele que tiver adquirido o imóvel em leilão, de taxa de ocupação do imóvel, por mês ou fração,
            correspondente a 1% (um por cento) do valor de avaliação do Imóvel estipulado no Quadro III, sem prejuízo de
            sua responsabilidade pelo pagamento: a) do foro e das despesas de água, luz e gás referentes ao Imóvel; b) de
            todas as despesas e contribuições devidas ao condomínio de utilização ou à associação que congregue os
            moradores do conjunto imobiliário integrado pelo Imóvel; c) de todas as despesas necessárias à reposição do
            <br>
            <br>
            <b>Imóvel ao estado em que o recebeu.</b>
            <br>
            15.6.1. Não ocorrendo a desocupação do Imóvel pelo DEVEDOR, no prazo e forma ajustados nesta cláusula
            15.6, independentemente da penalidade estipulada no caput desta cláusula, a PREVI ou o adquirente do Imóvel
            poderão propor ação de reintegração de posse contra o DEVEDOR, sem prejuízo da cobrança e execução do
            valor da taxa de ocupação e demais despesas previstas no caput desta cláusula e neste Contrato. O DEVEDOR
            declara-se ciente de que, nos termos do art. 30 da Lei nº 9.514/97, tal reintegração será concedida liminarmente,
            com ordem judicial para desocupação no prazo máximo de 60 (sessenta) dias.
            <br>
            <br>
            15.6.2. A taxa de ocupação referida no caput desta cláusula incidirá a partir da data da alienação em leilão até a
            data em que a PREVI, ou seus sucessores, vier a ser imitida na posse do imóvel.
            <br>
            <br>
            <b>CLÁUSULA 16 – DO LEILÃO EXTRAJUDICIAL</b>
            <br>
            Uma vez consolidada a propriedade do Imóvel em nome da PREVI, esta deverá promover a realização de
            leilões públicos, extrajudiciais, conforme previsto no art. 27 da Lei nº 9.514, a fim de alienar o Imóvel a
            terceiros interessados, e utilizar o preço recebido para liquidar as Obrigações Garantidas. Os leilões serão
            conduzidos por leiloeiro oficial, legalmente habilitado para tanto e eleito pela PREVI, ao qual será devida
            comissão à taxa que se praticar para esse tipo de leilão no local em que este for realizado.
            <br>
            <br>
            <b>Primeiro público leilão</b>
            <br>
            16.1. O primeiro público leilão será realizado no prazo máximo de 30 (trinta) dias, contados da data do registro
            da consolidação da plena propriedade em nome da PREVI. O preço mínimo de venda do Imóvel, nesse
            primeiro público leilão, equivalerá ao valor de avaliação do Imóvel, estipulado pelas Partes, no Quadro III, o
            qual será atualizado pela mesma taxa de atualização do Saldo Devedor constante da cláusula 4, e que poderá, a
            critério exclusivo da PREVI, ser revisto por meio de nova avaliação, realizada por companhia idônea a ser
            indicada pela PREVI, incluindo-se os custos de avaliação no Saldo Devedor. Nos termos do art. 24, § único, da
            Lei nº 9.514/1997, incluído pela Lei nº 13.465/2017, caso o valor do imóvel convencionado pelas partes seja
            inferior ao utilizado pelo órgão competente como base de cálculo para a apuração do imposto sobre
            transmissão inter vivos, exigível por força da consolidação da propriedade em nome do credor fiduciário, este
            último será o valor mínimo para efeito de venda do imóvel no primeiro leilão.
            <br>
            <br>
            16.1.1. Considera-se incluído no valor do preço mínimo de venda do Imóvel o valor de todas e quaisquer
            benfeitorias, necessárias, úteis e voluptuárias, executadas pelo DEVEDOR no Imóvel.
            <br>
            <br>
            <b>Segundo público leilão</b>
            <br>
            16.2. Nos termos do art. 27, § 1º, da Lei nº 9.514/1997, alterado pela Lei nº 13.465/2017, se no primeiro leilão
            público o maior lance oferecido for inferior ao valor do imóvel, será realizado o segundo leilão nos quinze dias
            seguintes.
            <br>
            <br>
            16.2.1. O preço mínimo de venda do Imóvel, no segundo público leilão, equivalerá ao somatório do valor das
            Obrigações Garantidas, dos juros e encargos moratórios incorridos até a data da realização do segundo público
            leilão, e do valor das seguintes obrigações do DEVEDOR, que se encontrem vencidas e não pagas até a data da
            realização do segundo leilão: i) prêmios de seguro; ii) contribuições devidas ao condomínio de utilização, ou
            contribuições devidas a associação de moradores ou entidade assemelhada; iii) despesas de água, luz e gás; iv)
            Imposto Predial e Territorial Urbano – IPTU, foro e outros tributos ou contribuições eventualmente incidentes
            sobre a propriedade ou a posse do Imóvel; v) Imposto sobre Transmissão de Bens Imóveis - ITBI e laudêmio, e
            demais custos e despesas, inclusive despesas de cobrança, eventualmente devidos por força da consolidação da
            propriedade plena do Imóvel em nome da PREVI; vi) encargos e custas de intimação do DEVEDOR; vii)
            encargos e custas com a publicação do edital de anúncio de ambos os leilões; viii) a comissão devida ao
            leiloeiro; ix) custos de avaliação do Imóvel; e x) quantias devidas pelo DEVEDOR nos termos das cláusulas
            15.6 e 15.6.1.
            <br>
            <br>
            <b>Local de realização dos leilões</b>
            <br>
            16.3. Nos termos do artigo 27, § 2º-A, da Lei nº 9.514/1997, incluído pela Lei nº 13.465/2017, as datas,
            horários e locais dos leilões serão comunicados ao devedor mediante correspondência dirigida aos endereços
            constantes do contrato, inclusive ao endereço eletrônico.
            <br>
            <br>
            <b>Critério para venda do Imóvel</b>
            <br>
            16.4. A venda do Imóvel em qualquer dos públicos leilões far-se-á sempre pelo critério de maior lance,
            respeitado, todavia, o preço mínimo de venda estabelecido conforme as cláusulas 16.1 e 16.2.1.
            <br>
            <br>
            16.4.1. Nos termos do artigo 27, § 2º-B, da Lei nº 9.514/1997, incluído pela Lei nº 13.465/2017, após a
            averbação da consolidação da propriedade fiduciária no patrimônio do credor fiduciário e até a data da
            realização do segundo leilão, é assegurado ao devedor fiduciante o direito de preferência para adquirir o imóvel
            por preço correspondente ao valor da dívida, somado aos encargos e despesas referenciados pelo § 2º do artigo
            27 da Lei nº 9.514/1997, aos valores correspondentes ao imposto sobre transmissão inter vivos e ao laudêmio,
            se for o caso, pagos para efeito de consolidação da propriedade fiduciária no patrimônio do credor fiduciário, e
            às despesas inerentes ao procedimento de cobrança e leilão, incumbindo, também, ao devedor fiduciante o
            pagamento dos encargos tributários e despesas exigíveis para a nova aquisição do imóvel, inclusive custas e
            emolumentos.
            <br>
            <br>
            <b>Restituição de quantias ao DEVEDOR e indenização por benfeitorias</b>
            <br>
            16.5. Após liquidadas as obrigações do DEVEDOR, mencionadas na cláusula 16.4, a PREVI restituir-lhe-á
            eventual saldo que sobejar do preço recebido pela venda do Imóvel no prazo de até 5 (cinco) dias úteis após o
            efetivo pagamento pelo licitante vencedor, por meio de crédito na conta-corrente mantida pelo DEVEDOR
            junto ao Bando do Brasil S.A. ou por meio de cheque administrativo, nominativo e intransferível, emitido em
            nome do DEVEDOR. Nos termos do §4º ao art. 27 da Lei nº 9.514/97, considerar-se-á incluída no valor
            restituído ao DEVEDOR a indenização pelas benfeitorias, úteis, necessárias ou voluptuárias por ele realizadas
            no Imóvel, não podendo o DEVEDOR reclamar o pagamento de qualquer outra quantia, a qualquer título.
            <br>
            <br>
            16.5.1. Caso não haja saldo a ser restituído, não será devida ao DEVEDOR, nos termos daquela disposição
            legal, qualquer indenização pelas benfeitorias, úteis, necessárias ou voluptuárias por ele realizadas no Imóvel.
            <br>
            <br>
            <b>Extinção da dívida e indenização por benfeitorias</b>
            <br>
            16.6. Caso no segundo público leilão não haja licitantes ou não seja oferecido lance que equivalha, pelo menos,
            ao valor mínimo estipulado na cláusula 16.2.1, considerar-se-ão extintas as obrigações do DEVEDOR
            decorrentes deste Contrato, exonerando-se a PREVI da obrigação de vender o Imóvel por meio de público
            leilão.
            <br>
            <br>
            16.6.1. Ocorrendo a extinção da dívida, no prazo de 5 (cinco) dias a contar da realização do segundo leilão, a
            PREVI entregará ao DEVEDOR o competente termo de quitação de suas obrigações decorrentes deste
            Contrato, aplicando-se, nessa hipótese, o disposto na cláusula 14.
            <br>
            <br>
            16.6.2. Na hipótese prevista na cláusula 16.6, a PREVI não será obrigada a restituir ao DEVEDOR qualquer
            quantia, a qualquer título, nem obrigada a indenizá-lo pelas benfeitorias, úteis, necessárias ou voluptuárias por
            ele realizadas no Imóvel.
            <br>
            <br>
            <b>Pagamento do saldo devedor restante</b>
            <br>
            16.7. Por força do disposto no §5º do artigo 27 da Lei 9.514/97, se no segundo leilão, o maior lance oferecido
            não for igual ou superior ao valor da dívida, das despesas, dos prêmios de seguro, dos encargos legais, inclusive
            tributos, e das contribuições condominiais, dá-se a extinção da divida garantida pela alienação fiduciária.
            <br>
            <br>
            <b>Prestação de contas</b>
            <br>
            16.8. Caso haja a venda do Imóvel em qualquer dos dois públicos leilões previstos na cláusula 16, a PREVI
            manterá, em sua sede, à disposição do DEVEDOR, a correspondente prestação de contas pelo período de 12
            (doze) meses, contados da realização do primeiro leilão.
            <br>
            <br>
            <b>CLÁUSULA 17 - CERTIDÕES</b>
            <br>
            Conforme a natureza da personalidade jurídica do VENDEDOR, neste ato são entregues as seguintes certidões,
            ou prestadas as seguintes declarações: a) se o VENDEDOR for pessoa física, declara não ser produtor rural,
            empregador, nem estar pessoalmente vinculado ao INSS, não estando sujeito à apresentação da CND-INSS, por
            não ser contribuinte desse órgão; b) se o VENDEDOR for pessoa jurídica, apresenta, neste ato, cópia
            autenticada da Certidão Negativa de Débito – CND-INSS e da Certidão Conjunta expedida pela Receita Federal
            do Brasil e pela Procuradoria-Geral da Fazenda Nacional, exceto se, conforme assinalado no preâmbulo, estiver
            dispensado de tal apresentação por ser sociedade que explora, exclusivamente, atividade de compra e venda de
            imóveis, locação, desmembramento ou loteamento de terrenos, incorporação imobiliária ou construção de
            imóveis, destinados à venda e que o Imóvel integra contabilmente seu ativo circulante, jamais tendo constado
            do seu ativo permanente, o que declara sob responsabilidade civil e criminal.
            <br>
            <br>
            <b>Certidões de ações reais e reipersecutórias</b>
            <br>
            17.1. Para lavratura deste Contrato foram apresentadas certidões de ações reais e pessoais reipersecutórias,
            relativas ao Imóvel e a de ônus reais, expedidas pelo Cartório de Registro de Imóveis competente, bem como os
            demais documentos cuja apresentação é exigida por Lei, os quais se encontram identificados no Decreto nº
            93.240/86, ficando os mesmos arquivados junto à PREVI, em face da obrigação de seus arquivamentos prevista
            na Lei nº 4.380/64, e em conformidade com o disposto no § 3º do artigo 1º da Lei nº 7.433/85.
            <br>
            <br>
            <b>CLÁUSULA 18 - DECLARAÇÕES DO DEVEDOR</b>
            <br>
            O DEVEDOR declara expressamente, sob pena de responsabilidade civil e penal, que: i) sendo pessoa física,
            não está vinculado à Previdência Social, como empregador, e que não é contribuinte da mesma, na qualidade de
            produtor rural, não estando, portanto, sujeito às obrigações previdenciárias abrangidas pelo INSS – Instituto
            Nacional do Seguro Social; ii) na hipótese de estar vinculado e/ou ser contribuinte da Previdência Social, será
            apresentada, por ocasião do registro deste contrato junto ao Cartório de Registro de Imóveis competente, a
            necessária Certidão Negativa de Débito expedida pelo INSS; iii) não tem nenhuma responsabilidade tutelar,
            curatelar ou testamentária; iv) vistoriou o Imóvel e o encontrou em perfeita ordem e condições de
            habitabilidade; v) O DEVEDOR declara não estar respondendo a inquérito administrativo, inquérito judicial
            trabalhista ou estar em aviso prévio, até a presente data.
            <br>
            <br>
            <b>Declarações concernentes à utilização do Fundo de Garantia do Tempo de Serviço – FGTS</b>
            <br>
            18.1. Caso parte do preço de compra do Imóvel seja pago mediante a utilização de recursos do Fundo de
            Garantia do Tempo de Serviço – FGTS do DEVEDOR, este declara, sob as penas da lei, que:
            <br>
            <br>
            a) utilizará o Imóvel exclusivamente para residência própria;
            <br>
            b) o Imóvel está localizado: i) no município onde exerce a sua ocupação principal, em município a esse
            limítrofe ou integrante da respectiva região metropolitana; ou, ainda, ii) no município onde resida há, pelo
            menos, um ano;
            <br>
            c) não é proprietário, possuidor ou promitente comprador de qualquer outro imóvel residencial concluído: i)
            sito em qualquer parte do território nacional, cuja aquisição ou construção tenha sido financiada no âmbito do
            Sistema Financeiro da Habitação, em qualquer parte do território nacional; ii) sito no município onde exerça
            sua ocupação principal, nos municípios a esse limítrofes ou na respectiva região metropolitana; ou iii) sito no
            atual município de sua residência;
            <br>
            d) não é usufrutuário do Imóvel;
            <br>
            e) não doou qualquer imóvel residencial a pessoa: i) que esteja sujeita ao seu pátrio poder, ou ii) sobre a qual
            exerça tutela ou curatela;
            <br>
            f) tem conhecimento de que lhe é vedado: i) utilizar o FGTS para aquisição de imóvel que não se destine à sua
            moradia própria; ii) utilizar o FGTS para aquisição de imóvel comercial ou rural; iii) utilizar o FGTS para
            aquisição de lotes ou terrenos; iv) utilizar o FGTS para aquisição de imóvel gravado com cláusula que dificulte
            ou comprometa a sua livre comercialização; v) utilizar o FGTS para aquisição de imóvel residencial
            Concluído que não apresente condições de habitabilidade (bom estado de conservação); vi) utilizar o FGTS
            para aquisição de imóvel que tenha sido adquirido pelo VENDEDOR com a utilização do seu FGTS, há menos
            de 3 (três) anos.
            <br>
            <br>
            18.1.1. Para os fins da alínea “c”, acima, o DEVEDOR não será considerado proprietário ou promissário
            comprador de imóvel residencial caso detenha fração ideal igual ou inferior a 40% (quarenta por cento) de
            referido imóvel.
            <br>
            <br>
            18.1.2. O DEVEDOR declara que tem conhecimento de que o Imóvel só poderá ser alienado a outro comprador
            que pretenda pagar o preço com a utilização de seu FGTS após 3 (três) anos contados do registro da presente
            venda e compra.
            <br>
            <br>
            18.1.3. O DEVEDOR, neste ato, obriga-se a respeitar e observar as vedações e restrições estabelecidas na letra
            “f” da cláusula 18.1.
            <br>
            <br>
            <b>CLÁUSULA 19 – DISPOSIÇÕES GERAIS</b>
            <br>
            Caso no Quadro I - “COMPRADOR(ES)”, constante do preâmbulo deste Contrato, figurem duas pessoas,
            ambas declaram-se solidariamente responsáveis por todas as obrigações decorrentes do Financiamento e
            descritas neste Contrato, entendendo-se as referências feitas neste Contrato ao “DEVEDOR” como abrangendo
            ambas as referidas pessoas, as quais, mútua e reciprocamente, constituem-se procuradoras uma(s) da(s) outra(s)
            para fins de receber citações, intimações e interpelações de qualquer procedimento, judicial ou extrajudicial,
            decorrente deste Contrato, inclusive as intimações mencionadas na cláusula 15, de modo que, realizada a
            citação ou intimação, na pessoa de qualquer uma delas, estará completo o quadro citatório.
            <br>
            <br>
            <b>Novação, alteração ou renúncia</b>
            <br>
            19.1. Qualquer pagamento de principal, juros ou demais encargos que sejam efetuados fora dos prazos
            estabelecidos neste Contrato e ainda assim recebidos pela PREVI, bem como o não exercício imediato de
            qualquer direito de que a PREVI seja titular em decorrência deste Contrato ou da lei, inclusive a efetivação da
            intimação mencionada na cláusula 15, serão considerados mera tolerância. Qualquer novação ou alteração deste
            Contrato apenas será válida mediante aditivo específico a este instrumento.
            <br>
            <br>
            <b>Despesas deste Contrato e de registro</b>
            <br>
            19.2. O DEVEDOR responde por todas as despesas decorrentes da presente compra e venda e do financiamento
            com alienação fiduciária em garantia, inclusive aquelas relativas a emolumentos e despachante para obtenção
            das certidões dos distribuidores forenses, da municipalidade e de propriedade, as necessárias à sua efetivação e
            as demais que se lhe seguirem, inclusive as relativas a emolumentos e custas de Serviço de Notas e de Serviço
            de Registro de Imóveis, de quitações fiscais e qualquer tributo devido sobre a operação, que venha a ser
            cobrado ou criado.
            <br>
            <br>
            19.2.1. Correrão por conta do DEVEDOR todas as despesas decorrentes do presente Contrato e de todos os
            registros e averbações a ele correspondentes, principalmente os referentes ao registro da presente compra e
            venda do Imóvel e da garantia de alienação fiduciária ora constituída, bem como aquelas decorrentes de
            qualquer ato ou negócio jurídico praticado com base neste Contrato.
            <br>
            <br>
            <b>Ato jurídico perfeito</b>
            <br>
            19.3. As Partes convencionam, como condição essencial deste Contrato, que, em face do princípio
            constitucional do respeito ao direito adquirido e ao ato jurídico perfeito, não se aplicará a este Contrato
            qualquer norma superveniente de congelamento ou deflação, total ou parcial, do Saldo Devedor ou do valor de
            cada prestação.
            <br>
            <br>
            19.3.1. Na hipótese de a PREVI aceitar temporariamente, por mera liberalidade e sem que tal fato caracterize
            novação, o congelamento ou deflação do valor de algumas prestações, fica ajustado como condição do presente
            negócio que: i) o Saldo Devedor continuará sendo atualizado, nos termos da cláusula 4; e ii) a diferença entre o
            valor real de cada parcela e o valor a menor pago pelo DEVEDOR será cobrada pela PREVI tão logo se
            encerre, de modo direto ou indireto, o congelamento ou deflação.
            <br>
            <br>
            19.3.2. Em face do avençado, toda e qualquer quitação conferida pela PREVI acha-se condicionada à apuração
            posterior de eventual saldo de responsabilidade do DEVEDOR, ainda que tal ressalva não conste
            expressamente do respectivo recibo ou boleto bancário.
            <br>
            <br>
            <b>Alteração de domicílio e Estado Civil</b>
            <br>
            19.4. O DEVEDOR obriga-se a comunicar à PREVI, imediatamente, qualquer alteração de seu estado civil,
            bem como qualquer alteração de seu domicílio ou endereço para correspondência.
            Declaração
            <br>
            <br>
            <b>CLÁUSULA 20 - REGULAMENTO DA CARTEIRA IMOBILIÁRIA DA PREVI</b>
            <br>
            Aplica-se subsidiariamente a este Contrato as regras do Regulamento vigente da Carteira Imobiliária da PREVI
            ao qual o DEVEDOR declara expresso conhecimento e concordância.
            <br>
            <br>
            <b>CLÁUSULA 21 - AUTORIZAÇÃO PARA REGISTRO</b>
            <br>
            As Partes declaram aceitar o presente Contrato em todas as suas cláusulas, termos e condições, autorizando o
            Sr. Oficial do Cartório de Registro de Imóveis competente a proceder quaisquer registros ou averbações que se
            fizerem necessários ao seu fiel cumprimento, inclusive o registro da propriedade resolúvel sobre o Imóvel em
            favor do PREVI.
            <br>
            <br>
            <b>CLÁUSULA 22 - ELEIÇÃO DE FORO</b>
            <br>
            Para dirimir quaisquer dúvidas que porventura surjam em virtude do presente instrumento, as partes elegem o
            Foro Central da Capital do Estado do Rio de Janeiro, facultado ao autor da ação optar pelo foro de situação do
            imóvel.
        </p>

    </div>
</div>
<div class="page-break"></div>


<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify">
            E, por estarem assim justos e contratados, assinam o presente em 03 (três) vias de igual teor e valor, na presença de
            02 (duas) testemunhas.
        </p>
        <p class="athos-font text-right">
            Curitiba {{ $contrato->dataContrato }}
        </p>
        @if($tipoUniao == "U" || $tipoUniao == "C")
            <table class="table table-borderless table-condensed table-assinatura text-left">
                <tbody>
                <tr>
                    <td colspan="2">COMPRADOR(A,ES):</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td valign="bottom"><u>__________________________________________________________</u></td>
                    <td valign="bottom"><u>__________________________________________________________</u></td>
                </tr>
                <tr>
                    <td valign="top" style="padding-top: 0;"><b>{{ $nomeProponente }}</b></td>
                    <td valign="top" style="padding-top: 0;"><b>{{ $nomeProponenteConjuge }}</b></td>
                </tr>
                </tbody>
            </table>
        @else
            <table class="table table-borderless table-condensed table-assinatura text-left">
                <tbody>
                <tr>
                    <td>COMPRADOR(A,ES):</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td valign="bottom"><u>__________________________________________________________</u></td>
                </tr>
                <tr>
                    <td valign="top" style="padding-top: 0;"><b>{{ $nomeProponente }}</b></td>
                </tr>
                </tbody>
            </table>
        @endif

    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify"></p>

        <table class="table table-borderless table-condensed table-assinatura text-left">
            <tbody>
            <tr>
                <td colspan="2">VENDEDOR(A,ES):</td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>

            @php
                echo '<tr>';
                $i=0;
                $arrayKeys = array_keys($assinaturaVendedores);
                $lastArrayKey = array_pop($arrayKeys);

                foreach ($assinaturaVendedores as $key => $vendedor){

                    if($i%2==0 && $i!=0) {
                       if($key == $lastArrayKey) {
                           echo '</tr>
                            <tr><td style="padding-top: 0;"><b>'.$assinaturaVendedores[$i-2].'</b></td><td style="padding-top: 0;"><b>'.$assinaturaVendedores[$i-1].'</b></td></tr>
                            <tr><td colspan="2"><u>__________________________________________________________</u></td>';
                       } else {
                           echo '</tr>
                            <tr><td style="padding-top: 0;"><b>'.$assinaturaVendedores[$i-2].'</b></td><td style="padding-top: 0;"><b>'.$assinaturaVendedores[$i-1].'</b></td></tr>
                            <tr><td valign="bottom"><u>__________________________________________________________</u></td>';
                       }
                    } else {
                        echo '<td valign="bottom"><u>__________________________________________________________</u></td>';
                    }
                  $i++;
                }
                echo '</tr>';

                if (count($assinaturaVendedores) > 1) {
                    if ((count($assinaturaVendedores)%2==0)) {
                        echo '<tr><td ><b>'.$assinaturaVendedores[$i-2].'</b></td><td style="padding-top: 0;"><b>'.$assinaturaVendedores[$i-1].'</b></td></tr>';
                    } else {
                        echo '<tr><td colspan="2" style="padding-top: 0;"><b>'.$assinaturaVendedores[$i-1].'</b></td></tr>';
                    }
                } else {
                    echo '<tr><td style="padding-top: 0;"><b>' .$assinaturaVendedores[$i-1]. '</b></td></tr>';
                }
            @endphp
        </table>
    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify"></p>

        <table class="table table-borderless table-condensed table-assinatura text-left">
            <tbody>
            <tr>
                <td>FINANCIADOR:</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td valign="bottom"><u>__________________________________________________________</u></td>
            </tr>
            <tr>
                <td valign="top" style="padding-top: 0;"><b>CAIXA DE PREVIDÊNCIA DOS FUNCIONÁRIOS DO BANCO DO BRASIL - {{ $nomeFinanciador }}</b></td>
            </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="row">
    <div class="col col-lg-12">
        <p class="athos-font text-justify"></p>

        <table class="table table-borderless table-condensed table-assinatura text-left">
            <tbody>
            <tr>
                <td colspan="2">TESTEMUNHAS:</td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td valign="bottom"><u>__________________________________________________________</u></td>
                <td valign="bottom"><u>__________________________________________________________</u></td>
            </tr>
            <tr>
                <td valign="top" style="padding-top: 0;"><b>Nome:</b></td>
                <td valign="top" style="padding-top: 0;"><b>Nome:</b></td>
            </tr>
            <tr>
                <td valign="top" style="padding-top: 0;"><b>Rg:</b></td>
                <td valign="top" style="padding-top: 0;"><b>Rg:</b></td>
            </tr>
            <tr>
                <td valign="top" style="padding-top: 0;"><b>Cpf:</b></td>
                <td valign="top" style="padding-top: 0;"><b>Cpf:</b></td>
            </tr>
            </tbody>
        </table>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
</body>

</html>
