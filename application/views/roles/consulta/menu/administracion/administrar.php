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
          Actualización de Contraseña
          <small>.</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
          <li><a href="#">Administrar</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Administración de Contraseñas</h3>
               <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" onclick="principal()" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
          </div>
          
              <div class="box-body">
              <br><br>
                      <div class="col-md-2">
                          Nueva Contraseña:
                      </div>
                      <div class="col-md-4">
                          <input type="password" class="form-control" placeholder="Contraseña" id="clave" >
                          
                      </div>
                      <div class="col-md-6">
                          <button type="button" class="btn btn-success" onclick="actualizarClave()">
                            <i class="fa fa-key"></i>&nbsp;&nbsp;Crear Contraseña
                          </button>
                          <button type="button" class="btn btn-danger" onclick="principal()">
                            <i class="fa fa-close"></i>&nbsp;&nbsp;Cancelar
                          </button>
                      </div>
                     
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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/administrar.js"></script>
  </body>
</html>