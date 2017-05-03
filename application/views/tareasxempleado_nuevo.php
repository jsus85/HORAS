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
                    
                  <h4><i class="fa fa-angle-right"></i> Registrar Tareas</h4>
                   <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> Tareas</h4>
                      <form class="form-horizontal style-form" method="post" action="<?php echo base_url('index.php/tareasxempleado/add/'.$this->uri->segment(3));?>">
                 


                       <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Tareas asignadas</label>
                              <div class="col-sm-10">
                                  <select id="tarea" name="tarea"  class="form-control">
                                      <option value="0">[Seleccionar]</option>                                    
                                      <?php foreach ($tareas_list as $value) {?>
                                      <option <?php if(set_value('tarea')==$value->id){echo "selected";}?> value="<?php echo $value->id;?>"><?php echo $value->nombres;?></option>
                                      <?php }?>                                  
                                  </select>
                                  <span class="help-block">Seleccione la tarea por favor.</span>
                              </div>
                            </div> 




                       <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Clientes</label>
                              <div class="col-sm-10">
                                  <select id="cliente" name="cliente"  class="form-control">
                                      <option value="0">[Seleccionar Cliente]</option>                                    
                                      <?php foreach ($clientes_list as $value) {?>
                                      <option <?php if(set_value('cliente')==$value->id){echo "selected";}?> value="<?php echo $value->id;?>"><?php echo $value->nombres;?></option>
                                      <?php }?>                                  
                                  </select>
                                  <span class="help-block">Seleccione el cliente por favor.</span>
                              </div>
                            </div> 

                                        
                    
                      <?php 
                            if (validation_errors()): 
                            echo '<div class="alert alert-success">';
                            echo '<a class="close" data-dismiss="alert">×</a>';
                            ?>
                            <div class="alert alert-error">
                            <?php echo validation_errors(); ?>
                            </div>
                            <?php 

                            echo '</div>';
                            endif; 
                        ?>

                          
                           <button type="submit" class="btn btn-primary">Agregar</button>
                           <button type="button" onclick="window.location='<?php echo base_url('index.php/tareasxempleado');?>'"  class="btn btn-primary">Cancelar</button>      


                                           
                         <table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i> Tareas Asignadas</h4>
                            <hr>
                            <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Cliente</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Tarea</th>

                                  <th></th>
                              </tr>
                              </thead>
                              
                              <tbody>
                              <?php 
                                foreach ($tareasxempleado_list as $value) {
                              ?>
                              <tr>

                                  <td><?php echo $value->nombrecliente;?></td>
                                  <td class="hidden-phone"><?php echo $value->nombretarea;?></td>
                                  <td>
                                    <a onclick="willSubmit=confirm('¿Esta seguro de eliminar este registro?'); return willSubmit;" href="<?php echo site_url().'index.php/tareasxempleado/delete/'.$value->id.'/'.$this->uri->segment(3);?>"  class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>


                                  </td>
                               </tr>
                              <?php    }?>
                              </tbody>
                          </table>  







                      </form>
                  </div>

                   
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
