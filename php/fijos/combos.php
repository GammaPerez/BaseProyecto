<?php
    require("conectar.php");
    session_start();
    $con = new CC();
    $opt = $_GET["table"];
    switch($opt) {
        case "sucursal":
            $data = [];
            $data = $con->getDataRows("SELECT idsucursal as id, nom_sucursal as nombre FROM sucursales;");
            echo json_encode($data);
            break;
            
        case "indsucursal":
            $data = [];
            $data = $con->getDataRows("SELECT clave as clave FROM sucursales WHERE idsucursal=".$_REQUEST["id"].";");
            echo json_encode($data);
            break;

        case "tipoclientes":
            $data = [];
            $data = $con->getDataRows("SELECT idcliente as id, nom_cliente as nombre FROM tipocliente;");
            echo json_encode($data);
            break;

        case "sucursal_usuario":
            $data = [];
            $data = $con->getDataRows("SELECT * FROM vw_sucursal_usuario WHERE idusuario = ".$_SESSION["idu"]);
            echo json_encode($data);
            break;

        case "niveles":
            $data = [];
            $data = $con->getDataRows("SELECT u.idusuario as id, u.nombre as nombre FROM usuarios u INNER JOIN acciones_usuario au ON au.idusuario = u.idusuario WHERE au.idaccion = 'ADMIN' OR au.idaccion = 'SUP';");
            echo json_encode($data);
            break;

        case "niveles_select":
            $data = [];
            $data = $con->getDataRows("SELECT * FROM vw_niveles WHERE idaccion = 'SUP' AND idsucursal =".$_REQUEST["sucursal"].";");
            echo json_encode($data);
            break;

        case "estados":
            $data = [];
            if(strpos($_SESSION["permisos"],"<ADMIN>") !==false){
                //$mensaje = "Correcto";
                $data = $con->getDataRows("SELECT s.idstatus as id, s.status as nombre FROM estatus s");
            }else{
                //$mensaje = "Incorrecto";
                if($_REQUEST["sts"] == 1){
                    $data = $con->getDataRows("SELECT s.idstatus as id, s.status as nombre FROM estatus s WHERE s.idstatus = 0 OR s.idstatus = 2");
                }else if($_REQUEST["sts"] == 3 && strpos($_SESSION["permisos"],"<ENC>") !==false){
                    $data = $con->getDataRows("SELECT s.idstatus as id, s.status as nombre FROM estatus s WHERE s.idstatus = 0 OR s.idstatus = 4");
                }
            }
            echo json_encode($data);
            break;

        case "foliosucursal":
            $data = [];
            $data = $con->getDataRows("SELECT max(folio) as folio FROM solicitudes WHERE clave='".$_REQUEST["clave"]."'");
            echo json_encode($data);
            break;

        case "getstatus":
            $data = [];
            $data = $con->getDataRows("SELECT statuss,ResultG FROM solicitudes WHERE idsolicitud='".$_REQUEST["idsolicitud"]."';");
            echo json_encode($data);
            break;
        case "liststatus":
            $data = [];
            $data = $con->getDataRows("SELECT status as id, status as nombre FROM estatus;");
            echo json_encode($data);
            break;
    }
?>