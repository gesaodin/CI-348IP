<!DOCTYPE html>
<html>
  <?php $this->load->view('inc/cabecera.php');?>
    <!-- Site wrapper -->
    <div class="wrapper">

      <?php $this->load->view('inc/top.php');?>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
       <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Actualizar
        <small>Beneficiario</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
        <li><a href="#">Beneficiario</a></li>
        <li class="active">Actualizar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

          <div class="box ">
            <div class="box-header with-border">
              <h3 class="box-title">Datos Basicos</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" onclick="principal()" title="Cerrar"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <form class="form-horizontal" >
                <div class="box-body">
                  <div class="form-group">
                    <label class="col-md-2">Cédula</label>
                    <div class="col-md-6"> 

                      <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="consultar()"><i class="fa fa-search"></i></button>
                        </span> 
                        <input type="text" class="form-control" placeholder="Cédula de Identidad" id='id' onblur="consultar()"></input>                          
                      </div>                  
                      
                    </div>
                  </div> <!-- /Cedula -->
                  <div class="form-group">
                    <label class="col-md-2" >Cuenta</label>
                    <div class="col-md-6">                      
                      
                      <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success"><i class="fa fa-bank"></i></button>
                        </span> 
                        <input type="text" class="form-control" placeholder="Número de Cuenta" id="numero_cuenta" readonly="readonly"></input>                          
                      </div>  
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Nombres</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Nombre"  id='nombres' class="form-control" ></input>
                    </div> 
                    <label class="col-md-2">Apellidos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Apellido"  id='apellidos' class="form-control" ></input>
                    </div> 
                    <label class="col-md-2">Sexo</label>
                    <div class="col-md-2">                      
                     
                      <select class="form-control" id='sexo' style="width: 100%;">
                      </select>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Componente</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Componente"  id='componente' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Grado</label>
                    <div class="col-md-2">       

                      <select class="form-control" id='grado' style="width: 100%;">
                          
                      </select>
                    </div> 
                    <label class="col-md-2">Estatus</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Estatus"  id='estatus' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Fecha Ingreso</label>
                    <div class="col-md-2">                      
                      <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control" placeholder="Fecha de Ingreso" id='fingreso' data-provide="datepicker">
                      </div>                      
                    </div> 
                    <label class="col-md-2">Tiempo Servicio</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Tiempo servicio" id='tservicio' class="form-control" ></input>
                    </div> 
                    <label class="col-md-2">No. Hijos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Hijos" id='nhijos' class="form-control" ></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->


                  <div class="form-group">
                    <label class="col-md-2">Ultimo Ascenso</label>
                    <div class="col-md-2">
                      <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" placeholder="Ultimo Ascenso" id='fuascenso' class="form-control" data-provide="datepicker"></input>
                      </div>                         
                      
                    </div> 
                    <label class="col-md-2">No. Ascenso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Ascenso" id='noascenso' class="form-control" ></input>
                    </div> 
                    <label class="col-md-2">St. Prof.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="St. Prof" id='profesionalizacion' class="form-control" ></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Años Recon.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Ultimo Ascenso" id='arec' class="form-control" ></input>
                    </div> 
                    <label class="col-md-2">Meses Recon.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Ascenso" id='mrec' class="form-control" ></input>
                    </div> 
                    <label class="col-md-2">Días Recon.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Días Reconocidos" id='drec' class="form-control" ></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Fecha de Retiro</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Fecha de Retiro" id='fecha_retiro' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->


                </div>
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <a href="#!" onclick="actualizar()" 
              class="btn btn-primary pull-right" target="_top" id='btnActualizar'><i class="fa fa-refresh"></i>&nbsp;&nbsp;Actualizar</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->



    </section><!-- /.content -->

      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.6.7
        </div>
        <strong>Copyright &copy; 2015-2016 Instituto de Previsión Social.</strong> Todos los derechos.
      </footer>


    </div><!-- ./wrapper -->

    <?php $this->load->view('inc/pie.php');?>
    <script src="<?php echo base_url()?>application/modules/panel/views/js/actualizar.js"></script>
  </body>
</html>