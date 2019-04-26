
@extends('contrato.index')

<!-- Composição para proponentes casados -->
@section('proponentes.casados')

    <b>{{ $nomeProponente }} e s/m {{ $nomeProponenteConjuge }}</b>, {{ $nacionalidadeProponente }}, {{ $estadoCivilProponente }} {{ $comunhaoBens }}, el{{ $generoEAProponente }} {{ $profissaoProponente }}, {{ $afiliacaoProponente ? $afiliacaoProponente .',' : '' }} el{{ $generoEAProponenteConjuge }} {{ $profissaoProponenteConjuge }}, {{ $afiliacaoProponenteConjuge ? $afiliacaoProponenteConjuge . ',' : '' }} portadores das carteiras de indentidade RG n°(s) {{ $numeroRgProponente }}, emitido por {{ $emissaoRgProponente }} em {{ $dataEmissaoRgProponente }} e {{ $numeroRgProponenteConjuge }}, emitido por
    {{ $emissaoRgProponenteConjuge }} em {{ $dataEmissaoRgProponenteConjuge }}, respectivamente, inscritos no CPF/MF sob os n°(s). {{ $cpfProponente }} e
    {{ $cpfProponenteConjuge }}, residentes e domiciliados {{ $endereco }}, com o endereço eletrônico {{ $email }}, doravante denominado(a,s) simplesmente,
    DEVEDOR(A,ES){{ $procurador ? ", " . $procurador : '.' }}

@endsection

<!-- Composição para proponentes com uniao estavel -->
@section('proponentes.uniao.estavel')

    <b>{{ $nomeProponente }}</b>, {{ $nacionalidadeProponente }}, {{ $profissaoProponente }}, {{ $afiliacaoProponente ? $afiliacaoProponente .',' : '' }} {{ $estadoCivilProponente }}{{ $maiorIdade }}, portador da carteira de identidade RG nº {{ $numeroRgProponente }}, emitido por {{ $emissaoRgProponente }} em
    {{ $dataEmissaoRgProponente }}, inscrito no CPF/MF sob n° {{ $cpfProponente }} e <b>{{ $nomeProponenteConjuge }}</b>,
    {{ $nacionalidadeProponenteConjuge }}, {{ $profissaoProponenteConjuge }}, {{ $afiliacaoProponenteConjuge ? $afiliacaoProponenteConjuge . ',' : '' }} {{ $estadoCivilProponenteConjuge }},
    portadores da cateiras de identidade RG n° {{ $numeroRgProponenteConjuge }}, emitido por {{ $emissaoRgProponenteConjuge }} em {{ $dataEmissaoRgProponenteConjuge }}, inscrito no
    CPF/MF sob n° {{ $cpfProponenteConjuge }}, {{ $comunhaoBens }}, residentes e domiciliados {{ $endereco }}, com o endereço eletrônico {{ $email }}, doravante denominado(a,s)
    simplesmente, DEVEDOR(A,ES){{ $procurador ? ", " . $procurador : '.' }}

@endsection

<!-- Composição para proponentes solteiros -->
@section('proponentes.solteiro')

    <b>{{ $nomeProponente }}</b>, {{ $nacionalidadeProponente }}, {{ $profissaoProponente }}, {{ $afiliacaoProponente ? $afiliacaoProponente .',' : '' }} {{ $estadoCivilProponente }}{{ $maiorIdade }}, portador da carteira de identidade RG nº {{ $numeroRgProponente }}, emitido por {{ $emissaoRgProponente }} em
    {{ $dataEmissaoRgProponente }}, inscrito no CPF/MF sob n° {{ $cpfProponente }}, residente e domiciliada {{ $endereco }}, com o endereço eletrônico {{ $email }}, doravante denominado(a,s)
    simplesmente, DEVEDOR(A,ES){{ $procurador ? ", " . $procurador : '.' }}

@endsection
