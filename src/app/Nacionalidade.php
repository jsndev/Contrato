<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nacionalidade extends Model {
    protected $table = "pais";

    private function getDescricaoPais($codigoPais, $genero) {
        $pais =  $this->where('COD_PAIS', '=', $codigoPais)->first();

        if (!is_null($pais)) {
            switch ($genero) {
                case 0:
                    return $pais->NACIONALM;
                    break;
                case 1:
                    return $pais->NACIONALF;
                    break;
                case 2:
                    return $pais->NACIONALFM;
                    break;
            }
        }
    }

    public function get($codigoPais, $codPaisConjuge, $isCasado, $isUniaoEstavel, $isMasc) {

        if ($isCasado):
            if ($codigoPais != $codPaisConjuge):
                return $this->criarLacionalidade($this->getDescricaoPais($codigoPais, $isMasc ? 0 : 1), $this->getDescricaoPais($codPaisConjuge, $isMasc ? 1 : 0), true, $isMasc ? 0 : 1);
            else:
                return $this->criarLacionalidade($this->getDescricaoPais($codigoPais, ($isCasado ? 2 : ($isUniaoEstavel ? 0 : 1))), '', false, null);
            endif;
        else:
            return $this->criarLacionalidade($this->getDescricaoPais($codigoPais, $isMasc ? 0 : 1),'', false, $isMasc ? 0 : 1);
        endif;
    }

    private function criarLacionalidade($descPais, $descPaisConjuge, $naoNacional, $genero) {
        if ($naoNacional):
            return "el" . ($genero == 0 ? 'e' : 'a') . " " . $descPais . ", el" . ($genero == 0 ? 'a' : 'e') . " " . $descPaisConjuge;
        else:
            return $descPais;
        endif;
    }
    
}
