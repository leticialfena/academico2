<?php
    function f_cpf($cpf){
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = substr($cpf, 0, 3) . '.' .
                substr($cpf, 3, 3) . '.' .
                substr($cpf, 6, 3) . '-' .
                substr($cpf, 9, 2);
        return $cpf;
    }

    function f_celular($cel){
        $cel = preg_replace("/[^0-9]/", "", $cel);
        $cel = '('.substr($cel, 0, 2) . ') ' .
                substr($cel, 2, 1) . ' ' .
                substr($cel, 3, 4) . '-' .
                substr($cel, 7, 4);
        return $cel;
    }
