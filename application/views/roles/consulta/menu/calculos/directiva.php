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



 <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Directiva de Sueldo</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="col-md-2">
                   Número:
                 </div>
                 <div class="col-md-4">
                 <input type="text" class="form-control" placeholder="Número">
                </div>
                
                <div class="col-md-2">
                   Valor UT:
                 </div>
                 <div class="col-md-4">
                 <input type="text" class="form-control" placeholder="Número">
                </div>
<br><br>
                <div class="form-group">
                    <div class="col-md-2">
                      Fecha:
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
               

               
                  <div class="form-group">
                    <div class="col-md-2">
                      Vigencia:
                    </div>
                    <div class="col-md-4">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="datepicker1">
                      </div>       <!-- /.input group -->
                  </div>
                  <!-- /.input group -->
               </div>

                </div>
<br>               <br><br>
                <!-- /.form group -->
                <div class="form-group">
                  <div class="col-md-2">
                    Tipo de Directiva:
                  </div>
                  <div class="col-md-4">
                    <select class="form-control select2" style="width: 100%;">
                      <option selected="selected">Estimación</option>
                      <option>1</option>
                    </select>
                  </div>
                  <!-- /.input group -->
                  <div class="col-md-6">
                     <button type="button" class="btn btn-success"><i class="fa fa-file-text-o"></i> Detalle Directiva
                  </button>
                  </div>
                  <div class="col-md-12">
                     <b>Agregar desde Archivos</b><br>
                     <button type="button" class="btn btn-success"><i class="fa fa-file-text-o"></i> Detalle Directiva(Archivo)
                  </button>
                  <button type="button" class="btn btn-success"><i class="fa fa-file-text-o"></i> Primas Directiva(Archivo)
                  </button>
                </div>
              </div>


              </div>
             
              <!-- /.box-body -->
              <div class="box-footer">
               <div class="row no-print">
                <div class="col-xs-6">

                  <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Aceptar
                  </button>
                </div>
                <div class="col-xs-6">
                  <button type="button" class="btn btn-danger" style="margin-right: 5px;">
                    <i class="fa fa-remove"></i> Cancelar
                  </button>
                </div>
              </div>
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->


          <!-- /.box -->
        </div>
      </div>

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
  </body>
</html>








