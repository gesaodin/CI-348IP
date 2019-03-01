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
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Intereses Semestrales
        <small>.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Calculos</a></li>
        <li><a href="#">Semestral</a></li>
      </ol>
    </section>

   <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Carga de Intereses Semestrales</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  
                  <div class="form-group">
                    <div class="col-md-2">
                      Fecha:
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
        
        

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
          <b>Seleccione Archivo</b>
          <div class="form-group">
            <label for="exampleInputFile">Archivo Intereses Semestrales:</label>
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>
              <span>Seleccione Archivo a subir...</span>
              <!-- The file input field used as target for the file upload widget -->
              <input id="fileupload" type="file" name="files[]" multiple>
            </span>
            <br>
            <br>
            <!-- The global progress bar -->
            <div id="progress" class="progress">
              <div class="progress-bar progress-bar-success"></div>
            </div>
            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>
          </div>
          <button type="button" class="btn btn-primary">Enviar</button>
          
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