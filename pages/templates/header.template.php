<?php
    include_once("../../utils/constants.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.12/bootstrap-4/bootstrap-4.min.css" integrity="sha256-tnw7xEkyNDP7RL2pWAeV2dGZ6vrTSKvWG4vzMzeZmjM=" crossorigin="anonymous"> -->
</head>
<body>
    <div class="container">
        <h3 class="mt-3"><?php echo $title?></h3>
        <div class="mb-2 card mt-3">
            <div class="card-body">
                <h5 class="card-title">Autenticação</h5>
                <label class="form-label" for="username">Usuário</label>
                <input class="form-control" name="username" id="username" />

                <label class="form-label" for="password">Senha</label>
                <input class="form-control" name="password" type="password" id="password" />
                <button class="btn btn-primary mt-2" id="apply-pass">Aplicar</button>
            </div>
        </div>