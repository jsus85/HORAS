<ul class="nav" id="side-menu">

                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="cuablanco">
                                <div class="user-section-inner">
                                    <img src="assets/img/user.jpg" alt="">
                                </div>
                                <div class="user-info">
                                    <div><span class="bien">Bienvenidos!</span><br><?php echo utf8_encode($_SESSION['sNOMBRES']);?><br ><a href="salir.php"><span class="bien">Salir</span></a></div>
                                </div>
                            </div>    
                        </div>
                        <!--end user image section-->

                    </li>

                    <li class="sidebar-search">

                        <!-- search section-->

                        <div class="input-group custom-search-form">

                            <input type="text" class="form-control" placeholder="Search...">

                            <span class="input-group-btn">

                                <button class="btn btn-default" type="button">

                                    <i class="fa fa-search"></i>

                                </button>

                            </span>

                        </div>

                        <!--end search section-->

                    </li>



                    <?php


                          
                               $listMenus =  $model->listarTablaGeneral("*","menus"," where id in (".$_SESSION['sAtributos'] .") "); 
                                    $extraer_menus = $porciones = explode(",", $_SESSION['sAtributos']);

                                        
                                ?>
                            
                    <li>
                        <a href="#"><img src="images/mant.png"> Mantenimientos<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">
                            <?php 
                                  for($i=0;$i<count($listMenus);$i++){
                            ?>
                            <li class="<?php echo (basename($listMenus[$i]['url'])==$listMenus[$i]['url'])?'selected':'mant';?>">
                                <a href="<?php echo $listMenus[$i]['url'];?>"><?php echo utf8_encode($listMenus[$i]['nombres']);?></a>
                            </li>
                            <?php } ?>    

                        </ul>
                        <!-- second-level-items -->
                    </li>

                    <?php if(in_array(8, $extraer_menus)){?>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) =='actividades.php')?'selected':'mant';?>">
                        <a href="actividades.php"><img src="images/peri.png"> Periodista</a>
                    </li>
                    <?php }?>

                    <?php if(in_array(11, $extraer_menus)){?>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) =='listas.php')?'selected':'mant';?>">
                        <a href="listas.php"><img src="images/peri.png"> Listas</a>
                    </li>
                    <?php }?>

                    <?php if(in_array(12, $extraer_menus)){?>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) =='boletines.php')?'selected':'mant';?>">
                        <a href="boletines.php"><img src="images/peri.png"> Difusiones</a>
                    </li>
                    <?php }?>

                    <?php if(in_array(15, $extraer_menus)){?>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) =='seguimientos.php')?'selected':'mant';?>">
                        <a href="seguimientos.php"><img src="images/peri.png"> Seguimientos</a>
                    </li>
                    <?php }?>

                      <li class="<?php echo (basename($_SERVER['PHP_SELF']) =='reporte.php')?'selected':'mant';?>">
                        <a href="reporte.php"><img src="images/peri.png"> Reporte</a>
                    </li>

                    <li >
                        <a href="http://prensapacific.com/Manual-Usuario-Pacific.pdf" target="_blank"><img src="images/mant.png"> Manual de Usuario</a>
                    </li>



                    <!--<li class="<?php echo (basename($_SERVER['PHP_SELF']) =='actividades.php')?'selected':'mant';?>">
                        <a href="actividades.php"><img src="images/acti.png"> Actividades</a>
                    </li>-->

                 

                </ul>