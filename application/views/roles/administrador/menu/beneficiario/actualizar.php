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
            Hoja de Vida
            <small>Panel principal de SPACE</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
            
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box ">
            <div class="box-header with-border">
              <h3 class="box-title">Datos Basicos</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <form class="form-horizontal" >
                <div class="box-body">
                  <div class="form-group">
                    <label class="col-md-2">C.I.</label>
                    <div class="col-md-8">                      
                      <input type="text" placeholder="Cédula de Identidad" id='id' onblur="consultar()"></input>
                    </div>
                  </div> <!-- /Cedula -->
                  <div class="form-group">
                    <label class="col-md-2">Cuenta</label>
                    <div class="col-md-8">                      
                      <input type="text" placeholder="Número de Cuenta"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Nombre</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Nombre"  id='nombres'></input>
                    </div> 
                    <label class="col-md-2">Apellido</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Apellido"  id='apellidos'></input>
                    </div> 
                    <label class="col-md-2">Sexo</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Sexo"  id='sexo'></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Componente</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Componente"  id='componente'></input>
                    </div> 
                    <label class="col-md-2">Grado</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Grado"  id='grado'></input>
                    </div> 
                    <label class="col-md-2">Estatus</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Estatus"  id='estatus'></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Fecha Ingreso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Fecha de Ingreso" id='fingreso'></input>
                    </div> 
                    <label class="col-md-2">Tiempo Servicio</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Tiempo servicio" id='tservicio'></input>
                    </div> 
                    <label class="col-md-2">No. Hijos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Hijos" id='nhijos'></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->


                  <div class="form-group">
                    <label class="col-md-2">Ultimo Ascenso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Ultimo Ascenso" id='fuascenso'></input>
                    </div> 
                    <label class="col-md-2">No. Ascenso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Ascenso" id='noascenso'></input>
                    </div> 
                    <label class="col-md-2">St. Prof.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="St. Prof" id='profesionalizacion'></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Años Reconocidos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Ultimo Ascenso" id='arec'></input>
                    </div> 
                    <label class="col-md-2">Mes Reconocidos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Ascenso" id='mrec'></input>
                    </div> 
                    <label class="col-md-2">Días Reconocidos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Días Reconocidos" id='drec'></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->
                   <div class="form-group">
                  <label class="col-md-2">Fecha Reinc.</label>
                    <div class="col-md-8">                      
                      <input type="text" placeholder="Fecha Reinc." id='id' onblur="consultar()"></input>
                    </div>
                  </div> 
                  <hr><b>Datos de Asignación de Antiguedad</b></hr>
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="button" class="btn btn-success" value="Salvar"></input>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

          
          

          



        </section><!-- /.content -->
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