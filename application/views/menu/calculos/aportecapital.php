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
                    Calculos
                    <small>Aporte de Capital.</small>
                  </h1>
                  <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Calculos</a></li>
                    <li><a href="#">Aporte de Capital</a></li>
                  </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                  <!-- Default box -->
                  <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Aporte de capital</h3>

                      <div class="box-tools pull-right">
                        
                          <button type="button" onclick="principal()" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Salir">
                            <i class="fa fa-times"></i></button>
                          </div>
                        </div>
                        <div class="box-body">
                     
                          
                            
                          
                            <div class="col-md-4">
                              <label>Fecha:</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="datepicker">
                              </div>
                          </div>
                   

                          
                          <div class="col-md-4">
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

                          <div class="col-md-4">
                          <label>Seleccionar Situación:</label>
                          <select class="form-control select2" style="width: 100%;" id='situacion'>
                              <option value='201'>Activo</option>
                              <option value='203'>Finiquito</option>                              
                          </select>
                    </div>

                          <br><br> <br><hr>
                          <div class="form-group">
                            <div class="col-md-2">
                                Componentes:
                            </div>
                            <div class="col-md-4">
                                <select class="form-control select2" style="width: 100%;" onchange="cargarGrado()" id="componente">
                                    <option value='99'>Todos los componentes</option>
                                    <?php
                                    foreach ($componente as $k => $v) {
                                        echo '<option value=' . $v['id'] . '>' . $v['nomb'] . '</option>';                            
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                Grado:
                            </div>
                            <div class="col-md-4">
                                <select class="form-control select2" style="width: 100%;" id="grado">
                                    <option  value=99>Todos los grados</option>
                                </select>
                            </div>
                            <br><br>
                            </div>
                           
                          <!-- Date -->
                          <div class="form-group">
                              <div class="col-md-2">
                                  Desde:
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

                          <!-- /.form group -->
                          <div class="form-group">
                              <div class="col-md-2">
                               Hasta:
                              </div>
                              <div class="col-md-4">
                                  <div class="input-group date">
                                      <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control" id="datepicker2">
                                  </div>
                              </div>
                              <!-- /.input group -->
                          </div>
                          <!-- /.form group -->

                          <br><br>
                          <div class="form-group"  style="display:none" id="detalle"><br>
                            <div class="col-md-12">
                              <b>Registros de Log:</b>
                              <textarea class="form-control" placeholder="Observacione" id="obse" style="width: 100%; height: 180px"  readonly></textarea>
                            </div>
                            <!-- /.input group -->
                          </div>
                          <!-- /.input group -->

                        </div>
                        <!-- /.form group -->
                        <div class="overlay"  id="cargando" style="display:none">
                            <i class="fa fa-refresh fa-spin"></i>

                        </div>

                      <!-- /.box-body -->
                      <div class="box-footer">
                        
                       <div class="row no-print">
                        <div class="col-md-12">

                          <button type="button" class="btn btn-primary pull-right" id="preparar" onclick="PrepararIndices()" id="btnGenerarIndices">
                            <i class="fa fa-cog"></i>&nbsp;&nbsp;Preparar Indices
                          </button>
                          <button type="button" class="btn btn-warning pull-right"  id="generar" onclick="GenerarAporte()" id="btnGenerarAporte" style="display:none">
                            <i class="fa fa-subscript"></i>&nbsp;&nbsp;Genear Calculos de Aporte
                          </button>
                          <button type="button" class="btn btn-success pull-right" id="descargar" onclick="DescargarAportes()" id="btnDescargarAportes" style="display:none">
                            <i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Descargar Archivo
                          </button>
                          <button type="button" class="btn btn-success" id="sueldos" onclick="GenerarSueldos()" id="btnSueldos" style="display:none">
                            <i class="fa fa-money"></i>&nbsp;&nbsp;Generar Sueldos
                          </button>
                          <button type="button" class="btn btn-danger" id="salir" onclick="principal()" id="btnSalir">
                            <i class="fa fa-close"></i>&nbsp;&nbsp;Salir de Aportes
                          </button>
                         
                        </div>
                      </div>
                    </div>
                    <!-- /.box-footer-->
                  </div>
                  <!-- /.box -->


                  <div class="box  box-solid box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Pendientes por procesar</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <div id="divPendientes"></div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      Los archivos generados por el sistema poseen firmas de autentificación que los hacen únicos e irremplazables
                    </div><!-- box-footer -->
                  </div><!-- /.box -->


                  </section>

                  <!-- /.box -->
                </div>
              

       </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.6.7
        </div>
        <strong>Copyright &copy; 2015-2016 Instituto de Previsión Social.</strong> Todos los derechos.
      </footer>




      <div div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" >
        <div class="modal-dialog modal-lg" role="document">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Generar Archivos... </h4>
            </div>
            <div class="modal-body">

             
             <br>
              <div class="row">
                <div class="col-xs-2">
                  <label>Motivo</label>

                </div>
                <div class="col-xs-10">
                  <select class="form-control select2" style="width: 100%;" id='motivo'>
                    <option value='-'> Seleccionar </option>
                    <option value="0"> Garantias </option>
                    <option value="1"> Dias Adicionales </option>
                    <option value="2"> Asignación de Antiguedad </option>
                  </select>
                </div>

              </div>


              <br>
              <div class="row">
                <div class="col-xs-2">
                  <label>Porcentaje</label>
                </div>
                <div class="col-xs-2">
                  <input type="text" class="form-control" placeholder="Porcentaje %" id='porc' value='100'/>
                  <input type="hidden" id='llave' value='0'>
                </div> 
                <div class="col-xs-8"> 
                  <label>Define la forma en que se distribuye el archivo.</label>
                </div>
              </div>

            </div>

            <div class="box-footer">
              <div class="col-xs-12">
                <button type="button" class="btn btn-success" data-dismiss="modal"
                onclick="CGTxt()"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Continuar
                </button>
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"
                onclick="continuar()"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Cancelar
                </button>


              </div>

            </div>
          </div>

        </div>
      </div>



     
    </div><!-- ./wrapper -->

    <?php $this->load->view('inc/pie.php');?>
    <script src="<?php echo base_url()?>application/modules/panel/views/js/aporte_capital.js"></script>
  </body>
</html>