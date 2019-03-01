        

        <ul class="sidebar-menu">
            <li class="header">NAVEGACIÓN PRINCIPAL</li>
            
             <li class="treeview">
              <a href="#">
                <i class="glyphicon glyphicon-book"></i>
                <span>Beneficiarios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/fideicomitente">
                  <i class="fa fa-credit-card"></i> Cargar Fedeicomitente</a>
                </li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/beneficiario"><i class="glyphicon glyphicon-user"></i> Consultar Beneficiario</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/actualizar"><i class="fa fa-edit"></i> Actualizar</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/reporte"><i class="fa fa-print"></i> Reporte</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/historialsueldo"><i class="fa fa-clock-o"></i> Historial</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/consultarmovimiento"><i class="fa fa-search"></i> Consultar Movimientos</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/anticipo"><i class="fa fa-calculator"></i> Anticipos</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/medidajudicial"><i class="fa fa-edit"></i> Medidas Judiciales</a></li>
                <?php
                  $cant  = count($_SESSION['roles']) -1;
                  for($i=0; $i<=$cant; $i++){
                    if($_SESSION['roles'][$i] == 27 || $_SESSION['roles'][$i] == 1){
                      echo '<li><a href="' . base_url() . 'index.php/panel/Panel/finiquitos"><i class="fa fa-credit-card"></i> Finiquitos</a></li>';    
                    }
                  }
                  
                ?>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/asociarcuenta"><i class="fa fa-bank"></i> Cuentas Bancarias</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/sueldolote"><i class="fa fa-bank"></i> Datos Sueldo Lote</a></li>

              </ul>
            </li>


            <li class="treeview">
              <a href="#">
                <i class="fa fa-legal"></i>
                <span>Ordenes de Pago</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/ordenpago"><i class="fa fa-edit"></i> Pendiente</a></li>
                <!-- <li><a href="../"><i class="fa fa-envelope-o"></i> Ordenes Pendientes</a></li> -->
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/ordenpagoejecutada"><i class="fa fa-envelope-square"></i> Ejecutadas</a></li>

              </ul>
            </li>

            <li>
              <a href="../widgets.html">
                <i class="fa fa-calculator"></i> <span>Calculos</span> <small class="label pull-right bg-green">Act</small>
                <ul class="treeview-menu">
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/aportecapital"><i class="fa fa-edit"></i> Aporte de Capital</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/interesescaidos"><i class="fa  fa-arrow-circle-down"></i> Pago de Intereses Caidos</a></li>

                <li><a href="<?php echo base_url()?>index.php/panel/Panel/asignacionantiguedad"><i class="fa fa-qrcode"></i> Cal. Asig. Antiguedad</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/calcinitereses"><i class="fa  fa-arrow-circle-down"></i> Calc. Intereses Caidos</a></li>
                <li><a href=""><i class="fa fa-subscript"></i> Tasas BCV</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/directiva"><i class="fa fa-chain"></i> Directivas</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/directivaactual"><i class="fa fa-copy"></i> Directiva Actual</a></li>

              </ul>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-university"></i>
                <span>Administración</span>
                <span class="label label-primary pull-right">4</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="../"><i class="fa fa-envelope-square"></i> Tablas del Sistema</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/administrar"><i class="fa fa-users"></i> Administrar Usuarios</a></li>
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/auditoria"><i class="fa fa-users"></i> Reporte de Auditoria</a></li>
              </ul>
            </li>


            <li class="treeview">
              <a href="#">
                <i class="fa fa-warning"></i>
                <span>Reclamos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/reclamos"><i class="fa fa-envelope-square"></i> Gestionar Reclamos</a></li>

              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-warning"></i>
                <span>Otros</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()?>index.php/panel/Panel/calculadoraspace"><i class="fa fa-envelope-square"></i> Calculadora SPACE</a></li>
              </ul>
            </li>
            
           
           
       
            
            <li><a href="../../documentation/index.html"><i class="fa fa-book"></i> <span>Documentación</span></a></li>
            
          </ul>

          