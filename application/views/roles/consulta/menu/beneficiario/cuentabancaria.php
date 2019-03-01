
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
        Cuenta Bancaria
        <small>.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
        <li><a href="#">Cuenta Bancaria</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Asociar Cuenta Bancaria</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
             <p><b>Datos Básicos</b></p>
                    <div class="col-md-2">
                        C.I:
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="consultar()"><i class="fa fa-search"></i></button>
                        </span> 
                        <input type="text" class="form-control" placeholder="Cédula de Identidad" id='id' onblur="consultar()"></input>                          
                      </div>                  
                    </div>
                    <br><br>
                    
                    
                    <div class="col-md-2">
                        Nombres:
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Nombre"  id='nombres' class="form-control" readonly="readonly"></input>               
                    </div>
                    <div class="col-md-2">
                        Apellidos:
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Apellido"  id='apellidos' class="form-control" readonly="readonly"></input>  
                    </div>           
                    <br><br>

                    <div class="col-md-2">
                        Componentes:
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Componente"  id='componente' class="form-control" readonly="readonly"></input>                
                    </div>
                    <div class="col-md-2">
                        Grado:
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Grado"  id='grado' class="form-control" readonly="readonly"></input>               
                    </div>
                    <hr>
                    <br><br>
                    <div class="col-md-2">
                        N° Cuenta:
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success"><i class="fa fa-bank"></i></button>
                        </span> 
                        <input type="text" class="form-control" placeholder="Número de Cuenta" id="numero_cuenta" maxlength="20"></input>                          
                      </div>                
                    </div>
                    <div class="col-md-6">
              
                    </div>
                    
                   
          </div>
        <div class="box-footer">
              <a href="#!" onclick="actualizar()" 
              class="btn btn-primary pull-right" target="_top" id='btnActualizar'><i class="fa fa-refresh"></i>&nbsp;&nbsp;Actualizar Cuenta</a>
            </div><!-- /.box-footer-->
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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/banco.js"></script>
  </body>
</html>