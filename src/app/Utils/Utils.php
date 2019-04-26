<?php
/**
 * dw-analytics++
 * Created by Jefferson Fernandes on 17/04/19
 * Copyright © 2018 Jefferson Fernandes. All rights reserved.
 */


namespace App\Utils;


use DateTime;

class Utils {

    /**
     * Formata strins para formato de nomes
     * @param $name
     * @return string
     */
    static function formatarNomes( $name ) {
        $ignore = array( 'do', 'dos', 'da', 'das', 'de', 'e' );
        $array = explode(' ', mb_strtolower( $name ) );
        $out = '';
        foreach ($array as $ar) {
            $out .= ( in_array ( $ar, $ignore ) ? $ar : ucfirst( $ar ) ).' ';
        }
        return trim( $out );
    }

    static function formatarData($data) {
        return  date('d/m/Y', strtotime($data));
    }

    static function formatarCPF_CNPJ($cpf_cnpj) {
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
        $tipo_dado = NULL;
        if(strlen($cpf_cnpj)==11):
            $tipo_dado = "cpf";
        endif;
        if(strlen($cpf_cnpj)==14):
            $tipo_dado = "cnpj";
        endif;

        switch($tipo_dado){
            default:
                $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
                break;

            case "cpf":
                $bloco_1 = substr($cpf_cnpj,0,3);
                $bloco_2 = substr($cpf_cnpj,3,3);
                $bloco_3 = substr($cpf_cnpj,6,3);
                $dig_verificador = substr($cpf_cnpj,-2);
                $cpf_cnpj_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;
                break;

            case "cnpj":
                $bloco_1 = substr($cpf_cnpj,0,2);
                $bloco_2 = substr($cpf_cnpj,2,3);
                $bloco_3 = substr($cpf_cnpj,5,3);
                $bloco_4 = substr($cpf_cnpj,8,4);
                $digito_verificador = substr($cpf_cnpj,-2);
                $cpf_cnpj_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."/".$bloco_4."-".$digito_verificador;
                break;
        }
        return $cpf_cnpj_formatado;
    }

    static function replaceString($string, $obj) {
        $regrex = '/\#(.*?)\#/';
        preg_match_all($regrex, $string, $new);
        foreach ($new[1] as $key) {
            if (isset($obj->$key)){
                $value = self::check_format($key,$obj->$key);
                $string = str_replace("#$key#", $value ,$string);
            }
        }

        $regrex = '/\%(.*?)\%/';
        preg_match_all($regrex, $string, $new2);
        foreach ($new2[1] as $key) {
            $string = str_replace("%$key%", Utils::formatarNomes($key),$string);
        }

        unset($obj);
        return $string;
    }

    static function check_format($key,$value) {
        if (substr($key, 0,5) == "DATA_" || substr($key, 0,5) == "DTRG_" || substr($key, 0,10) == "HABENSDATA" || substr($key, 0,12) == "DTESTAT_VJUR"){
            return date('d/m/Y', strtotime($value));
        } elseif (substr($key, 0,4) == "CPF_") {
            return Utils::formatarCPF_CNPJ($value);
        } elseif (substr($key, 0,4) == "CNPJ") {
            return Utils::formatarCPF_CNPJ($value);
        } elseif (substr($key, 0,2) == "B_") {
            return strtoupper($value);
        } else {
            return $value;
        }
    }

    static function formatarMoeda($value) {
        return "R$" ." ". number_format($value, 2, ',', '.');
    }
}
