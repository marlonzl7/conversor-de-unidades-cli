<?php

require_once (__DIR__ . '/../includes/includeAll.php');

class ConversorCLI {
    private $conversor;

    public function exibirMenu() {
        echo colorize("=== Conversor de Unidades ===", "1;33") . "\n";
        echo "[1] Comprimento\n";
        echo "[2] Massa\n";
        echo "[3] Temperatura\n";
        echo "[4] Tempo\n";
        echo "[5] Velocidade\n";
        echo "[6] Volume\n";
        echo "[7] Sair\n";
        echo "Escolha a unidade que quer converter: ";
    }

    public function exibirConversoesSuportadas($grandeza) {
        $this->conversor = ConversorFactory::criarConversor($grandeza);
        $conversoes = $this->conversor->getConversoesSuportadas();
    
        $i = 0;
                
        foreach ($conversoes as $i => $conversao) {
            echo "[$i] $conversao\n";
        };
        
        echo "Infome a conversão que deseja fazer: ";
    }

    public function realizarConversao($escolha) {
        $conversao = $this->conversor->getConversaoPorIndice($escolha);
        preg_match('/^(.*?)->(.*?)$/', $conversao, $matches);

        $de = $matches[1];
        $para = $matches[2];

        echo "Digite o valor que deseja converter: ";
        $valor = trim(fgets(STDIN));

        $resultado = $this->conversor->converter($valor, $de, $para);
        echo "Resultado da conversão de $de para $para: ";
        echo colorize("$resultado", "1;34");
    }

    private function exibirMenuInterativo() {
        while (true) {
            $this->exibirMenu();
            $grandeza = trim(fgets(STDIN));
        
            switch ($grandeza) {
                case 1:
                    $this->exibirConversoesSuportadas("comprimento");
                    $escolha = trim(fgets(STDIN));
                    $this->realizarConversao($escolha);

                    break;
                
                case 2:
                    $this->exibirConversoesSuportadas("massa");
                    $escolha = trim(fgets(STDIN));
                    $this->realizarConversao($escolha);

                    break;
        
                case 3:
                    $this->exibirConversoesSuportadas("temperatura");
                    $escolha = trim(fgets(STDIN));
                    $this->realizarConversao($escolha);
                    
                    break;
        
                case 4:
                    $this->exibirConversoesSuportadas("tempo");
                    $escolha = trim(fgets(STDIN));
                    $this->realizarConversao($escolha);

                    break;
        
                case 5:
                    $this->exibirConversoesSuportadas("velocidade");
                    $escolha = trim(fgets(STDIN));
                    $this->realizarConversao($escolha);

                    break;
        
                case 6:
                    $this->exibirConversoesSuportadas("volume");
                    $escolha = trim(fgets(STDIN));
                    $this->realizarConversao($escolha);
                    
                    break; 
        
                case 7:
                    echo "Saindo...\n";
                    exit;
        
                default:
                    echo "Opção inválida";
            }
        }
    }

    public function run() {
        global $argv, $argc;

        if ($argc > 1) {
            $comando = $argv[1];

            switch ($comando) {
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
                        echo "Resultado da conversão de $de para $para: ";
                        echo colorize("$resultado", "1;34");
                    } catch(Exception $e) {
                        echo "Erro ao converter: " . $e->getMessage() . "\n";
                        exit(1);
                    }

                    break;

                // Corrigir
                case 'listar':
                    if ($argc < 3) {
                        echo "Uso: php conversor.php listar [grandeza]\n";
                        echo "Exemplo: php conversor.php listar temperatura\n";
                        exit(1);
                    }

                    $grandeza = $argv[2];

                    $conversor = ConversorFactory::criarConversor($grandeza);
                    $conversoes = $conversor->getConversoesSuportadas();
                    
                    foreach($conversoes as $conversao) {
                        echo $conversao . "\n";
                    }

                    break;

                default:
                    echo "Comando '$comando' não reconhecido.\n";
                    echo "Comandos disponíveis:\n";
                    echo " - converter [grandeza] [de] [para] [valor]\n";
                    echo " - listar [grandeza]\n";
                    exit(1);
            }
        } else {
            $this->exibirMenuInterativo();
        }
    }
}