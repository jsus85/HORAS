<?php 
$hora      = mysql_fetch_assoc(mysql_query("SELECT substring( DATE_sub(now(), INTERVAL 0 HOUR) , 11 ,6) as hora"));
setlocale(LC_ALL,"es_ES");

?>

                <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">

                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </button>

                 <a class="navbar-brand" href="panel.php" style="padding:0;">

                    <div style="background:#006bb3;padding:10px 10px 10px 45px;margin-top:13px;"><img src="assets/img/mundo.png" alt="" /> <span style="color:#ffffff;font-size:30px;vertical-align:middle;">Intranet</span></div>

                </a>

            </div>

            <!-- end navbar-header -->

            <!-- navbar-top-links -->
            <div style="float:right;width:600px;background:#ffffff
            ;height:60px;margin:10px 0;padding:10px;">

            <div style="width:238px;float:left;margin-left:10px;">
                <p style="font-weight:bold;color:#00326b;font-size:24px;margin-bottom:2px;line-height:18px;"><?php echo $hora['hora'];?></p>
                <p style="color:#00326b;font-size:14px;"><?php echo utf8_encode(strftime("%A %d de %B del %Y"));?></p>

            </div>


            <div style="float:left;margin-left:7px">
                <a href="panel.php"><img src="images/logo1.png"></a>
            </div>





            <div>

            <ul class="nav navbar-top-links navbar-right">

                <!-- main dropdown -->

                

<!--

                <li class="dropdown">

                <a class="dropdown-toggle" id="barMenuUser" data-toggle="dropdown" href="#">

                        <span class="top-label label label-success">Ocultar</span>  <i class="fa fa-tasks fa-3x"></i>

                    </a>

               

                </li>

-->

                <li class="dropdown">

                    <a class="dropdown-toggle"  title="Salir" data-toggle="dropdown" href="#" style="padding:5px;color:#00326b;">

                        <i class="fa fa-user fa-3x"></i>

                    </a>

                    <!-- dropdown user-->

                    <ul class="dropdown-menu dropdown-user">

                       

                        <li><a href="salir.php"><i class="fa fa-sign-out fa-fw"></i>Salir</a>

                        </li>

                    </ul>

                    <!-- end dropdown-user -->

                </li>

                <!-- end main dropdown -->

            </ul>


             </div> 
             </div>    
            <!-- end navbar-top-links -->



        </nav>



<script type="text/javascript">





var valorBarMenuLeft = $.cookie('opcion');

var opc = 0;

$("#barMenuUser").click(function(){



    $('.navbar-static-side').fadeToggle();

    $("#page-wrapper").css("margin","0");

    

    $.cookie('opcion','hide');

    if (valorBarMenuLeft=='hide') {

        $.cookie('opcion','show');

        $("#page-wrapper").css("margin","0 0 0 250px");

        

    };



});





$( document ).ready(function() {

  // Handler for .ready() called.

  if(valorBarMenuLeft=='show'){

    //$('#barLeft').show();

  }else if(valorBarMenuLeft=='hide'){

    //$('#barLeft').hide();

  }

});

        </script>