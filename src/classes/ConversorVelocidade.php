<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorVelocidade implements Conversor {
    private $conversoesSuportadas = [
        'ms->kmh',
        'ms->mph',
        'kmh->ms',
        'kmh->mph',
        'mph->ms',
        'mph->kmh',
    ];

    public function converter($valor, $de, $para): float {
        return match ("$de-$para") {
            'ms-kmh' => $valor * 3.6,
            'ms-mph' => $valor * 2.237,
            'kmh-ms' => $valor / 3.6,
            'kmh-mph' => $valor / 1.609,
            'mph-ms' => $valor * 2.237,
            'mph-kmh' => $valor * 1.609,
            default => throw new Exception("Conversão de $de para $para não suportada.")
        };
    }

    public function getConversoesSuportadas() {
        return $this->conversoesSuportadas;
    }

    public function getConversaoPorIndice($indice) {
        if (!isset($this->conversoesSuportadas[$indice])) {
            throw new Exception("Erro de índice: Escolha inválida");
        }

        return $this->conversoesSuportadas[$indice];
    }
}