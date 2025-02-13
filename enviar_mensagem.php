<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true);
    $mensagem = $dados['mensagem'];
    $nickname = $dados['nickname'];

    // Armazenar a mensagem e o nickname no arquivo
    $mensagemFormatada = "$nickname: $mensagem\n"; // Formatação da mensagem
    file_put_contents('mensagens.txt', $mensagemFormatada, FILE_APPEND);
}
?>
