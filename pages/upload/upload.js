import { generateVersion, makeLoading, validate, getAuth, splitFile } from "../templates/utils.js"

(() => {
    const submit = document.getElementById("submit");
    const fileInput = document.getElementById("file");
    const uploadProgress = document.getElementById("upload-progress");
    const fileVersion = document.getElementById("file-version");
    const btnVersion = document.getElementById("button-version");
    const chunkSize = document.getElementById("chunk-size");
    const MAX_PARALLEL_REQ = 3;

    // let loading = makeLoading(uploadProgress);
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
            await async.eachLimit(files, MAX_PARALLEL_REQ, async (file) => {
                data = await uploadSingleFile(file, files.indexOf(file));
            });
            data = await joinFile(data.result);
            swal.fire("Yuupiii 🥳 🤩", `Arquivo enviado com sucesso! ${data.result ?? data.msg ?? ""}`, "success");
        } catch(e) {
            console.warn(e);
            swal.fire("Oops", e?.response?.data?.msg ?? e.message ?? "Processo inesperado no servidor", "warning");
        } finally {
            submit.removeAttribute("disabled");
            fileInput.removeAttribute("disabled");
            // loading.finish();
            // loading.hide();
            // loading.setSize(0);
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
        const elementUpload = document.getElementById(`upload-progress-${index}`)
        const loading = makeLoading(elementUpload);
        // loading.show();
        loading.start();
        try {
            let {data} = await axios.post("/routers/upload/index.php", form, {
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
            loading.changeColor("success");
            return data;
        } catch (e) {
            loading.changeColor();
            throw e;
        }
    }

    async function joinFile(filePart) {
        const form = new FormData();
        form.append("targetFile", filePart.split("-part")[0])
        form.append("chunks", files.length);
        swal.fire("Juntando arquivos");
        swal.showLoading();
        const {data} = await axios.post("/routers/join-parts/index.php", form, {
            headers: {
                "content-type": "multipart/form-data"
            },
            auth: getAuth(),
        });

        return data;
    }

    function mountListOfUpload() {
        const html = files.map((file, i) => {
            return `
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                    <div class="fw-bold">${originalFile.name}-part${i} (${(file.size /1024/1024).toFixed(2)}mb)</div>
                    <div id="upload-progress-${i}" class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 10%">0%</div>
                    </div>
                    </div>
                </li>
            `;
        }).join("");

        document.getElementById("upload-list").innerHTML = `
            <h5 class="card-title">Aproximadamente ${(originalFile.size /1024/1024).toFixed(2)}mb em ${files.length} partes para enviar</h5>
            <ol class="list-group list-group-numbered">
                ${html}
            </ol>
        `;
    }

    /**
     * @param {HTMLInputElement} e
     */
    function onChangeFile(e){
        originalFile = e.target.files[0];

        if (originalFile) {
            const chunkSizeValue = Number(chunkSize.value);
            if (chunkSizeValue < 10 || chunkSizeValue > 100) {
                swal.fire("Oops", "O valor de corte deve ser maior que 10mb e menor que 100mb", "warning");
                e.target.value = null;
                return;
            }
            files = splitFile(originalFile, chunkSizeValue);
            mountListOfUpload();
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