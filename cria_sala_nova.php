<?php
// Recebe o conteúdo JSON do corpo da requisição
$data = file_get_contents('php://input');

// Decodifica o JSON em um array associativo
$nuevaSala = json_decode($data, true);

// Verifica se a decodificação foi bem-sucedida
if ($nuevaSala !== null) {

    // Converte a Seed para inteiro
    $nuevaSala['Seed'] = intval($nuevaSala['Seed']);
    
    // Abre o arquivo existente
    $arquivo = 'times.txt';
    $conteudoAtual = file_get_contents($arquivo);
    
    // Converte o conteúdo atual de volta para um array
    $times = json_decode($conteudoAtual, true);
    
    // Adiciona a nova sala ao array existente
    $times[] = $nuevaSala;
    
    // Escreve o novo conteúdo de volta no arquivo
    file_put_contents($arquivo, json_encode($times, JSON_PRETTY_PRINT));
    
    // Retorna uma resposta de sucesso
    echo json_encode(['success' => true]);
} else {
    // Retorna um erro caso a decodificação falhe
    echo json_encode(['error' => 'Erro ao decodificar JSON']);
}
?>
