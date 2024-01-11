<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php

$idUsuario = $_POST['id_usuario'];

$url = 'http://localhost/Consumirapi/api/usuarios/listar/' . $idUsuario;
$token = '65825fa1cb8fd';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = json_decode(curl_exec($ch));

if (curl_errno($ch)) {
   echo 'Erro cURL: ' . curl_error($ch);
}

curl_close($ch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Formulário Bootstrap</title>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="atualizar_usuario.php" method="post">
                <?php if (isset($response->tipo) && $response->tipo === 'erro') : ?>
                <?php else: ?>
                    <?php $usuario = $response->resposta; ?>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required value="<?= $usuario->nome; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="text" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required value="<?= $usuario->senha; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required value="<?= $usuario->email; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Digite seu telefone" required value="<?= $usuario->telefone; ?>">
                    </div>
                    <input type="hidden" name="id_usuario" value="<?= $usuario->id; ?>">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-eBqOVFiNDofB4kLr40R2SUZSmHJlO2fF5JhOFtqjy" crossorigin="anonymous"></script>
</body>
</html>
