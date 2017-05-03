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
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet">

    <script src="<?php echo base_url();?>assets/js/chart-master/Chart.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <?php $this->load->view('include/header.php');?>
      <!--header end-->
      

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <?php $this->load->view('include/left.php');?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
                  <div class="col-lg-9 main-chart">
                    

       
                        <table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i> Empleados</h4>
                            <hr>
                                <button type="button" onclick="window.location='<?php echo base_url('index.php/empleados/add');?>'" class="btn btn-primary">Nuevo</button>
                             
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Nombres</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Email</th>
                                  <th><i class="fa fa-bookmark"></i> Tipo</th>
                                  <th><i class=" fa fa-edit"></i> Estado</th>
                                  <th></th>
                              </tr>
                              </thead>
                              
                              <tbody>
                              <?php 
                                foreach ($emplados_list as $value) {
                              ?>
                              <tr>
                                  <td><a href="<?php echo site_url().'index.php/empleados/edit/'.$value->id;?>"><?php echo $value->nombres;?></a></td>
                                  <td class="hidden-phone"><?php echo $value->email;?></td>
                                  
                                    <td><?php echo ($value->tipo==1)?'Administrador':'Empleado';?></td>


                                  <td id="<?php echo $value->id;?>"><span class="label label-info label-<?php echo ($value->estado==1)?'mini':'warning'?>"><?php echo ($value->estado==1)?'Activo':'Inactivo'?></span></td>
                                  <td>
                                      <button title="Cambiar Estado" onclick="window.location='<?php echo site_url().'index.php/empleados/state/'.$value->id;?>'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>

                                      <button title="Editar Empleado" onclick="window.location='<?php echo site_url().'index.php/empleados/edit/'.$value->id;?>'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>

                                      <button title="Eliminar Empleado" onclick="if(confirm('desea eliminar '))window.location='<?php echo site_url().'index.php/empleados/delete/'.$value->id;?>'" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                  </td>
                               </tr>
                              <?php    }?>
                              </tbody>
                          </table>       
					 
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->                   
              </div><! --/row -->
              
          </section>
      </section>

      <!--main content end-->
      <!--footer start-->
       <?php $this->load->view('include/footer.php');?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="<?php echo base_url();?>assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/gritter-conf.js"></script>

	
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  

  </body>
</html>
