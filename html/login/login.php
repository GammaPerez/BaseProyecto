<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("../fijos/encabezados.php"); ?>

    <!--LINKS PROPIOS-->
    <script src="../../js/login/login.js"></script>
    <link rel="stylesheet" href="../../css/login/login.css">
    <!----------------->
<title>Punto de Venta</title>
</head>
<body>
<div class="login-form">
    <form>
        <img src="../../assets/img/logo.png" class="img-fluid" style="margin-bottom: 10px;">
        <div class="form-group">
        	<div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fa fa-user"></span>
                    </span>                    
                </div>
                <input type="text" class="form-control" id="user" placeholder="Usuario" required="required">
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" id="pwd" placeholder="Contraseña" required="required" onkeydown="checkKey(event)">
            </div>
        </div>        
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-block" onclick="login()">Ingresar</button>
        </div>
</div>
</body>
</html>