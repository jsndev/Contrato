<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logradouro extends Model {
    protected $table = "logradouro";

    /**
     * PORecupera os dados sobre o endereco dos participantes
     * @param $codLogr
     * @return mixed
     */
    static function getTipoLogradouro($codLogr) {
        $logradouro =  self::where('cod_logr', '=', $codLogr)->first();
        return (!is_null($logradouro) ? $logradouro : (object) ['DESC_LOGR' => '']);
    }
}
