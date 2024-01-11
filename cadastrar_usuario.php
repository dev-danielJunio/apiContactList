<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperando os dados do formulário
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Construindo o payload para a API
    $data = [
        'nome' => $nome,
        'senha' => $senha,
        'email' => $email,
        'telefone' => $telefone
    ];

    // Convertendo o payload para JSON
    $jsonData = json_encode($data);

    // Configurando a requisição cURL para a API
    $url = 'http://localhost/Consumirapi/api/usuarios/cadastrar';
    $token = '65825fa1cb8fd';  // Substitua pelo seu token
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    // Executando a requisição
    $response = curl_exec($ch);

    // Lidando com a resposta da API
    $responseData = json_decode($response);

    if (isset($responseData->tipo) && $responseData->tipo === 'erro') {
        echo 'Erro na resposta da API: ' . $responseData->resposta;
    } else {
        echo 'Usuário cadastrado com sucesso!';
    }

    curl_close($ch);
    header('Location: index.php');
    exit();
}
?>
