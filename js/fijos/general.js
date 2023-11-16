ID_CMB = "";
ID_USER = 0;
PERMISOS = "";
DIR_ = "http://" + window.location.hostname + ":8080";

$(document).ready(function () {
    console.log("cargo");
}); 


function getElm(id) {
    return document.getElementById(id);
}
function getName(id) {
    return document.getElementsByName(id);
}

function Tecla(event) {
    var x = window.event ? event.keyCode : event.which;
    return x;
}

function findPermiso(id) {
    var res = false;
    if (PERMISOS.includes('<' + id + '>'))
        res = true;
    return res;
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function sessionCheck() {
    $.get(DIR_ + "/php/fijos/session.php", { opt: "check" }, function (result) {
        if (result == "Expired")
            window.location = DIR_ + "/html/login/login.html";
    }, "json").fail(function (e) { console.log(e.responseText); });
}

function getUserInfo() {
    $.get(DIR_ + "/php/fijos/user.php", {}, function (result) {
        console.log(result);
        getElm("user").innerHTML = result.user;
        ID_USER = result.iduser;
        validaMenu(result.permisos);
    }, "json").fail(function (e) { console.log(e.responseText); });
}

function sessionDestroy() {
    $.get(DIR_ + "/php/fijos/session.php", { opt: "destroy" }, function (result) {
        window.location = DIR_ + "/html/login/login.html";
    }, "json").fail(function (e) { console.log(e.responseText); });
}

function permisosUsuario(data) {
    let i;
    PERMISOS = "";
    for (i = 0; i < data.length; i++)
        PERMISOS += "<" + data[i].idaccion + ">";
}

function permitir(id) {
    let res = false;
    if (PERMISOS.search(id) != -1)
        res = true;
    return res;
}

function validaMenu(permisos) {
    var items = document.getElementsByClassName('mi');
    for (let i = 0; i < items.length; i++) {
        if (permisos.includes('<' + items[i].id + '>'))
            items[i].classList.remove("disabled");
    }
}

function cmb(data, select) {
    var input = '';
    var ctrl = getElm(select);
    for (var i = 0; i < data.length; i++)
        input += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
    ctrl.innerHTML = input;
}

function BuscaSelect(select, buscar) {
    var select = getElm(select);

    for (var i = 0; i < select.length; i++) {
        if (buscar == "") {
            select.selectedIndex = 0;
            break;
        }
        if (select.options[i].value == buscar) {
            select.selectedIndex = i;
            break;
        }
    }
}

function BtnLoading(elem) {
    $(elem).prop("disabled", true);
    $(elem).html('<i class="spinner-border spinner-border-sm"></i> Cargando...');
}

function BtnReset(elem, html) {
    $(elem).prop("disabled", false);
    $(elem).html(html);
}
