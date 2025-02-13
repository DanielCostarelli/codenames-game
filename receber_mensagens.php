<?php
$arquivo = 'mensagens.txt';

if (file_exists($arquivo)) {
    $mensagens = file($arquivo, FILE_IGNORE_NEW_LINES);
    echo json_encode($mensagens);
} else {
    echo json_encode([]);
}
?>
