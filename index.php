<?php
    $title="Processos uteis para arquivos e versões";
    $auth=false;
    include_once("./pages/templates/header.template.php");

    class Item {
        public ?int $id = null;
        public ?string $title = null;
        public ?string $description = null;
        public ?string $link = null;

        function __construct(int $id, string $title, string $description, string $link) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->link = $link;
        }
    }

    $items = array(
        new Item(
            1,
            "Envio de arquivos",
            '
                <p class="card-text">Envie arquivos de qualquer tamanho para o servidor!</p>
                <p class="card-text">O arquivos será cortado em partes iguais e depois a url de download será disponibilizada.</p>
                <p class="card-text">Também é possível enviar versões de alguns sistemas.</p>
            ',
            "/pages/upload/index.php"
        ),
        new Item(
            2,
            "Publicação de DLL de relatórios",
            '
                <p class="card-text">Envie a qualquer versão da DLL para qualquer cliente.</p>
            ',
            "/pages/wsreport-deploy/index.php"
        ),
    );
?>

<div class="row d-flex align-items-stretch mb-3">
    <?php foreach ($items as &$item) { ?>
        <div class="col-3">
            <div class="card h-100" style="width: 20rem;">
                <div class="card-body d-flex flex-column h-100">
                    <h5 class="card-title"><?php echo $item->title ?></h5>
                    <?php echo $item->description ?>
                    <a href="<?php echo $item->link ?>" class="btn btn-primary align-self-start mt-auto">Acessar</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
    $scripts = '
        <script type="module" src="./wsreport-deploy.js?version='. Utils\General::VERSION . '"></script>
    ';
    include_once("./pages/templates/footer.template.php");
?>