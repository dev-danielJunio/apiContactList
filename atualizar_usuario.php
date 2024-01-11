<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idUsuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];


    $data = [
        'nome' => $nome,
        'senha' => $senha,
        'email' => $email,
        'telefone' => $telefone
    ];

    $data = array_filter($data);

    $jsonData = json_encode($data);

    $url = 'http://localhost/Consumirapi/api/usuarios/atualizar/' . $idUsuario;
    $token = '65825fa1cb8fd'; 
    $ch = curl_init($url);


    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Erro cURL: ' . curl_error($ch);
    } else {
        $responseData = json_decode($response);

        if (isset($responseData->tipo) && $responseData->tipo === 'erro') {
            echo 'Erro na resposta da API: ' . $responseData->resposta;
        } else {
            echo 'Usuário atualizado com sucesso!';
        }
    }

    curl_close($ch);
    header('Location: index.php');
    exit();
}
?>
