<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php


$url = 'http://localhost/Consumirapi/api/usuarios/listar';
$token = '65825fa1cb8fd';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = json_decode(curl_exec($ch));

$nomes = [];

if (curl_errno($ch)) {
   echo 'Erro cURL: ' . curl_error($ch);
} else {
   if ($response->tipo === null) {
      echo 'Erro ao decodificar a resposta JSON.';
   } else {
      if (isset($response->resposta) && is_array($response->resposta)) {
          foreach ($response->resposta as $usuario) {
              $usuarios[] = $usuario->nome;
          }
      }
   }
}

curl_close($ch);
?>


<html>
<link rel="stylesheet" href="style.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<div class="container mt-5">
    <!-- Coluna do input de pesquisa -->
    <div class="row mb-3">
        <div class="col-lg-6">
            <div class="input-group">
                <input type="text" id="example-input1-group2" name="example-input1-group2" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-lg btn-primary"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>

        <!-- Coluna do botão de adicionar contato -->
        <div class="col-lg-6 text-end">
            <a href="inserir.php"><button class="btn btn-lg btn-success" type="button"><i class="fa fa-user-plus"></i> Adicionar Contato</button></a>
        </div>
    </div>

    <!-- Loop dos usuários -->
    <div class="row">
        <?php if (isset($response->tipo) && $response->tipo === 'erro') : ?>
            <h4><?= $response->resposta; ?></h4>
        <?php else: ?>
            <?php foreach ($response->resposta as $usuario) : ?>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-body p-t-10">
                        <div class="media-main">
                            <a class="pull-left" href="#">
                                <img class="thumb-sm img-thumbnail rounded-circle bx-s" src="unkown.jpg" alt="" style="max-width: 100px; max-height: 150px;">                            
                            </a>
                            <div class="pull-right btn-group-sm">
                                <form action="atualizar.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario->id ?>">
                                    <button type="submit" class="btn btn-success tooltips btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </form>
                                <form action="deletar_usuario.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario->id ?>">
                                    <button type="submit" class="btn btn-danger tooltips btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="info">
                                <h4><?= $usuario->nome ?></h4>
                                <div class="text-muted"><?= $usuario->id ?></div>
                                <div class="text-muted"><?= $usuario->telefone ?></div>
                                <div class="text-muted"><?= $usuario->email ?></div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</html>


