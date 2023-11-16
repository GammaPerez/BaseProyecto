<?php
header("Access-Control-Allow-Origin: *");
    session_start();
    $opt = $_GET["opt"];

    switch($opt) {
        case 'check':
            $res = "";
            if (!isset($_SESSION["idu"])) {
                $res = "Expired";
            }
            else
                $res = "Active";
            echo json_encode($res);
            break;
        case 'destroy':
            session_destroy();
            echo json_encode("Correcto");
            break;
    }
?>