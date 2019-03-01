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
                Consultar Movimiento
                <small>.</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beneficiario</a></li>
                <li><a href="#">Consultar Movimiento</a></li>
                
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Relacion de Sueldos</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove" onclick="principal()">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <p><b>Datos a consultar</b></p>
                    <div class="col-md-2">
                        C.I:
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Cédula de Identidad" readonly="readonly">
                    </div>
                    <div class="col-md-2">
                    Movimiento:
                  </div>
                  <div class="col-md-4">
                    <select class="form-control select2" style="width: 100%;" id="componente">
                      
                      <option value=1 selected>EJERCITO</option>
                      <option value=2>ARMADA</option>
                      <option value=3>AVIACION</option>
                      <option value=4>GUARDIA NACIONAL</option>
                    </select>
                  </div>
                  <br>
                    <!-- Date -->
                    <div class="form-group">
                        <div class="col-md-2">
                            Fecha de Inicio:
                        </div>
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="datepicker">
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                    <div class="form-group">
                        <div class="col-md-2">
                           Fecha fin:
                        </div>
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="datepicker1">
                            </div>
                        </div>
                        <!-- /.input group -->     
                    </div>

                    <!-- /.form group -->

                </div>
                 <center><p><b>"Si desea hacer la busqueda sin tomar en cuenta la cédula, deje este campo en blanco."</b></p></center>
                <!-- /.box-body -->
                <div class="box-footer">
                    <center>
                        <button type="button" class="btn btn-success pull-midium" onclick="consultar()"><i class="fa fa-search"></i>&nbsp;&nbsp;Consultar
                        </button>
                        <button type="button" class="btn btn-primary pull-midium" onclick="Imprimir()"><i class="fa fa-search"></i>&nbsp;&nbsp;Imprimir
                        </button>
                        <button type="button" class="btn btn-warning pull-midium" onclick="CartaFinanzas()"><i class="fa fa-search"></i>&nbsp;&nbsp;Carta a Finanzas
                        </button>
                    </center>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        <div class="box box-success">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detalles del Movimiento</h3>
                    <div class="box-tools pull-right">
                     
                    </div><!-- /.box-tools -->
                  </div><!-- /.box-header -->
                  <div class="box-body">
                    
                      
                         <br>
                        <label>Total: </label> <label id='lblMonto'></label>

                          <table id="reporteAnticipo" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                  <th style="width: 90px;">Nro</th>
                                  <th>Grado</th>
                                  <th >Nombres y Apellidos</th>
                                  <th>Cédula</th>
                                  <th style="width: 80px;">Monto</th>                                                          
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>

                          </table>

                  </div><!-- /.box-body -->
                </div><!-- /.box -->




        </section>
        <!-- /.content -->






      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.6.7
        </div>
        <strong>Copyright &copy; 2015-2016 Instituto de Previsión Social.</strong> Todos los derechos.
      </footer>

    </div><!-- ./wrapper -->

    <?php $this->load->view('inc/pie.php');?>
    <script src="<?php echo base_url()?>application/modules/panel/views/js/movimiento.js"></script>
  </body>
</html>