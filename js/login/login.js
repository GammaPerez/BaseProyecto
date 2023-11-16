$("document").ready(function() {
    getElm("user").focus();
});

function login() {
    var user = getElm("user").value;
    var pwd = getElm("pwd").value;
    $.post(DIR_+"/php/fijos/login.php", { user: user, pwd: pwd } , function(result) {
        if (result.mensaje === "Correcto")
            window.location = DIR_ + "/html/index.php";
        else
            alert(result.mensaje);
    } ,"json").fail(function(e) {console.log(e);});
}

function checkKey(event) {
    if (event.keyCode == 13)
        login();
}