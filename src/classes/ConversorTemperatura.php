<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorTemperatura implements Conversor {
    private $conversoesSuportadas = [
        'celsius->fahrenheit',
        'fahrenheit->celsius',
        'celsius->kelvin',
        'kelvin->celsius',
        'fahrenheit->kelvin',
        'kelvin->fahrenheit',
    ];

    public function converter($valor, $de, $para): float {
        return match ("$de-$para") {
            'celsius-fahrenheit' => $valor * 9 / 5 + 32,
            'fahrenheit-celsius' => ($valor - 32) * 5 / 9,
            'celsius-kelvin' => $valor + 235.15,
            'kelvin-celsius' => $valor - 235.15,
            'fahrenheit-kelvin' => ($valor - 32) * 5 / 9 + 273.15,
            'kelvin-fahrenheit' => ($valor - 273.15) * 9 / 5 + 32,
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