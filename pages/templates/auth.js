(() => {
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const applyPass = document.getElementById("apply-pass");

    function onClickApplyPass() {
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