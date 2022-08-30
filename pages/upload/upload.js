import { generateVersion, makeLoading, validate } from "../templates/utils.js"

(() => {
    const submit = document.getElementById("submit");
    const fileInput = document.getElementById("file");
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const uploadProgress = document.getElementById("upload-progress");
    const fileVersion = document.getElementById("file-version");
    const btnVersion = document.getElementById("button-version");

    const loading = makeLoading(uploadProgress);

    let file = null;

    /**
     * 
     * @param {MouseEvent} e
     */
    async function upload(e) {
        e.preventDefault();
        const valid = validate({
            version: fileVersion.value,
            username: username.value,
            password: password.value,
            file: file,
        });

        if (!valid) {
            swal.fire("Atenção", "Formulário inválido", "warning");
            return;
        }

        try {
            const form = new FormData();
            form.append("file", file)
            form.append("version", fileVersion.value);
            submit.setAttribute("disabled", true);
            fileInput.setAttribute("disabled", true);
            loading.show();
            loading.start();
            const { data } = await axios.post("/index.php", form, {
                headers: {
                    "content-type": "multipart/form-data"
                },
                auth: {
                    username: username.value,
                    password: password.value
                },
                onUploadProgress: (event) => {
                    let progress = (
                        (event.loaded * 100) / event.total
                    ).toFixed(2);
        
                    console.log(
                        `A imagem ${file.name} está ${progress}% carregada... `
                    )
                    loading.setSize(progress, event.loaded);
                },
            });
            swal.fire("Informação", `Arquivo enviado com sucesso! ${data.result ?? data.msg}`, "info");
        } catch(e) {
            console.warn(e);
            swal.fire("Oops", e?.response?.data?.msg ?? e.message ?? "Processo inesperado no servidor", "warning");
        } finally {
            submit.removeAttribute("disabled");
            fileInput.removeAttribute("disabled");
            loading.finish();
            loading.hide();
            loading.setSize(0);
        }
    }

    /**
     * @param {HTMLInputElement} e
     */
    function onChangeFile(e){
        file = e.target.files[0];
        console.log(file);
        if (file) {
            submit.removeAttribute("disabled");
        }
    }

    fileInput.addEventListener("change", onChangeFile);
    submit.addEventListener("click", upload);
    btnVersion.addEventListener("click", () => {
        fileVersion.value = generateVersion();
    })
})();