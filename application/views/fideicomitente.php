
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
                Beneficiarios
                <small>Carga de fideicomientes</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Beneficiarios</a></li>
                <li><a href="#">Carga de fideicomientes</a></li>
                <!--<li class="active">Blank page</li>-->
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Carga de fideicomientes</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <b><p>Seleccione archivos</p></b>


                        <div class="col-md-4">
                      Tipo de Archivo:
                            </div>
                        <div class="col-md-4">
                             <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                      Nuevos Fideicomitentes
                    </label>
                  </div>
                            </div>
                        <div class="col-md-4">
                        <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                      Actualización Fideicomitentes
                    </label>
                  </div>
                            </div>
<br><br>

                        <div class="col-md-4">
                            Tipo de Reporte:
                        </div>
                        <div class="col-md-4">
                            <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                     Reporte de Comparación SAMAN
                    </label>
                  </div>
                        </div>
                        <div class="col-md-4">
                             <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                     Reporte de Comparación PACE
                        </div>
                        <div class="col-md-12">
<form action="#" method="post">

              <div class="form-group">
                <label for="exampleInputFile">Archivo Nuevos Beneficiarios:</label>
                <input type="file" id="exampleInputFile">
              </div>

            <center></center><button type="button" class="btn btn-primary"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Cargar Archivos</button>

                 
          <button type="button" class="btn btn-danger pull-right"><i class="fa fa-file-text"></i>&nbsp;&nbsp;Ver Registro  
          </button>
          </form>
          </div>
                </div>
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


























