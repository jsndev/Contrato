
@if($keySocio == 0 )
    @php
        $contador = (count((array)$vendedor->socios) > 1 ) ? true : false;
    @endphp
{{ $contador ? " representado por seus sócios" : " representado por ".  ($socio->isMasc ? 'seu' : 'sua') . " ". ($socio->isMasc ? 'sócio' : 'sócia') }}
@endif

<b>Sr{{ $socio->isMasc ? '.' : 'a.' }} {{ $socio->nomeSocio }}</b>, {{ $socio->nacionalidadeSocio }}, {{ $socio->estadoCivilSocio}}, {{ $socio->profissaoSicio}}, portador{{ $socio->isMasc ? '' : 'a' }} da carteira de Identidade RG nº. {{ $socio->numeroRgSocio }}, emitido por {{ $socio->emissaoRgSocio }}, inscrito no CPF/MF sob nº. {{ $socio->cpfSocio}}, residente e domiciliad{{ $socio->isMasc ? 'o' : 'a' }} {{ $socio->enderecoSocio }};
