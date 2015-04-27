<?php 
session_start();
include("model/functions.php");
include('controllers/login.process.php');
?>
<!DOCTYPE html><!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html>
<head>
  <meta charset="utf-8">
   <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet Pacific Latam</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Slider images-->
    <link rel="stylesheet" type="text/css" href="assets/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style1.css" />
    <script type="text/javascript" src="assets/scripts/modernizr.custom.86080.js"></script>
    <style type="text/css">
.panel-default {

  border-color: #ddd;

}
.panel {




  background-color: #fff;
}
.panel-default > .panel-heading{
    background: #FFF;
}
    </style>
    <?php $xajax->printJavascript("xajax/"); ?>
</head>

<body class="body-Login-back">
    <div class="container">
         <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin "></div>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading"><img src="images/logo.png"></div>
                    <div class="panel-body">
                        <form role="form" id="form_login" name="form_login">
                            <fieldset>
                                <div class="form-group">
                                    <img src="images/usua.png"><input class="form-control" placeholder="Usuario" id="usuario" name="usuario" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <img src="images/cont.png"><input class="form-control" onkeypress="if(event.keyCode == '13'){ xajax_clsLogin(xajax.getFormValues('form_login'));  }" placeholder="Contraseña" id="password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Recordar Contraseña
                                    </label>
                                </div>                         
                                <a onclick="xajax_clsLogin(xajax.getFormValues('form_login'));"  class="btn btn-lg btn-success btn-block">INICIAR</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="cb-slideshow">
        <li><span>Image 01</span></li>
        <li><span>Image 02</span></li>
        <li><span>Image 03</span></li>
    </ul>

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
</body>
</html>