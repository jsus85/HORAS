<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex" />

	<meta name="googlebot" content="noindex">

    <title>PACIFIC LATAM - Reporte Horas</title>



    <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">

    <!--external css-->

    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

        

    <!-- Custom styles for this template -->

    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->

  </head>



  <body>



      <!-- **********************************************************************************************************************************************************

      MAIN CONTENT

      *********************************************************************************************************************************************************** -->



	  <div id="login-page">

	  	<div class="container">

	  	

	<?php

            $attributes = array('class' => 'form-login','method'=>'post');

            echo form_open('index.php/login/validar', $attributes);

?>

 



		        <h2 class="form-login-heading">Iniciar Sesión</h2>

		        <div class="login-wrap">

		            <input type="text" id="email" name="email" class="form-control" placeholder="E-mail" autofocus  />

		            <br>

		            <input type="password" id="password" name="password" class="form-control" placeholder="Password" >

		            <label class="checkbox">

		                <span class="pull-right">

		                    <!--<a data-toggle="modal" href="login.html#myModal"> Recuperar Contraseña?</a>		-->

		                </span>

		            </label>

		             <?php

						if(isset($message_error) && $message_error){

							echo '<div class="alert alert-error">';

							echo '<a class="close" data-dismiss="alert">×</a>';

							echo '<strong>Error!</strong> Email y Contraseña incorrecto.';

							echo '</div>';             

						}

?> 

		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> ENVIAR</button>

		            <hr>

		            

		            <!--

		            <div class="login-social-link centered">

		            <p>or you can sign in via your social network</p>

		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>

		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>

		            </div>



		            <div class="registration">

		                Don't have an account yet?<br/>

		                <a class="" href="#">

		                    Create an account

		                </a>

		            </div>

					-->	

		        </div>

		

		          <!-- Modal -->

		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">

		              <div class="modal-dialog">

		                  <div class="modal-content">

		                      <div class="modal-header">

		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		                          <h4 class="modal-title">Forgot Password ?</h4>

		                      </div>

		                      <div class="modal-body">

		                          <p>Enter your e-mail address below to reset your password.</p>

		                          <input type="text" name="recoveryEmail" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

		

		                      </div>

		                      <div class="modal-footer">

		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>

		                          <button class="btn btn-theme" type="button">Submit</button>

		                      </div>

		                  </div>

		              </div>

		          </div>

		          <!-- modal -->

		

		      </form>	  	

	  	

	  	</div>

	  </div>



    <!-- js placed at the end of the document so the pages load faster -->

    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>

    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>



    <!--BACKSTRETCH-->

    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.backstretch.min.js"></script>

    <script>

        $.backstretch("<?php echo base_url();?>assets/img/login-bg.jpg", {speed: 500});

    </script>





  </body>

</html>

