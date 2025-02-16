<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorTempo implements Conversor {
    private $conversoesSuportadas = [
        'segundos->minutos',
        'segundos->horas',
        'minutos->segundos',
        'minutos->horas',
        'horas->segundos',
        'horas->minutos',
    ];

    public function converter($valor, $de, $para): float {
        return match ("$de-$para") {
            'segundos-minutos' => $valor / 60,
            'segundos-horas' => $valor / 3600,
            'minutos-segundos' => $valor * 60,
            'minutos-horas' => $valor / 60,
            'horas-segundos' => $valor * 3600,
            'horas-minutos' => $valor * 60,
            default => throw new Exception("Conversão de $de para $para não suportada."),
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