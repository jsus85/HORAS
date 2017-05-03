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
                    
                  <h4><i class="fa fa-angle-right"></i> Tareas x Áreas</h4>
                   <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> Editar Tarea</h4>
                      <form class="form-horizontal style-form" method="post" action="<?php echo base_url('index.php/tareasxarea/edit/'.$this->uri->segment(3));?>">
                 

                   <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Areas</label>
                              <div class="col-sm-10">
                                  <select id="area" name="area"  class="form-control">
                                      <option value="0">[Seleccionar]</option>                                    
                                      <?php foreach ($areas_list as $value) {?>
                                      <option <?php if($employer[0]['area_id']==$value->id){echo "selected";}?> value="<?php echo $value->id;?>"><?php echo $value->nombres;?></option>
                                      <?php }?>                                  
                                  </select>
                                  <span class="help-block">Seleccione el área por favor.</span>
                              </div>
                            </div>  


                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Nombres</label>
                              <div class="col-sm-10">
                                  <input type="text" id="nombres" name="nombres" value="<?php echo $employer[0]['nombres']; ?>" class="form-control" requerid />
                                  <span class="help-block">Ingrese el nombre de la tarea por favor.</span>
                              </div>
                          </div>

                             <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                              <div class="col-sm-10">
                                
                                  <textarea id="descripcion" name="descripcion" class="form-control"><?php echo $employer[0]['descripcion']; ?></textarea>

                                  <span class="help-block">Ingrese la descripción de la tarea por favor.</span>
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

                          
                           <button type="submit" class="btn btn-primary">Grabar</button>
                           <button type="button" onclick="window.location='<?php echo base_url('index.php/tareasxarea');?>'"  class="btn btn-primary">Cancelar</button>                        
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
