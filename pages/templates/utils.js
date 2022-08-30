function strZero (n, len) {
    return n.toLocaleString('pt-BR', {
        minimumIntegerDigits: len,
        useGrouping: false
    })
}

export function makeLoading(element) {
    let lastBytes = 0;
    function setSize (size, bytes) {
        const diff = bytes - lastBytes;
        lastBytes = bytes;

        size = `${size < 0 ? 1 : size}%`;
        element.querySelector(".progress-bar").style.width = size;
        element.querySelector(".progress-bar").textContent = `${size} (${(diff / 1024 / 1024).toFixed(2)}mb/s)`;
    }
    return {
        show: () => {
            element.classList.remove("invisible");
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
    return Object.values(forms).every(value => value !== null && value !== undefined && value !== "");
}