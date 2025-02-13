<?php
// Lê o conteúdo do arquivo .txt
$arquivo = file_get_contents('times.txt');

// Tenta decodificar o conteúdo JSON do arquivo
$dados = json_decode($arquivo, true);

// Verifica se a conversão foi bem-sucedida e se há dados
if ($dados !== null) {
    // Itera sobre cada objeto dentro do array de times
    foreach ($dados as &$time) {
        // Transforma os arrays internos no formato desejado
        $time['Azul_espiao'] = array_column($time['Azul_espiao'], 0);
        $time['Azul_agente'] = array_column($time['Azul_agente'], 0);
        $time['Vermelho_espiao'] = array_column($time['Vermelho_espiao'], 0);
        $time['Vermelho_agente'] = array_column($time['Vermelho_agente'], 0);

        // Converte a Seed para inteiro
        $time['Seed'] = intval($time['Seed']);
    }
    
    // Retorna os dados modificados como JSON
    header('Content-Type: application/json');

    echo json_encode($dados);
} else {
    // Retorna um erro em caso de falha na conversão
    echo json_encode(['error' => 'Erro ao carregar times.']);
    // echo json_encode($dados);
}
?>
