<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorComprimento implements Conversor {
    private $taxas = [
        'milimetro' => [
            'centimetro' => 0.1,
            'metro' => 0.001,
            'quilometro' => 0.000001,
        ],
        'centimetro' => [
            'milimetro' => 10,
            'metro' => 0.01,
            'quilometro' => 0.00001,
        ],
        'metro' => [
            'quilometro' => 0.001,
            'centimetro' => 100,
            'milimetro' => 1000,
        ],
        'quilometro' => [
            'milimetro' => 1000000,
            'centimetro' => 100000,
            'metro' => 1000,
        ],
    ];

    private $conversoesSuportadas = [
        'milimetro->centimetro',
        'milimetro->metro',
        'millimetro->quilometro',
        'centimetro->milimetro',
        'centimetro->metro',
        'centimetro->quilometro',
        'metro->milimetro',
        'metro->centimetro',
        'metro->quilometro',
        'quilometro->milimetro',
        'quilometro->centimetro',
        'quilometro->metro',
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