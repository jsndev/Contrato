<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bairro extends Model  {
    protected $table = "bairro";

    static function getBairro($codigoBairro) {
        $bairro =  self::where('cod_bairro', '=', $codigoBairro)->first();
        return (!is_null($bairro) ? self::where('cod_bairro', '=', $codigoBairro)->first() : (object) ['NOME_BAIRRO' => '']);
    }
}
