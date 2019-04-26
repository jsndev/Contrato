<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model {
    protected $table = "municipio";

    /**
     * Recupera dados sobre o municipios dos participantes
     * @param $codCounty
     * @return mixed
     */
    static function getMunicipio($codigoMunicipio) {
        $municipio =  self::where('cod_municipio', '=', $codigoMunicipio)->first();
        return (!is_null($municipio) ? $municipio : (object) ['NOME_MUNICIPIO' => '' , 'COD_UF' => ''] );
    }
}
