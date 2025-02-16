<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorFactory {
    public static function criarConversor($grandeza) {
        return match ($grandeza) {
            'comprimento' => new ConversorComprimento(),
            'massa' => new ConversorMassa(),
            'temperatura' => new ConversorTemperatura(),
            'tempo' => new ConversorTempo(),
            'velocidade' => new ConversorVelocidade(),
            'volume' => new ConversorVolume(),
            default => throw new Exception("Grandeza $grandeza não suportada"),
        };
    }
}