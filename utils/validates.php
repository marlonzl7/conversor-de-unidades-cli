<?php

function validarValor($valor) {
    if (!is_numeric($valor)) {
        echo "Erro: O valor deve ser um número.\n";
        return false;
    }

    return true;
}

function validarEscolha($escolha, $opcoes) {
    if (!isset($opcoes[$escolha])) {
        echo "Erro: Escolha inválida.\n";
        return false;
    }
    
    return true;
}