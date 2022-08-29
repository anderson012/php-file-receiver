function strZero (n, len) {
    return n.toLocaleString('pt-BR', {
        minimumIntegerDigits: len,
        useGrouping: false
    })
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