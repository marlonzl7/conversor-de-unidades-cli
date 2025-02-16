<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorCLI {
    private $conversor;

    public function exibirMenu() {
        echo "\033[1;34m=== Conversor de Unidades ===\033[0m\n";
        echo "[1] Comprimento\n";
        echo "[2] Massa\n";
        echo "[3] Temperatura\n";
        echo "[4] Tempo\n";
        echo "[5] Velocidade\n";
        echo "[6] Volume\n";
        echo "[7] Sair\n";
        echo "Escolha a unidade que quer converter (1-7): ";
    }

    public function exibirConversoesPorUnidade($unidade) {
        $unidades = [
            1 => "comprimento",
            2 => "massa",
            3 => "temperatura",
            4 => "tempo",
            5 => "velocidade",
            6 => "volume",
        ];

        if (isset($unidades[$unidade])) {
            $this->exibirConversoesSuportadas($unidades[$unidade]);
            $escolha = trim(fgets(STDIN));
            $this->realizarConversao($escolha);
        } else {
            echo "Unidade inválida.\n";
        }
        
    }

    public function exibirConversoesSuportadas($unidade) {
        $this->conversor = ConversorFactory::criarConversor($unidade);
        $conversoes = $this->conversor->getConversoesSuportadas();
        
        echo "Escolha uma conversão:\n";
        foreach ($conversoes as $i => $conversao) {
            echo "[$i] $conversao\n";
        };
        
        echo "Infome a conversão que deseja realizar: ";
    }

    public function realizarConversao($escolha) {
        $conversao = $this->conversor->getConversaoPorIndice($escolha);
        preg_match('/^(.*?)->(.*?)$/', $conversao, $matches);

        $de = $matches[1];
        $para = $matches[2];

        echo "Digite o valor que deseja converter: ";
        $valor = trim(fgets(STDIN));

        if (!$this->validarValor($valor)) {
            return;
        }

        try {
            $resultado = $this->conversor->converter($valor, $de, $para);
            echo "Resultado da conversão de $de para $para: $resultado\n";
        } catch (Exception $e) {
            echo "Erro ao realizar a conversão: " . $e->getMessage() . "\n";
        }
    }

    private function exibirMenuInterativo() {
        while (true) {
            $this->exibirMenu();
            $unidade = trim(fgets(STDIN));
        
            if ($unidade == 7) {
                echo "Saindo...\n";
                exit;
            }

            $this->exibirConversoesPorUnidade($unidade);

        }
    }

    public function listarConversoes($grandeza) {
        $conversor = ConversorFactory::criarConversor($grandeza);
        return $conversor->getConversoesSuportadas();
    }

    public function exibirHelp() {
        echo "Comandos disponíveis:\n";
        echo "  converter [grandeza] [de] [para] [valor] - Realiza a conversão de uma unidade\n";
        echo "  listar [grandeza] - Lista as conversões suportadas para uma grandeza\n";
        echo "  help - Exibe essa ajuda\n";
        echo "Exemplos:\n";
        echo "  php conversor.php converter temperatura celsius fahrenheit 30\n";
        echo "  php conversor.php listar comprimento\n";
        echo "  php conversor.php help\n";
    }

    public function run() {
        global $argv, $argc;

        if ($argc > 1) {
            $comando = $argv[1];

            switch ($comando) {
                case '--help':
                case '-h':
                    $this->exibirHelp();
                    exit(0);
                case '--version':
                case '-v':
                    echo "";
                    exit(0);
                case 'converter':
                    if ($argc < 6) {
                        echo "Uso: php conversor.php converter [grandeza] [de] [para] [valor]\n";
                        echo "Exemplo: php conversor.php converter temperatura c f 30\n";
                        exit(1);
                    }

                    $grandeza = strtolower($argv[2]);
                    $de = strtolower($argv[3]);
                    $para = strtolower($argv[4]);
                    $valor = strtolower($argv[5]);
                    
                    try {
                        $this->conversor = ConversorFactory::criarConversor($grandeza);
                    } catch(Exception $e) {
                        echo "Erro: " . $e->getMessage() . "\n";
                        exit(1);
                    }

                    try {
                        $resultado = $this->conversor->converter($valor, $de, $para);
                        echo "Resultado da conversão de $de para $para: $resultado\n";
                    } catch(Exception $e) {
                        echo "Erro ao converter: " . $e->getMessage() . "\n";
                        exit(1);
                    }

                    break;

                // Corrigir
                case 'listar':
                    if ($argc < 3) {
                        echo "Uso: php conversor.php listar [grandeza]\n";
                        echo "Exemplo: php conversor.php converter temperatura c f 30\n";
                        exit(1);
                    }

                    $grandeza = $argv[2];
                    
                    $conversoes = $this->listarConversoes($grandeza);

                    foreach($conversoes as $conversao) {
                        echo $conversao;
                    }

                    break;

                default:
                    echo "Comando '$comando' não reconhecido.\n";
                    echo "Comandos disponíveis:\n";
                    echo " converter [grandeza] [de] [para] [valor]\n";
                    exit(1);
            }
        } else {
            $this->exibirMenuInterativo();
        }
    }
}