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

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Directiva de Sueldo</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="col-md-12">
                    <label>Seleccionar Directivas:</label>
                        <select class="form-control select2" style="width: 100%;" id="directiva">
                          <option value="0" selected>SELECCIONAR UNA DIRECTIVA PARA INICIAR PROCESO</option>
                          <?php

                            foreach ($lst as $c => $v) {
                              echo '<option value="' . $v->id . '">' . $v->nombre . '</option>';
                            }
                          ?>

                        </select>
                    
                  </div>

                  
                  



              </div>
             
              <!-- /.box-body -->
              <div class="box-footer">
               <div class="row no-print">
                <div class="col-xs-12">

                  <button type="button" class="btn btn-success" onclick="ConsultarID()"><i class="fa fa-search"></i> Consultar
                  </button>
                  <button type="button" class="btn btn-primary" onclick="ClonarShow()"><i class="fa fa-copy"></i> Clonar 
                  </button>
                  <button type="button" class="btn btn-danger" onclick="EliminarShow()"><i class="fa fa-remove"></i> Eliminar
                  </button>
                
                  <button type="button" class="btn btn-danger pull-right" style="margin-right: 5px;">
                    <i class="fa fa-remove"></i> Cancelar
                  </button>
                </div>
              </div>
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->


                <div class="box box-success">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detalles</h3>
                    <div class="box-tools pull-right">
                     
                    </div><!-- /.box-tools -->
                  </div><!-- /.box-header -->
                  <div class="box-body">
                      <!-- Date -->
                          <div class="form-group">
                              
                              <div class="col-md-6">
                                <label>Fecha de Vigencia:</label>
                                  <div class="input-group date">
                                      <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control" id="f_ini" disabled>
                                  </div>
                              </div>
                                                         
                              <div class="col-md-6">
                                <label>Fecha de Inicio:</label>
                                  <div class="input-group date">
                                      <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control" id="f_ven" disabled>
                                  </div>
                              </div>
                              <!-- /.input group -->
                          </div><br><br><br>  
                          <table id="reportedirectiva" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                  <th style="width: 30px;">ID</th>
                                  <th >GRADO</th>
                                  <th>ANTIGUEDAD</th>
                                  <th>SUELDO BASE</th>                                  
                                  <th>UNIDAD TRIBUTARIA</th>                                  
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>

                          </table>

                  </div><!-- /.box-body -->
                </div><!-- /.box -->


  







    </section>
    <!-- /.content -->




                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="DivEditor" >
                      <div class="modal-dialog modal-sm" role="document">                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Actualizar Directiva</h4>
                          </div>
                          <div class="modal-body">                           
                            <div class="row">
                              <div class="col-xs-6">
                                <label>Grado</label>
                                <input type="text" class="form-control" placeholder="Grado" id='grado' readonly="readonly"/>
                                <input type="hidden" id='codigo'/>
                              </div>
                              <div class="col-xs-6">
                                <label>Antiguedad</label>
                                <input type="text" class="form-control" placeholder="Antigudad" id='anio' readonly="readonly" />
                                <input type="hidden" id='capital_banco_aux' />
                              </div>
                                                       
                            </div>
                            <br>
                            <div class="row">
                                
                              
                              <div class="col-xs-6">
                                  <label>Unidad Tributaria</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Unidad Tributaria" id='unidad' /> 
                                  </div>                                
                              </div> 
                              <div class="col-xs-6">
                                <label>Monto Sueldo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Sueldo" id='sueldo' />
                                     
                                </div>
                              </div> 
                            </div>


                            
                          </div>
                          
                          <div class="box-footer">
                          <div class="col-xs-12">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="Actualizar()"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Actualizar
                            </button>
                            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" onclick="Cancelar()"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Cancelar
                            </button>
                          </div>                            
                          </div>
                        </div>
                        
                      </div>
                    </div>

      <!-- Clonar -->

       <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="DivClone" >
          <div class="modal-dialog modal-sm" role="document">                      
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Clonar Directiva</h4>
              </div>
              <div class="modal-body">                           
                
                <div class="row">
                    
                  <div class="form-group">
                    <div class="col-md-12">
                        <label>Nombre Directiva</label>
                          <input type="text" class="form-control" placeholder="Nombre Directiva" id='nombre'/> 
                    </div> 
                    <div class="col-md-12">
                        <label>Número de Directiva</label>                        
                          <input type="text" class="form-control" placeholder="Número de Directiva" id='observacion'/> 
                    </div> 
                    <div class="col-md-12">
                        <label>Motivo</label>                        
                        
                          <input type="text" class="form-control" placeholder="Motivo Directiva" id='motivo'/> 
                                                      
                    </div> 
                    <div class="col-md-12">
                      <label>Fecha de Inicio:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="datepicker2" >
                        </div>
                    </div>

                    <div class="col-md-12">
                    <label>Fecha de Vigencia:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="datepicker1" >
                        </div>
                    </div>
                                               
                    

                    <div class="col-md-6">
                        <label>Unidad Tributaria</label>                        
                        
                          <input type="text" class="form-control" placeholder="U.T" id='unidad_tributaria'/> 
                                                      
                    </div>
                    <div class="col-md-6">
                        <label>% Aumento</label>                        
                        
                          <input type="text" class="form-control" placeholder="Pocentaje" id='porcentaje'/> 
                                                      
                    </div>  
                    <!-- /.input group -->
                </div>
                                           
                </div>
                <br>


                
              </div>
              
              <div class="box-footer">
              <div class="col-xs-12">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="Clonar()"><i class="fa fa-copy"></i>&nbsp;&nbsp;Clonar
                </button>
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" onclick="Cancelar()"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Cancelar
                </button>
                
                
              </div>
                
              </div>
            </div>
            
          </div>
        </div>




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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/directiva.js"></script>
  </body>
</html>








