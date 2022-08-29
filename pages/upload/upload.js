import { generateVersion } from "./utils.js"

(() => {
    const submit = document.getElementById("submit");
    const fileInput = document.getElementById("file");
    const applyPass = document.getElementById("apply-pass");
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const uploadProgress = document.getElementById("upload-progress");
    const fileVersion = document.getElementById("file-version");
    const btnVersion = document.getElementById("button-version");


    let file = null;

    /**
     * 
     * @param {MouseEvent} e
     */
    async function upload(e) {
        e.preventDefault();
        try {
            const form = new FormData();
            form.append("file", file)
            submit.setAttribute("disabled", true);
            fileInput.setAttribute("disabled", true);
            uploadProgress.classList.remove("invisible");
            const { data } = await axios.post("/index.php", form, {
                headers: {
                    "content-type": "multipart/form-data"
                },
                auth: {
                    username: username.value,
                    password: password.value
                }
            });
            alert(`Arquivo enviado com sucesso! ${data.result ?? data.msg}`)
        } catch(e) {
            console.log(e);
            swal.fire(e?.response?.data?.msg ?? e.message ?? "Processo inesperado no servidor")
        } finally {
            submit.removeAttribute("disabled");
            fileInput.removeAttribute("disabled");
            uploadProgress.classList.add("invisible");
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

    function onClickApplyPass() {
        if (username.getAttribute("disabled")) {
            username.removeAttribute("disabled")
            password.removeAttribute("disabled")
        } else {
            username.setAttribute("disabled", true);
            password.setAttribute("disabled", true);
        }
    }

    fileInput.addEventListener("change", onChangeFile);
    submit.addEventListener("click", upload);
    applyPass.addEventListener("click", onClickApplyPass);
    btnVersion.addEventListener("click", () => {
        fileVersion.value = generateVersion();
    })
})();