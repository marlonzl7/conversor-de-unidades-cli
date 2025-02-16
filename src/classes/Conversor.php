<?php

interface Conversor {
    public function converter(float $valor, string $de, string $para): float;
    public function getConversoesSuportadas();
    public function getConversaoPorIndice($indice);
}