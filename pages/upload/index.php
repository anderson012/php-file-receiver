<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio de arquivos para o Servidor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.12/bootstrap-4/bootstrap-4.min.css" integrity="sha256-tnw7xEkyNDP7RL2pWAeV2dGZ6vrTSKvWG4vzMzeZmjM=" crossorigin="anonymous"> -->
</head>
<body>
    <div class="container">
        <h3 class="mt-3">Envio de arquivos para o Servidor</h3>
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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> Envio de arquivos</h5>
                <form method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input id="file-version" type="text" required class="form-control" placeholder="Versão do arquivo (Cole uma ou clique em 'Gerar')" aria-label="Versão do arquivo" aria-describedby="button-version">
                        <button class="btn btn-outline-secondary" type="button" id="button-version">Gerar</button>
                    </div>
                    <input required class="form-control mt-2" type="file" name="file" id="file" >
                    <div id="upload-progress" class="progress invisible">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                    </div>
                    <input class="btn btn-primary mt-2" disabled type="button" value="Enviar arquivo" name="submit" id="submit">
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.29/dist/sweetalert2.all.min.js" integrity="sha256-qxQs7IPMvfbL9ZXhsZ3tG/LuZSjNxPSTBNtzk4j5FiU=" crossorigin="anonymous"></script>
<script type="module" src="./utils.js"></script>
<script type="module" src="./upload.js"></script>
</html>