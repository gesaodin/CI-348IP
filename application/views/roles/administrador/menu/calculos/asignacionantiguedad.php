<!DOCTYPE html>
<html>
  <?php $this->load->view('inc/cabecera.php');?>
  
    <!-- Site wrapper -->
    <div class="wrapper">

      <?php $this->load->view('inc/top.php');?>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Asignación de Antiguedad
            <small>.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Calculos</a></li>
            <li><a href="#">Asignación de Antiguedad</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Calculo Asignación de Antiguedad</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                <p><b>Realizar calculo para</b></p>
                <div class="form-group">
                 <div class="col-xs-6">
                  <div class="radio pull-right">
                    <label>
                      <input type="radio"  name="optionsRadios" id="optionsRadios1" value="option1" checked >
                      Fideicomitentes Actuales
                    </label>
                  </div>
                  </div>
                  <div class="col-xs-6">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                      Estimación Externos
                    </label>
                  </div>
                  </div>
           </div>
                  <div class="col-md-2">
                   Grupo:
                 </div>
                 <div class="col-md-4">
                  <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Asg. de Antiguedad</option>
                    <option>1</option>
                  </select>
                </div>
                <div class="form-group">
                  <div class="col-md-2">
                    Grupo Excluidos:
                  </div>
                  <div class="col-md-4">
                    <select class="form-control select2" style="width: 100%;">
                      <option selected="selected">Todos</option>
                      <option>1</option>
                    </select>
                  </div>
                  <!-- /.input group -->
                </div>
                <br>

                <div class="form-group">
                  <div class="col-md-2">
                    Directiva Calculo:
                  </div>
                  <div class="col-md-4">
                    <select class="form-control select2" style="width: 100%;">
                      <option selected="selected">Todos</option>
                      <option>1</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2">
                      Fecha de Calculo:
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
                  <!-- /.input group -->
                  <div class="col-md-2">
                  Porcentaje (%):
                  </div>
                  <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="%">
                  </div>
                  <br>
                  <div class="form-group">
                    <div class="col-md-12">
                      <center><b>Observaciones:</b></center>
                      <textarea class="form-control" placeholder="Observacione" style="width: 100%"></textarea>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->


              </div>
              <!-- /.box-body -->
              <div class="box-footer">
              
               
<center>
                  <button type="button" class="btn btn-information"><i class="fa fa-print"></i> Previsualizar
                  </button>
               
                  <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Ejecutar</button>
                
                  <button type="button" class="btn btn-danger" style="margin-right: 5px;">
                    <i class="fa fa-remove"></i> Ver Registro de Errores
                  </button>
               
        </center>      
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