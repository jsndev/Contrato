<?php

namespace App;

use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class Financiador extends Model {
    protected $table = "contrato_config";

    static function getNomeFinanciado() {
        return Utils::formatarNomes(self::where('PADRAO_CONTC', '=', "1")->first()->NOME_CONTC);
    }

    static function getDadosFinanciador() {
        return self::where('PADRAO_CONTC', '=', "1")->first()->DADOSPROC_CONTC;
    }
}
