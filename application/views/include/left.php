<?php
  // administrador
 if($this->session->userdata('tipo')==1){?>
<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">              
              	  <p class="centered"><a href="<?php echo base_url('index.php/login/panel');?>"><img src="<?php echo base_url();?>assets/img/reloj-arena.jpg" class="img-circle" width="60"></a></p>

              	  <h5 class="centered"><?php echo $this->session->userdata('nombres');?></h5>
                  <li class="mt">
                      <a  <?php if(base_url(uri_string())==base_url('empleados')){?> class="active" <?php }?> href="<?php echo base_url('index.php/empleados');?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Empleados</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a <?php if(base_url(uri_string())==base_url('areas')){?> class="active" <?php }?> href="<?php echo base_url('index.php/areas');?>" ><i class="fa fa-desktop"></i><span>Areas</span></a>
                  </li>
                  <li class="sub-menu">
                      <a <?php if(base_url(uri_string())==base_url('clientes')){?> class="active" <?php }?> href="<?php echo base_url('index.php/clientes');?>" ><i class="fa fa-cogs"></i><span>Clientes</span></a>
                    </li>
                  <li class="sub-menu">
                      <a <?php if(base_url(uri_string())==base_url('tareasxarea')){?> class="active" <?php }?> href="<?php echo base_url('index.php/tareasxarea');?>" >
                          <i class="fa fa-book"></i>
                          <span>Tareas por Area</span>

                      </a>

                  </li>

                  <li class="sub-menu">

                      <a <?php if(base_url(uri_string())==base_url('tareasxempleado')){?> class="active" <?php }?> href="<?php echo base_url('index.php/tareasxempleado');?>" >

                          <i class="fa fa-tasks"></i>

                          <span>Tareas por Cliente</span>

                      </a>

                  </li>

                  

                  <li class="sub-menu">

                      <a <?php if(base_url(uri_string())==base_url('horas')){?> class="active" <?php }?> href="<?php echo base_url('index.php/horas');?>" >

                          <i class="fa fa-tasks"></i>

                          <span>Registro de Tareas</span>

                      </a>

                  </li>
                  <li class="sub-menu">
                      <a <?php if(base_url(uri_string())==base_url('reportes')){?> class="active" <?php }?> href="<?php echo base_url('index.php/reportes');?>" >
                          <i class="fa fa-tasks"></i>
                          <span>Reporte</span>
                      </a>
                  </li>
                  </ul>

              <!-- sidebar menu end-->

          </div>

      </aside>

      <?php }else{?>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">              
                  <p class="centered"><a href="<?php echo base_url('index.php/horas');?>"><img src="<?php echo base_url();?>assets/img/reloj-arena.jpg" class="img-circle" width="60"></a></p>

                  <h5 class="centered"><?php echo $this->session->userdata('nombres');?></h5>
          </div>

        </aside>
 <?php }?>
      

     
   
