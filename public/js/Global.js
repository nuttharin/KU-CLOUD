function getStorage(name) {
    return JSON.parse(localStorage.getItem(name));

}

function setStorage(name, value) {
    localStorage.setItem(name, JSON.stringify(value));
}

function clearStorage() {
    window.localStorage.clear();
}


function IsNullOrEmpty(val) {
    if (val != null && val != "")
        return true;
    return false;
}

function StringEmpty(val) {
    if (val != null && val != "")
        return val;
    return "";
}

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + 3600 * 3000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            var sub = c.substring(name.length, c.length);
            return sub;
        }
    }
    return "";
}