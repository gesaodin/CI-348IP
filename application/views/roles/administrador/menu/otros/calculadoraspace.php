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
        Blank page
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

     <!-- /.box -->
          <div class="row">
            <div class="col-md-3">
              
            </div>
            <!-- /.col -->

            <div class="col-md-6">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Calculadora SPACE</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                <div class="col-md-3">
                Datos de Servicio:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="Datos de Servicio">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                N° de Ascenso:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="N° de Ascenso">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                St Profesión:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="St Profesión">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                Número de Hijos:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="Número de Hijos">
                  </div>
                  <div class="col-md-12"></div>
                   <div class="col-md-3">
                    Grado:
                  </div>
                  <div class="col-md-4">
                    <select class="form-control select2" style="width: 100%;">
                      <option selected="selected">M.G/A/option>
                      <option>1</option>
                    </select>
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                    Fecha Ascenso:
                  </div>
                  <div class="col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" id="datepicker">
                    </div>
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                    Fecha Claculo:
                  </div>
                  <div class="col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" id="datepicker1">
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <div class="col-xs-12">
                  <center><button type="button" class="btn btn-success"><i class="fa fa-check"></i>Calcular
                  </button></center>
                </div>
                <div class="box-header with-border">
                  
                </div>
                </div>
                <div class="box-header with-border">
                  <h3 class="box-title">Resultados</h3>
                </div>
                <div class="box-body no-padding">
                <div class="col-md-3">
                Sueldo Basico:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="Sueldo Basico">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                Total Primas:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="Total Primas">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                Sueldo Global:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="Sueldo Global">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                A. Bono Vac.:</div>
                <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="Número de Hijos">
                  </div>
                  <div class="col-md-12"></div>
                   <div class="col-md-3">
                    A. Fin de Año:
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="A. Fin de Año">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                    Sueldo Integral:
                  </div>
                  <div class="col-md-4">
                      <input type="text" class="form-control" placeholder="Sueldo Integral">
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-3">
                    Asig. Antiguedad:
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Sueldo Integral">
                  </div>
                </div>
                <!-- /.box-footer -->
                <div class="box-footer text-center">
                  <div class="col-xs-12">
                  <center><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i>Cerrar
                  </button></center>
                </div>
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
              
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!--Resultados-->


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