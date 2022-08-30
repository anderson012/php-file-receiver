import { validate } from "./utils.js"
(() => {
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const applyPass = document.getElementById("apply-pass");

    function onClickApplyPass() {
        const valid = validate({
            username: username.value,
            password: password.value
        });

        if (!valid) {
            swal.fire("Oops", "Usuário e senha são obrigatórios", "warning");
            return;
        }

        if (username.getAttribute("disabled")) {
            username.removeAttribute("disabled")
            password.removeAttribute("disabled")
            applyPass.textContent = "Aplicar";
        } else {
            username.setAttribute("disabled", true);
            password.setAttribute("disabled", true);
            applyPass.textContent = "Editar";
        }
    }

    applyPass.addEventListener("click", onClickApplyPass);
})();