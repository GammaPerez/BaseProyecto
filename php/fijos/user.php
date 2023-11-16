<?php
    require("conectar.php");
    $con = new CC();
    session_start();
    $response = [];
    $response = array("user" => $_SESSION["nombre"], "iduser" => $_SESSION["idu"], "permisos" => $_SESSION["permisos"]);
    echo json_encode($response);
?>