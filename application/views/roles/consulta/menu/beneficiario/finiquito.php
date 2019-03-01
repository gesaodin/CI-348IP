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
                  Finiquitos
                  <small>.</small>
                </h1>
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Beneficiario</a></li>
                  <li><a href="#">Finiquitos</a></li>
                </ol>
              </section>

              <!-- Main content -->
              <section class="content">

                <!-- Default box -->
                <div class="box box  box-solid box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Consultar Finiquitos</h3>
                       <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove" onclick="principal()">
                        <i class="fa fa-times"></i></button>
                  </div>
                  </div>
                      <div class="box-body">                                                
                              <label class="col-md-2">Cedula de Identidad</label>
                              <div class="col-md-4">
                                  <input type="text" class="form-control" placeholder="Cedula de Identidad" id="cedulaB">
                                  
                              </div>
                              <div class="col-md-6">
                          <button type="button" class="btn btn-info pull-midium" onclick="consultarFiniquitos()"><i class="fa fa-search"></i>&nbsp;&nbsp;Consultar</button>
                          <a href="<?php echo base_url()?>index.php/panel/Panel/registrarFiniquito" class="btn btn-success pull-midium">
                          <i class="fa fa-plus"></i>&nbsp;&nbsp;Registrar Finiquito</a>
                          </a>
                              </div>
                              <br>
                    </div>
                  <!-- /.box-body -->
                  
                  <!-- /.box-footer-->
                </div>
                <!-- /.box -->

                <div class="box box-success">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detalles del Finiquito</h3>
                    <div class="box-tools pull-right">
                     
                    </div><!-- /.box-tools -->
                  </div><!-- /.box-header -->
                  <div class="box-body">
                    
                      
                         <br>
                        <label>Cédula de Identidad:&nbsp;</label><label id="lblCedula"></label><br>
                        <label>Beneficiario:&nbsp;</label><label id="lblBeneficiario"></label>
                        <br><br>

                          <table id="reporteFiniquitos" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                  <th style="width: 110px;">Acciones</th>
                                  <th>F. Creación</th>
                                  <!--<th>Cédula</th>
                                  <th>Benficiario</th>-->
                                  <th >Componente</th>
                                  <th>Grado</th>
                                  <th style="width: 70px;">T. Servicio</th>
                                  <th>Total (BsF.) </th>
                                  <th>F. Finiquito</th>
                                  <th>Motivo o Concepto</th>
                                  <th>Estatus </th>
                                  
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>

                          </table>

                  </div><!-- /.box-body -->
                </div><!-- /.box -->












                         

              </section>

        <!-- Main content -->

      </div><!-- /.content-wrapper -->


      <div class="modal fade" tabindex="-1" role="dialog" id="ModalImprimir">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Imprimir Reportes</h4>
            </div>
            <div class="modal-body">
              <center>
                <a class="btn btn-app btn-primary"><i class="fa fa-file"></i> Carta</a>
                <a class="btn btn-app btn-primary"><i class="fa fa-print"></i> Print</a>
                <a class="btn btn-app btn-primary"><i class="fa fa-inbox"></i> Orden</a>
                <br><br>
                <a class="btn btn-app btn-primary"><i class="fa fa-file"></i> Capital Banco</a>
                <a class="btn btn-app btn-primary"><i class="fa fa-print"></i> Diferencia A.</a>
                <a class="btn btn-app btn-primary"><i class="fa fa-inbox"></i> Muerte A/FS</a>
              </center>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
              
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.6.7
        </div>
        <strong>Copyright &copy; 2015-2016 Instituto de Previsión Social.</strong> Todos los derechos.
      </footer>

   
    </div><!-- ./wrapper -->

    <?php $this->load->view('inc/pie.php');?>
    <script src="<?php echo base_url()?>application/modules/panel/views/js/registrar_finiquito.js"></script>
  </body>
</html>