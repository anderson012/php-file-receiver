<?php 
    $title="Envio de arquivos para o Servidor";
    include_once("../templates/header.template.php");
?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Envio de arquivos</h5>
        <form method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <input id="file-version" type="text" required class="form-control" placeholder="Versão do arquivo (Cole uma ou clique em 'Gerar')" aria-label="Versão do arquivo" aria-describedby="button-version">
                <button class="btn btn-outline-secondary" type="button" id="button-version">Gerar</button>
            </div>
            <input required class="form-control mt-2" type="file" name="file" id="file" >
            
            <div id="upload-progress" class="progress invisible">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 1%"></div>
            </div>

            <p>
                Arquivos maiores que 10Mb serão cortados e enviados por partes
            </p>
            
            <input class="btn btn-primary mt-2" disabled type="button" value="Enviar arquivo" name="submit" id="submit">
            <div  id="upload-list" class="mt-3">
                
            </div>
        </form>
    </div>
</div>

<?php 
    $scripts = '
        <script type="module" src="./upload.js?version='. Utils\General::VERSION . '"></script>
    ';
    include_once("../templates/footer.template.php"); 
?>