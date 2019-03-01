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
            <small>Panel principal de PACE</small>
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
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" onclick="principal()" title="Cerrar"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <form class="form-horizontal" >
                <div class="box-body">
                  <div class="form-group">
                    <label class="col-md-2">Cédula</label>
                    <div class="col-md-6"> 

                      <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="consultar()"><i class="fa fa-search"></i></button>
                        </span> 
                        <input type="text" class="form-control" placeholder="Cédula de Identidad" id='id' onblur="consultar()"></input>                          
                      </div>                  
                      
                    </div>
                  </div> <!-- /Cedula -->
                  <div class="form-group">
                    <label class="col-md-2" >Cuenta</label>
                    <div class="col-md-6">                      
                      
                      <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success"><i class="fa fa-bank"></i></button>
                        </span> 
                        <input type="text" class="form-control" placeholder="Número de Cuenta" id="numero_cuenta" readonly="readonly"></input>                          
                      </div>  
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Nombres</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Nombre"  id='nombres' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Apellidos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Apellido"  id='apellidos' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Sexo</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Sexo"  id='sexo' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Componente</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Componente"  id='componente' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Grado</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Grado"  id='grado' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Estatus</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Estatus"  id='estatus' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Fecha Ingreso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Fecha de Ingreso" id='fingreso' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Tiempo Servicio</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Tiempo servicio" id='tservicio' class="form-control" value="0,00" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">No. Hijos</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Hijos" id='nhijos' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->


                  <div class="form-group">
                    <label class="col-md-2">Ultimo Ascenso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Ultimo Ascenso" id='fuascenso' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">No. Ascenso</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Ascenso" id='noascenso' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">St. Prof.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="St. Prof" id='profesionalizacion' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Años Recon.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Ultimo Ascenso" id='arec' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Meses Recon.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="No. Ascenso" id='mrec' class="form-control" readonly="readonly"></input>
                    </div> 
                    <label class="col-md-2">Días Recon.</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Días Reconocidos" id='drec' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->

                  <div class="form-group">
                    <label class="col-md-2">Fecha de Retiro</label>
                    <div class="col-md-2">                      
                      <input type="text" placeholder="Fecha de Retiro" id='fecha_retiro' class="form-control" readonly="readonly"></input>
                    </div> 
                  </div> <!-- /Numero Cuenta -->


                </div>
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <a href="#!" onclick="imprimir()" 
              class="btn btn-primary pull-right" target="_top" id='btnImprimir'><i class="fa fa-print"></i>&nbsp;&nbsp;Hoja de vida (PRINT)</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

          <div class="box-body">
            <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Datos Sueldo</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Datos Asignación Antiguedad</a></li>

                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2">Sueldo Base</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Sueldo Base" id="sueldo_base" class="form-control" readonly="readonly"></input>
                          </div> 
                          <label class="col-md-2">Sueldo Mensual</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Sueldo Mensual" id="sueldo_global" class="form-control" readonly="readonly"></input>
                          </div> 
                          <label class="col-md-2">Sueldo Integral</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Sueldo Integral" id="sueldo_integral" class="form-control" readonly="readonly"></input>
                          </div> 
                        </div> <!-- /Numero Cuenta -->
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2">Alic. Bono Fin</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Ali. Bono Fin de Año" id="fano" class="form-control" readonly="readonly"></input>
                          </div> 
                          <label class="col-md-2">Alic. Bono Vac.</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Bono Vacacional" id="vacaciones" class="form-control" readonly="readonly"></input>
                          </div>                           
                        </div> <!-- /Numero Cuenta -->
                      </div>
                    </div>

                    <br>

                    <h4>Primas</h4>
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2">Transporte</label>  
                          <div class="col-md-2">
                            <input type="text" placeholder="Transporte" id ="P_TRANSPORTE" class="form-control" readonly="readonly"></input>                          
                          </div>

                          <label class="col-md-2">Descendencia</label>  
                          <div class="col-md-2">
                            <input type="text" placeholder="Descendencia" id ="P_DESCENDECIA" class="form-control" readonly="readonly"></input>                          
                          </div>

                          <label class="col-md-2">Especial</label>  
                          <div class="col-md-2">
                            <input type="text" placeholder="Especial" class="form-control" id="P_ESPECIAL" readonly="readonly"> </input>                          
                          </div>

                        </div>

                      </div>
                    </div>
                    <br>



                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2">Años Servicio</label>  
                          <div class="col-md-2">
                            <input type="text" placeholder="Años Servicio" class="form-control" id="P_TIEMPOSERVICIO" readonly="readonly"></input>                          
                          </div>

                          <label class="col-md-2">No Ascenso</label>  
                          <div class="col-md-2">
                            <input type="text" placeholder="No Ascenso" class="form-control" id="P_NOASCENSO" readonly="readonly"></input>                          
                          </div>

                          <label class="col-md-2">Profesionalización</label>  
                          <div class="col-md-2">
                            <input type="text" placeholder="Profesionalización" class="form-control" id="P_PROFESIONALIZACION" readonly="readonly"></input>                          
                          </div>

                        </div>

                      </div>
                    </div>
                    <br>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group" id="DivDetalla">

                        </div>

                      </div>
                    </div>


                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                  <label id='lblMedida' style='font-size:18px;color:red'></label>
                    <h4>Asignación de Antiguedad</h4>
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2">A. de Antiguedad</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Asignación de Antiguedad" id='asignacion_antiguedad' class="form-control" readonly="readonly">
                              
                            </input>
                          </div> 
                          <label class="col-md-2">Capital En Banco.</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Capital en Banco" id='capital_banco' class="form-control" readonly="readonly"></input>
                          </div> 
                          <label class="col-md-2">Garantías</label>
                          <div class="col-md-2">                      
                            <input type="text" placeholder="Garantías" id='garantias' class="form-control" readonly="readonly"></input>
                          </div> 
                        </div> <!-- /Numero Cuenta -->

                        <br>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">

                              <label class="col-md-2">Días Adicionales.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Días Adicionales" id='dias_adicionales' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Total Aportado</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Total Aportado" id='total_aportados' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Saldo Disponible</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Saldo Disponible" id='saldo_disponible' class="form-control" readonly="readonly"></input>
                              </div> 
                            </div> <!-- /Numero Cuenta -->
                            <br>
                            <div class="form-group">
                              <label class="col-md-2">Diferencia A.A.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Diferencia Asignación A." id='diferencia_AA' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Fecha Ultimo Dep.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Ultimo Deposito" id='fecha_ultimo_deposito' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">% Aportado.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="% Aportado" id='porcentaje_cancelado' class="form-control" readonly="readonly"></input>
                              </div>                  
                            </div> <!-- /Numero Cuenta -->

                            <br>
                            <div class="form-group">
                              <label class="col-md-2">Embargo</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Embargo" id='embargos' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Anticipos.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="anticipos" id='anticipos' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Fecha U. Anticipo</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Ultimo Anticipo" id='fecha_ultimo_anticipo' class="form-control" readonly="readonly"></input>
                              </div> 
                            </div> <!-- /Numero Cuenta -->                            

                            <br>
                            <div class="form-group">
                              <label class="col-md-2">Comisión S.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Comisión de Servicio" id='coserv' class="form-control" readonly="readonly"></input>
                              </div>               
                            </div> <!-- /Numero Cuenta -->
                            




                            <br>
                            <h4>Intereses Caidos</h4>
                            <hr>


                            <br>
                            <div class="form-group">
                              <label class="col-md-2">Total Calculados.</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Total Calculados" id='tcalculados' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Total Cancelados</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Total Cancelados" id='tcancelados' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Total Adeudado</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Total Adeudado" id='tacumulado' class="form-control" readonly="readonly"></input>
                              </div> 
                            </div> <!-- /Numero Cuenta -->

                            <br>
                            <div class="form-group">
                              <label class="col-md-2">Fecha Ultimo Deposito</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="anticipos" id='ifudep' class="form-control" readonly="readonly"></input>
                              </div> 
                              <label class="col-md-2">Embargo</label>
                              <div class="col-md-2">                      
                                <input type="text" placeholder="Embargo" id='iembargo' class="form-control" readonly="readonly"></input>
                              </div> 

                            </div> <!-- /Numero Cuenta -->

                            <br>
                            <h4>Otros</h4>
                            <hr>

                          </div>
                        </div>

                      </div>
                      <!-- /.tab-pane -->               
                    </div>
                    <!-- /.tab-content -->
                  </div>

                </div>
              </div>
            </div>
          </div>
          

          



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
    <script src="<?php echo base_url()?>application/modules/panel/views/js/dbasico.js"></script>
  </body>
</html>