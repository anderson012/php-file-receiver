function strZero (n, len) {
    return n.toLocaleString('pt-BR', {
        minimumIntegerDigits: len,
        useGrouping: false
    })
}

export function makeLoading(element) {
    let lastBytes = 0;
    const setSize = (size, bytes = 0, message) => {
        let transfer = "0mbs";
        if (!isNaN(bytes)) {
            const diff = bytes - lastBytes;
            lastBytes = bytes;

            size = `${size < 0 ? 10 : size}%`;
            transfer = `${(diff / 1024 / 1024).toFixed(2)}mb/s`;
        } else {
            transfer = undefined;
        }
        element.querySelector(".progress-bar").style.width = size;
        element.querySelector(".progress-bar").textContent = `${size} (${transfer ?? message ?? "-"})`;
    }
    return {
        show: () => {
            element.classList.remove("invisible");
        },
        changeColor: (color="danger") => {
            const progressBar = element.querySelector(".progress-bar");
            progressBar.classList.forEach((classItem) => {
                if (classItem.includes("bg-")) {
                    progressBar.classList.remove(classItem);
                }
            })
            progressBar.classList.add(`bg-${color}`);
        },
        hide: () => {
            element.classList.add("invisible");
        },
        start: () => {
            setSize(1);
        },
        finish: () => {
            setSize(100);
        },
        setSize,
    };
}

function getVersionYear () {
    const first = 2022;
    let now = new Date().getFullYear();
    let versionYear = (now - first) + 1;
    return versionYear;
}

export function generateVersion() {
    const date = new Date();
    return "v." + getVersionYear() + "." + strZero(date.getMonth() + 1, 2) + "." +
        strZero(date.getDate(), 2) +
        strZero(date.getHours(), 2) +
        strZero(date.getMinutes(), 2);
}

/**
 * 
 * @param {{}} forms 
 * @returns {boolean} true if all values are valid
 */
export function validate(forms) {
    return Object.values(forms).every(value => value !== null && value !== undefined && (typeof value == "string" ? value.trim() : true));
}

export function getAuth() {
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    return {
        username: username.value,
        password: password.value,
    }
}

/**
 * 
 * @param {Blob|File} file file to split
 * @param {number} len in MB
 * @returns {Blob[]} blob list to upload
 */
export function splitFile(file, chunkSize = 10) {
    chunkSize = chunkSize * 1024 * 1024;
    if (file.size <= chunkSize) {
        return [file];
    }
    let start = 0;
    let end = chunkSize;
    let chunks = [];
    while (start < file.size) {
        chunks.push(file.slice(start, end, file.type + "-part"));
        start = end;
        end += chunkSize;
    }

    return chunks;
}