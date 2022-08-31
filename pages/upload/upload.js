import { generateVersion, makeLoading, validate, getAuth, splitFile } from "../templates/utils.js"

(() => {
    const submit = document.getElementById("submit");
    const fileInput = document.getElementById("file");
    const uploadProgress = document.getElementById("upload-progress");
    const fileVersion = document.getElementById("file-version");
    const btnVersion = document.getElementById("button-version");

    let loading = makeLoading(uploadProgress);
    /**
     * @type {File}
     */
    let originalFile = null;
    /**
     * @type {Blob[]}
     */
    let files = [];

    /**
     * 
     * @param {MouseEvent} e
     */
    async function upload(e) {
        e.preventDefault();
        const valid = validate({
            version: fileVersion.value,
            ...getAuth(),
            file: originalFile,
        });

        if (!valid) {
            swal.fire("Atenção", "Formulário inválido", "warning");
            return;
        }

        try {
            let data = {};
            for (let file of files) {
                data = await uploadSingleFile(file, files.indexOf(file));
            }
            data = await joinFile(data.result);
            swal.fire("Informação", `Arquivo enviado com sucesso! ${data.result ?? data.msg ?? ""}`, "info");
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
     * @param {Blob} file 
     * @returns 
     */
    async function uploadSingleFile(file, index) {
        const form = new FormData();
        form.append("file", file, `${originalFile.name}-part${index}`)
        form.append("version", fileVersion.value);
        submit.setAttribute("disabled", true);
        fileInput.setAttribute("disabled", true);
        loading = makeLoading(uploadProgress);
        loading.show();
        loading.start();
        const {data} = await axios.post("/routers/upload/index.php", form, {
            headers: {
                "content-type": "multipart/form-data"
            },
            auth: getAuth(),
            onUploadProgress: (event) => {
                let progress = (
                    (event.loaded * 100) / event.total
                ).toFixed(2);

                loading.setSize(progress, event.loaded);
            },
        });
        return data;
    }

    async function joinFile(filePart) {
        const form = new FormData();
        form.append("targetFile", filePart.split("-part")[0])
        form.append("chunks", files.length);
        swal.fire("Juntanto arquivos");
        swal.showLoading();
        const {data} = await axios.post("/routers/join-parts/index.php", form, {
            headers: {
                "content-type": "multipart/form-data"
            },
            auth: getAuth(),
        });

        return data;
    }

    /**
     * @param {HTMLInputElement} e
     */
    function onChangeFile(e){
        originalFile = e.target.files[0];

        if (originalFile) {
            files = splitFile(originalFile);
            console.log(files);
            submit.removeAttribute("disabled");
        }
    }

    fileInput.addEventListener("change", onChangeFile);
    submit.addEventListener("click", upload);
    btnVersion.addEventListener("click", () => {
        fileVersion.value = generateVersion();
    })
})();