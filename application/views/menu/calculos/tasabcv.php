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

               <!-- /.box -->

            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Historial de los Intereses</h3>
                <div class="box-tools pull-right">
                 
                </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  <div class="form-group">
                    
                    <div class="col-md-4"> 
                      <label>Monto</label>                   
                      <input type="text" placeholder="Monto del Interes"  id='nombres' class="form-control" />
                    </div> 
                    
                    <div class="col-md-4">
                      <label>Fecha</label>
                      <div class="input-group date ">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>                  
                        <input type="text" placeholder="Fecha del Interes" id="datepicker" class="form-control" data-provide="datepicker"/>
                         
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-success" onclick="consultar()"><i class="fa fa-plus"></i> Agregar</button>
                          </span> 
                        </div>
                    </div> 
                    
                  </div>
                  <br><br><br>
                  <div class="form-group">                                      
                      <table id="reportetasa" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                              <th style="width: 11px;">#</th>                                  
                              <th >Interes</th>
                              <th>Fecha</th>
                              <th>F. Creación</th>                              
                          </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i = 0;
                              foreach ($Tasa as $c => $v) {
                                $i++;
                                echo '<tr><td>' . $i . '</td><td>' . $v["interes"] . 
                                '</td><td>' . $v["f_tasa"] . '</td><td>' . $v["f_creacion"] . '</td></tr>';
                              }
                            ?>
                          </tbody>

                      </table>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
    

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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/tasabcv.js"></script>
  </body>
</html>








