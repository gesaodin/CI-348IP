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
        Reclamos
        <small>Gestionar reclamos.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Reclammos</a></li>
        <li><a href="#">Gestionar reclamos</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Reclamos</h3>
             <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
        </div>
        
            <div class="box-body">
             <p><b>Consultar Reclamos</b></p>
                    <div class="col-md-2">
                        C.I:
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Cedula de Identidad">
                        
                    </div>
                   
                  <div class="col-md-62">
                    
                  </div>
                 
                  <br><br>
                  <div class="col-md-2">
                        Nombre:
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Nombre">
                        
                    </div>
                    <div class="col-md-2">
                        Apellido:
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Apellido">
                        
                    </div>
                  <!-- /.input group -->
                </div>
                    <br>
          </div>


          <div class="box-footer">
               <div class="row no-print">
                <div class="col-xs-12">
                  <center><button type="button" class="btn btn-danger" style="margin-right: 5px;">
                    <i class="fa fa-remove"></i> Cacelar
                  </button></center>
                </div>
              </div>
            </div>
            <!-- /.box-footer-->
        <!-- /.box-body -->
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
  </body>
</html>