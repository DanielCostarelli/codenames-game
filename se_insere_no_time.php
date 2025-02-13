<?php
// Lê o corpo da requisição
$data = json_decode(file_get_contents('php://input'), true);

// Separa as variáveis
$nick = $data[0];
$seed = $data[1];
$prioridade = $data[2];

// Lê o arquivo times.txt
$arquivo = 'times.txt';
$conteudo = file_get_contents($arquivo);
$salas = json_decode($conteudo, true);

// Verifica se a decodificação foi bem-sucedida
if ($salas === null) {
    echo json_encode(['error' => 'Erro ao ler as salas.']);
    exit;
}

// Inicializa uma variável para indicar se a atualização foi feita
$atualizado = false;

foreach ($salas as &$sala) {
    // Verifica se a Seed corresponde
    if ($sala['Seed'] == $seed) {
        // Checa se o nick já está em algum dos grupos
        $found = false;
        foreach (['Azul_espiao', 'Azul_agente', 'Vermelho_espiao', 'Vermelho_agente'] as $time) {
            foreach ($sala[$time] as $key => $valor) {
                if ($valor[0] === $nick) {
                    $found = true;
                    // Se o número recebido for maior, atualiza
                    if ($valor[1] < $prioridade) {
                        unset($sala[$time][$key]); // Remove o antigo
                        $sala['Azul_agente'][] = [$nick, $prioridade]; // Adiciona ao Azul_agente
                    }
                    break 2; // Sai dos loops
                }
            }
        }

        // Se não encontrou, adiciona ao Azul_agente
        if (!$found) {
            $sala['Azul_agente'][] = [$nick, $prioridade];
        }

        $atualizado = true;
        break; // Sai do loop das salas
    }
}

// Se atualizou, escreve de volta no arquivo
if ($atualizado) {
    // Salva o novo conteúdo no arquivo
    file_put_contents($arquivo, json_encode($salas, JSON_PRETTY_PRINT));
    echo json_encode(['success' => 'Nick inserido ou atualizado com sucesso.']);
} else {
    echo json_encode(['error' => 'Seed não encontrada.']);
}
?>
