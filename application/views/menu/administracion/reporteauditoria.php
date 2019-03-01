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
          Reporte de Auditoria
          <small>.</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
          <li><a href="#">Auditoria</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Ordenes de Pago</h3>
               <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
          </div>
          
              <div class="box-body">
               <p><b>Generar Ordenes de Pago</b></p>
                      <div class="col-md-2">
                          C.I:
                      </div>
                      <div class="col-md-4">
                          <input type="text" class="form-control" placeholder="Cedula de Identidad" id="id" >
                          
                      </div>
                      <div class="form-group">
                    <div class="col-md-2">
                      Objeto:
                    </div>
                    <div class="col-md-4">
                      <select class="form-control select2" style="width: 100%;">
                        <option selected="selected">Beneficiario</option>
                        <option>1</option>
                      </select>
                    </div>
                    <!-- /.input group -->
                  </div>
                      <br>
            </div>
            </div>

            <div class="box-footer">
                 <div class="row no-print">
                  <div class="col-xs-6">

                    <button type="button" class="btn btn-success pull-right" onclick="Consultar()"><i class="fa fa-search"></i>&nbsp;&nbsp;Consultar
                    </button>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-primary" style="margin-right: 5px;">
                      <i class="fa fa-print"></i>&nbsp;&nbsp;Imprimir
                    </button>
                  </div>
                </div>
              </div>
              <!-- /.box-footer-->
          <!-- /.box-body -->
          <div class="box-footer">
           <!-- /.box-header -->
                          <div class="box-body">
                          <p><b>Situación Actual</b></p>
                              <table id="reporteAuditoria" class="table table-bordered table-hover">
                                  <thead>
                                  <tr>
                                      <th>Nombre</th>
                                      <th>Comp</th>
                                      <th>Grado</th>
                                      <th>F. de Ingreso</th>
                                      <th>St. No Asc</th>
                                      <th>Hijos</th>
                                      <Th>F. Ult. Asc.</Th>
                                      <th>Anios Rec.</th>
                                      <th>Meses Rec.</th>
                                      <th>Dias Rec.</th>
                                      <th>F. Ing Flde.</th>
                                      <th>Usuario C.</th>
                                      <th>Fecha C.</th>
                                      <th>Usuario M.</th>
                                      <th>Fecha M.</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                              </table>
                          </div>
          </div>
          <div class="box-footer">
           <!-- /.box-header -->
                          <div class="box-body">
                          <p><b>Historial detallado</b></p>
                              <table id="reporteAuditoriaDetalle" class="table table-bordered table-hover">
                                  <thead>
                                  <tr>
                                      <th>Nombre</th>
                                      <th>Comp</th>
                                      <th>Grado</th>
                                      <th>F. de Ingreso</th>
                                      <th>St. No Asc</th>
                                      <th>Hijos</th>
                                      <Th>F. Ult. Asc.</Th>
                                      <th>Anios Rec.</th>
                                      <th>Meses Rec.</th>
                                      <th>Dias Rec.</th>
                                      <th>F. Ing Flde.</th>
                                      <th>Usuario C.</th>
                                      <th>Fecha C.</th>
                                      <th>Usuario M.</th>
                                      <th>Fecha M.</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                              </table>
                          </div>
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
        <!-- Main content -->

      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.6.7
        </div>
        <strong>Copyright &copy; 2015-2016 Instituto de Previsión Social.</strong> Todos los derechos.
      </footer>

    </div><!-- ./wrapper -->

    <?php $this->load->view('inc/pie.php');?>
    <script src="<?php echo base_url()?>application/modules/panel/views/js/auditoria.js"></script>
  </body>
</html>