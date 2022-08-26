import axios from "axios";

(()=>{
    const submit = document.getElementById("submit");
    /**
     * 
     * @param {MouseEvent} e
     */
    function upload(e) {
        e.preventDefault();
        const form = new FormData();
        form.append("file", )
        axios.post("/index.php", form, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
    }
    submit.addEventListener("click", upload);
})();