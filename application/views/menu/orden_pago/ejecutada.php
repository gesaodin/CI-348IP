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
        Ordenes de Pago 
        <small>Ejecutadas.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Orden de Pago </a></li>
        <li><a href="#">Ejecutadas</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Consultar listado de Ordenes Ejecutadas</h3>
             <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"  onclick="principal()">
                  <i class="fa fa-times"></i></button>
            </div>            
            <div class="box-body">
                   <div class="col-md-2">
                      <label>Cédula de Identidad:</label>
                   </div>
                    <div class="col-md-6">
                        <div class="input-group">
                        
                        <input type="text" class="form-control" placeholder="Cédula de Identidad" id='id' onblur="consultar()"></input>
                        <input type="hidden" id='id_aux'></input>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="consultar()" id='btnConsultar'><i class="fa fa-search"></i></button>
                        </span>                        
                      </div> 
                        
                    </div>
                    <div class="col-md-6">
                
                      

                    </div>
                    <br>
          </div>
          </div>
        <!-- /.box-body -->
        <div class="box-footer">
         <!-- /.box-header -->
            <div class="box-body">
                <table id="reporteOrdenes" class="table table-bordered table-hover">
                    <thead>
                    <tr> 
                        <th style="width: 40px">Acciones</th>              
                        <th>Cédula</th>
                        <th>Benficiario</th>                                    
                        <th>Fecha</th>
                        <th>Monto (Bs.) </th>
                        <th style="width: 200px">Motivo</th>
                    </tr>
                    </thead>
                    <tbody>

                </table>
            </div>
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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/ejecutadas.js"></script>
  </body>
</html>