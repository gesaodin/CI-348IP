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
        Sueldo Por Lote
        <small>.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Beneficiario</a></li>
        <li><a href="#">Datos Sueldo Lote</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Registrar Datos de Sueldo por Lote</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
        <p><b>Tipo de Carga</b></p>
          <div class="form-group">
                 <div class="col-xs-6">
                  <div class="radio pull-right">
                    <label>
                      <input type="radio"  name="optionsRadios" id="optionsRadios1" value="option1" checked >
                      Archivo Plano
                    </label>
                  </div>
                  </div>
                  <div class="col-xs-6">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                      Directiva de Sueldos
                    </label>
                  </div>
                  </div>
           </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <b>Seleccione Archivo</b>
          <div class="form-group">
                <label for="exampleInputFile">Archivo Nuevos Beneficiarios:</label>
                <input type="file" id="exampleInputFile">
              </div>
              <button type="button" class="btn btn-primary">Save changes</button>
              <label>
            <input type="checkbox"> Generar Reporte de Comparación con la directiva
          </label>
          <button type="button" class="btn btn-danger pull-right"><i class="fa fa-file-text"></i> Ver el Registro de Errores  
          </button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>

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