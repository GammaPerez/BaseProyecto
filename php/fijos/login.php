<?php
    require("conectar.php");
    $con = new CC();
    $user = $_POST["user"];
    $pwd = $_POST["pwd"];
    $result = [];
    $mensaje = "";
    $priv = [];
    $data = $con->getDataWP("Select idusuario, nombre From usuario Where usuario=? And contraseña=? And activo=1", array($user, md5($pwd)));
    if (count($data) > 0) {
        $mensaje = "Correcto";
        session_start();
        $_SESSION["idu"] = $data[0]["idusuario"];
        $_SESSION["nombre"] = $data[0]["nombre"];
        $_SESSION["permisos"] = $con->getPriv($data[0]["idusuario"]);
    }
    else {
        $mensaje = "Usuario o contraseña incorrectos o el usuario no esta activo en el sistema";
    }
    $result = array("mensaje" => $mensaje);
    echo json_encode($result);
?>