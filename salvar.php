<?php
// salvar.php

$arquivo = "registros.json";
$dadosRecebidos = json_decode(file_get_contents("php://input"), true);

// Verifica se arquivo existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

$dadosExistentes = json_decode(file_get_contents($arquivo), true);

// Adiciona novo registro
$dadosExistentes[] = $dadosRecebidos;

// Salva no arquivo
file_put_contents($arquivo, json_encode($dadosExistentes, JSON_PRETTY_PRINT));

// Retorna confirmação
echo json_encode(["status" => "sucesso", "mensagem" => "Registro adicionado."]);
?>
