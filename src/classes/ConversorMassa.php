<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorMassa implements Conversor {
    private $taxas = [
        'grama' => [
            'quilograma' => 0.001,
        ],
        'quilograma' => [
            'grama' => 1000,
        ],
    ];

    private $conversoesSuportadas = [
        'grama->quilograma',
        'quilograma->grama,'
    ];

    public function converter($valor, $de, $para): float {
        if (!isset($this->taxas[$de][$para])) {
            throw new Exception("Conversão de $de para $para não suportada.");
        }

        return $valor * $this->taxas[$de][$para];
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