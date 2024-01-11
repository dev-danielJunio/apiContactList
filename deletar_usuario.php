<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se o ID do usuário está presente no formulário
    if (isset($_POST['id_usuario'])) {
        $idUsuarioParaExcluir = $_POST['id_usuario'];

        $url = 'http://localhost/Consumirapi/api/usuarios/deletar/' . $idUsuarioParaExcluir;
        $token = '65825fa1cb8fd';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch));

        if (curl_errno($ch)) {
            echo 'Erro cURL: ' . curl_error($ch);
         } else {
            if ($response->tipo === null) {
               echo 'Erro ao decodificar a resposta JSON.';
            } else {
               if (isset($response->tipo) && $response->tipo === 'erro') {
                  echo 'Erro na resposta da API: ' . $response->resposta;
               }
               elseif (isset($response->resposta) && is_array($response->resposta)) {
                   foreach ($response->resposta as $usuario) {
                       $usuarios[] = $usuario->nome;
                   }
               }
            }
         }

        curl_close($ch);
        header('Location: index.php');
        exit();

        }
}
?>