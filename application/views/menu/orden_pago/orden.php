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
        <small>Pendientes.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Orden de Pago</a></li>
        <li><a href="#">Pendientes</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Consultar listado de Ordenes</h3>
             <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove" onclick="principal()">
                  <i class="fa fa-times"></i></button>
            </div>            
            <div class="box-body">
                   <div class="col-md-2">
                      <label>Cédula de Identidad:</label>
                   </div>
                    <div class="col-md-6">
                        <div class="input-group">
                        
                        <input type="text" class="form-control" placeholder="Cédula de Identidad" id='id' onblur="consultar()"></input>
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


      <!-- Modal -->
                    <div div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="frmOrden" >
                      <div class="modal-dialog modal-lg" role="document">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Ejecutar Anticipos</h4>
                          </div>
                          <div class="modal-body">
                           
                            
                            <br>
                            <div class="row">
                              <div class="col-xs-2">
                                <label>Cédula</label>
                              </div>
                              <div class="col-xs-10">
                                <input type="text" class="form-control" id='cedula' readonly="readonly" />                                
                                <input type="hidden" id='oid' />
                              </div>                             
                            </div>


                            

                            <br>
                            <div class="row">
                               <div class="col-xs-2">
                                <label>Nombres</label>
                              </div>
                              <div class="col-xs-4">
                                <input type="text" class="form-control" id='nombres' readonly="readonly" />
                              </div>
                              <div class="col-xs-2">
                                <label>Apellidos</label>
                              </div>
                              <div class="col-xs-4">                                  
                                    <input type="text" class="form-control" 
                                    id='apellidos'  readonly="readonly"/>
                              </div> 
                            </div> <!-- ./row -->

                            <br>
                            <div class="row">
                               <div class="col-xs-2">
                                <label>Componente</label>
                              </div>
                              <div class="col-xs-4">
                                <input type="text" class="form-control" id='componente' readonly="readonly" />
                              </div>
                              <div class="col-xs-2">
                                <label>Grado</label>
                              </div>
                              <div class="col-xs-4">                                  
                                    <input type="text" class="form-control" 
                                    id='grado'  readonly="readonly"/>
                              </div> 
                            </div> <!-- ./row -->

                           <br>
                            <div class="row">
                               <div class="col-xs-2">
                                <label>Fecha</label>
                              </div>
                              <div class="col-xs-4">
                                <input type="text" class="form-control" id='fecha' readonly="readonly" />
                              </div>
                              <div class="col-xs-2">
                                <label>Monto</label>
                              </div>
                              <div class="col-xs-4">                                  
                                    <input type="text" class="form-control" 
                                    id='monto'  readonly="readonly"/>
                              </div> 
                            </div> <!-- ./row -->

                            <br>
                            <div class="row">
                              <div class="col-xs-2">
                                <label>Emisor</label>
                              </div>
                              <div class="col-xs-10">
                                <input type="text" class="form-control" id='motivo' readonly="readonly"/>                                
                              </div>                             
                            </div> <!-- /.row -->

                            <br>
                            <div class="row">
                              <div class="col-xs-2">
                                <label>Emisor</label>
                              </div>
                              <div class="col-xs-10">
                                <input type="text" class="form-control" id='emisor'  />                                
                              </div>                             
                            </div> <!-- /.row -->

                            <br>
                            <div class="row">
                              <div class="col-xs-2">
                                <label>Revisión</label>
                              </div>
                              <div class="col-xs-10">
                                <input type="text" class="form-control" id='revision'  />                                
                              </div>                             
                            </div> <!-- /.row -->
                            <br>
                            <div class="row">
                              <div class="col-xs-2">
                                <label>Autoriza</label>
                              </div>
                              <div class="col-xs-10">
                                <input type="text" class="form-control" id='autoriza'  />                                
                              </div>                             
                            </div> <!-- /.row -->
                                                        
                          </div>
                          
                          <div class="box-footer">
                          <div class="col-xs-12">
                            <button type="button" class="btn btn-success pull-right" data-dismiss="modal" onclick="ejecutarAnticipo()">
                              <i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Aceptar
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" >
                              <i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Cancelar
                            </button>
                            
                            
                          </div>
                            
                          </div>
                        </div>
                        
                      </div>
                    </div>

      <!-- /.Modal -->

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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/orden.js"></script>
  </body>
</html>