<?php
// salvar.php
$token = "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"; // coloque o novo token aqui com cuidado
$repoOwner = "darlylson";
$repoName = "vacina";
$filePath = "registros.json";

$data = json_decode(file_get_contents("php://input"), true);

// Baixar registros atuais
$headers = [
    "Authorization: token $token",
    "User-Agent: PHP-Request"
];

$url = "https://api.github.com/repos/$repoOwner/$repoName/contents/$filePath";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
curl_close($ch);
$remote = json_decode($result, true);

$oldContent = json_decode(base64_decode($remote['content']), true) ?: [];
$oldContent[] = $data;

$newContent = base64_encode(json_encode($oldContent, JSON_PRETTY_PRINT));

$payload = json_encode([
    "message" => "Adicionar nova vacinação",
    "content" => $newContent,
    "sha" => $remote["sha"]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, ["Content-Type: application/json"]));
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
