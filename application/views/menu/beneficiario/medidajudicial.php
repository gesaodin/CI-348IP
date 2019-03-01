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
        Medida Judicial
        <small>.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Beneficiario</a></li>
        <li><a href="#">Medida Judcial</a></li>
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
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar" onclick="principal()"><i class="fa fa-times"></i></button>
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
                            <button type="button" class="btn btn-success" id='btnCuenta'><i class="fa fa-bank"></i></button>
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



                </div>
              </form>

          <div class="form-group">
                  <!--<div class="col-md-8">
                  </div> -->
              </form>
          </div><!-- /.box-body -->
          <div class="box-footer">
              <div class="row no-prints">
                  <div class="col-xs-12"  id='divBotonesa' >
                    <button type="button" class="btn btn-success" onclick="show()" id="btnMedidasa"><i class="glyphicon glyphicon-plus">
                    </i>&nbsp;&nbsp;Agregar Medida Judicial</button>
                  </div>
              </div><!-- /.box-footer-->
          </div><!-- /.box -->
        </div>
      </div>

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Detalles de las Medidas </h3>
              <div class="box-tools pull-right">

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                  <br><br>
                    <table id="reporteMedida" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                          <th style="width: 140px;">Acciones</th>
                          <th style="width: 40px;">Tipo</th>
                          <th>Estatus</th>
                          <th>Fecha</th>
                          <th>Oficio</th>
                          <th>Expediente</th>
                          <th>Cedula</th>
                          <th>Beneficiario</th>
                          <th >Estado</th>

                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>

            </div><!-- /.box-body -->
          </div><!-- /.box -->


                 <!-- Modal -->
                    <div div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" >
                      <div class="modal-dialog modal-lg" role="document">

                        <!-- Modal content-->
                        <div class="modal-content" style="border-radius: 8px;border:2px #337ab7 solid; ">
                          <div class="modal-header" style="background-color:#337ab7;color:white;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Nueva Medida Judicial</h4>
                            <!--label id='lblNombre'></label-->
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                 <!-- Numero de oficio -->
                                 <div class="col-md-4 col-sm-12">
                                     <label>N° Oficio:</label>
                                     <input type="hidden" id='codigomedida' value="0"/>
                                     <input type="text" class="form-control" placeholder="N° Oficio" id='numero_oficio'/>
                                 </div>
                                 <!-- Numero de Expediente -->
                                 <div class="col-md-4 col-sm-12">
                                     <label>N° Expediente:</label>
                                     <input type="text" class="form-control" placeholder="Expediente" id='numero_expediente'/>
                                 </div>
                                 <div class="col-md-4 col-sm-12">
                                   <label>Fecha:</label>
                                   <div class="input-group date">
                                       <div class="input-group-addon">
                                           <i class="fa fa-calendar"></i>
                                       </div>
                                       <div class="input-group input-group">
                                           <input type="text" class="form-control" style="width: 110%;" id="datepicker">
                                       </div>
                                   </div>
                                 </div>
                              </div>
                              <div class="row">
                                <!-- Tipo de Medida Judicial -->
                                <div class="col-md-8 col-sm-12">
                                    <label>Tipo:</label>
                                    <select class="js-states form-control" style="width: 100%" required aria-hidden="true"
                                            id="tipo">
                                            <option selected="selected" value="1">PENSION ALIMENTARIA</option>
                                            <option value="2">RETRIBUCION ESPECIAL</option>
                                            <option value="3">BONO RECREACIONAL</option>
                                            <option value="4">RETENCION ESCOLAR</option>
                                            <option value="5">RETENCION AGUINALDOS</option>
                                    </select>
                                </div>
                                <!-- Fecha del Expediente -->
                              </div>
                              <div class="row">
                                <div class="col-md-12 col-sm-12">
                                  <label>Observaciones:</label>
                                  <textarea class="form-control" placeholder="Descripción" id='observacion'></textarea>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Porcentaje -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Porcentaje:</label>
                                    <input type="text" class="form-control" placeholder="Porcentaje" id='porcentaje' value=0>
                                </div>
                                <!-- Sueldo Minimo -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Sueldo Minimo:</label>
                                    <input type="text" class="form-control" placeholder="Salarios" id='salario' value=0 onblur="convertirSalario()">
                                    <input type="hidden" id='salarioaux' value=0 >
                                </div>
                                <!-- Monto Fijo -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Monto Fijo:</label>
                                    <input type="text" class="form-control" placeholder="Mensualidades" id='mensualidades' value=0>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Unidad Tributaria -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Unidad Tributaria:</label>
                                    <input type="text" class="form-control" placeholder="Unidad Tributaria" id='ut' value=0 onblur="convertirSalario()">
                                    <input type="hidden" id='salarioaux' value=0 >
                                </div>
                                <!-- Monto Total -->
                              <!--  <div class="col-md-4 col-sm-12">
                                    <label> Monto Total:</label>
                                    <input type="text" class="form-control" placeholder="Monto Total" id='monto_total' value=0 onblur="convertirMonto()">
                                    <input type="hidden" id='monto_totalaux' value=0 >
                                </div>-->
                                <div class="col-md-4 col-sm-12">
                                    <label> Monto Total:</label>
                                    <input type="text" class="form-control" placeholder="Monto Total" id='monto_total' value=0>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Forma Pago -->
                                <div class="col-md-4 col-sm-12">
                                    <label>Forma Pago:</label>
                                    <select class="js-states form-control" style="width: 100%" required aria-hidden="true"
                                            id="forma_pago">
                                            <option value='0'>CHEQUE</option>
                                            <option value='1'>TRANSFERENCIA</option>
                                            <option value='2'>DEPOSITO</option>
                                            <?php
                                              foreach ($FormaPago as $k => $v) {
                                                echo '<option value="' . $v->id . '">' . $v->nombre . '</option>';
                                              }
                                            ?>
                                    </select>
                                </div>
                                <!-- Institución -->
                                <div class="col-md-4 col-sm-12">
                                    <label>Institución:</label>
                                    <select class="js-states form-control" style="width: 100%"  aria-hidden="true"
                                            id="institucion">
                                            <option value="0156">100%BANCO</option>
                                            <option value="0196">ABN AMRO BANK</option>
                                            <option value="0172">BANCAMIGA BANCO MICROFINANCIERO, C.A.</option>
                                            <option value="0171">BANCO ACTIVO BANCO COMERCIAL, C.A.</option>
                                            <option value="0166">BANCO AGRICOLA</option>
                                            <option value="0175">BANCO BICENTENARIO</option>
                                            <option value="0128">BANCO CARONI, C.A. BANCO UNIVERSAL</option>
                                            <option value="0164">BANCO DE DESARROLLO DEL MICROEMPRESARIO</option>
                                            <option value="0102">BANCO DE VENEZUELA S.A.I.C.A.</option>
                                            <option value="0114">BANCO DEL CARIBE C.A.</option>
                                            <option value="0149">BANCO DEL PUEBLO SOBERANO C.A.</option>
                                            <option value="0163">BANCO DEL TESORO</option>
                                            <option value="0176">BANCO ESPIRITO SANTO, S.A.</option>
                                            <option value="0115">BANCO EXTERIOR C.A.</option>
                                            <option value="0003">BANCO INDUSTRIAL DE VENEZUELA.</option>
                                            <option value="0173">BANCO INTERNACIONAL DE DESARROLLO, C.A.</option>
                                            <option value="0105">BANCO MERCANTIL C.A.</option>
                                            <option value="0191">BANCO NACIONAL DE CREDITO</option>
                                            <option value="0116">BANCO OCCIDENTAL DE DESCUENTO.</option>
                                            <option value="0138">BANCO PLAZA</option>
                                            <option value="0108">BANCO PROVINCIAL BBVA</option>
                                            <option value="0104">BANCO VENEZOLANO DE CREDITO S.A.</option>
                                            <option value="0168">BANCRECER S.A. BANCO DE DESARROLLO</option>
                                            <option value="0134">BANESCO BANCO UNIVERSAL</option>
                                            <option value="0177">BANFANB</option>
                                            <option value="0146">BANGENTE</option>
                                            <option value="0174">BANPLUS BANCO COMERCIAL C.A</option>
                                            <option value="0190">CITIBANK.</option>
                                            <option value="0121">CORP BANCA.</option>
                                            <option value="0157">DELSUR BANCO UNIVERSAL</option>
                                            <option value="0151">FONDO COMUN</option>
                                            <option value="0601">INSTITUTO MUNICIPAL DE CR&#201;DITO POPULAR</option>
                                            <option value="0169">MIBANCO BANCO DE DESARROLLO, C.A.</option>
                                            <option value="0137">SOFITASA</option>
                                    </select>
                                    <!--input type="text" class="form-control" placeholder="Institución" id='institucion'-->
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label>Tipo de Cuenta:</label>
                                    <select class="form-control" style="width: 100%"
                                              id="tipodecuenta">
                                        <option selected="selected" value="S"></option>
                                        <option value="CA" selected="selected">AHORRO</option>
                                        <option value="CC">CORRIENTE</option>
                                    </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <label>Nro. de Cuenta:</label>
                                    <input id="numerocuenta" placeholder="Nro. de Cuenta" class="form-control"  type="text" maxlength="20"
                                           data-inputmask='"mask": "9999-9999-99-9999999999"' data-mask>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Autoridad -->
                                <div class="col-md-8 col-sm-12">
                                    <label> Autoridad:</label>
                                    <input type="text" class="form-control" placeholder="Autoridad" id='autoridad'>
                                </div>
                                <!-- Cargo -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Cargo:</label>
                                    <input type="text" class="form-control" placeholder="Cargo" id='cargo' >
                                </div>
                              </div>
                              <div class="row">
                                <!-- Estado -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Estado:</label>
                                    <select class="form-control" id='estado' style="width: 100%;" onchange="obtenerCiudades()">
                                      <option value='0'>SELECCIONE UNA OPCION</option>
                                      <?php
                                        foreach ($Estado as $k => $v) {
                                          echo '<option value="' . $v->codigo . '">' . $v->nombre . '</option>';
                                        }
                                      ?>
                                    </select>
                                </div>
                                <!-- Ciudad -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Ciudad:</label>
                                    <select class="form-control" id='ciudad' onchange="obtenerMunicipios()" style="width: 100%;" >
                                      <option value='0'>SELECCIONE UNA OPCION</option>
                                    </select>
                                </div>
                                <!-- Municipio -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Municipio:</label>
                                    <select class="form-control" id='municipio' style="width: 100%;" >
                                      <option value='0'>SELECCIONE UNA OPCION</option>
                                    </select>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Descripcion Institución -->
                                <div class="col-md-12 col-sm-12">
                                    <label> Descripcion Institución:</label>
                                    <!--input type="text" class="form-control" placeholder="Descripcion" id='descripcion_institucion'-->
                                    <textarea class="form-control" placeholder="Descripción" id='descripcion_institucion'></textarea>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Cedula Beneficiario -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Cedula:</label>
                                    <input type="text" class="form-control" placeholder="Cedula Beneficiario" id='cedula_beneficiario'>
                                </div>
                                <!-- Beneficiario -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Beneficiario:</label>
                                    <input type="text" class="form-control" placeholder="Nombre Beneficiario" id='beneficiario'>
                                </div>
                                <!-- Parentesco -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Parentesco:</label>
                                    <select class="form-control" id='parentesco' style="width: 100%;">
                                      <option value='0'>NO POSEE</option>
                                      <option value='1'>HIJO</option>
                                      <option value='2'>ESPOSA</option>
                                      <?php
                                        foreach ($Parentesco as $k => $v) {
                                          echo '<option value="' . $v->id . '">' . $v->nombre . '</option>';
                                        }
                                      ?>
                                    </select>
                                </div>
                              </div>
                              <div class="row">
                                <!-- Cedula Autorizado -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Cedula:</label>
                                    <input type="text" class="form-control" placeholder="Cedula Autorizado" id='cedula_autorizado'>
                                </div>
                                <!-- Nombre Autorizado -->
                                <div class="col-md-4 col-sm-12">
                                    <label> Autorizado:</label>
                                    <input type="text" class="form-control" placeholder="Nombre Autorizado" id='autorizado'>
                                </div>
                              </div>
                          <br>
                            <!-- <div class="row">
                            <div class="col-md-2">N° Oficio:</div>
                            <div class="col-md-4">
                              <input type="hidden" id='codigomedida' value="0"/>
                              <input type="text" class="form-control" placeholder="N° Oficio" id='numero_oficio'/>
                            </div>
                            <div class="col-md-2">Expediente:</div>
                            <div class="col-md-4"><input type="text" class="form-control" placeholder="Expediente" id='numero_expediente'/></div>
                          </div> -->

                           <!-- <div class="row">
                            <div class="col-md-2">Tipo:</div>
                            <div class="col-md-4">
                              <select class="form-control select2" style="width: 100%;" id='tipo'>
                                <option selected="selected" value="1">PENSION ALIMENTARIA</option>
                                <option value="2">RETRIBUCION ESPECIAL</option>
                                <option value="3">BONO RECREACIONAL</option>
                                <option value="4">RETENCION ESCOLAR</option>
                                <option value="5">RETENCION AGUINALDOS</option>
                              </select></div>
                            <div class="col-md-2">
                              Fecha:
                            </div>
                            <div class="col-md-4">
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="datepicker">
                              </div>
                              </div>
                            </div> -->
                            <!-- <div class="row">
                              <div class="col-md-2">Observaciones:</div>
                              <div class="col-md-10">
                                <textarea class="form-control" placeholder="Descripción" id='observacion'></textarea>
                              </div>
                            </div> -->
                            <!-- <div class="row">
                              <div class="col-md-2">Porcentaje:</div>
                              <div class="col-md-4"><input type="text" class="form-control" placeholder="Porcentaje" id='porcentaje' value=0></div>
                              <div class="col-md-2">Sueldo Minimo:</div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Salarios" id='salario' value=0 onblur="convertirSalario()">
                                <input type="hidden" id='salarioaux' value=0 >
                              </div>
                            </div> -->
                             <!-- <div class="row">
                              <div class="col-md-2">Monto Fijo:</div>
                              <div class="col-md-4"><input type="text" class="form-control" placeholder="Mensualidades" id='mensualidades' value=0></div>
                              <div class="col-md-2">U.T.:</div>
                              <div class="col-md-4"><input type="text" class="form-control" placeholder="Unidad Tributaria" id='ut' value=0></div>
                            </div> -->
                            <!--<div class="row"> <!--Comentado>
                              <div class="col-md-2">Monto Total:</div>
                              <div class="col-md-4"><input type="text" class="form-control" placeholder="Monto Total" id='monto_total' value=0></div>
                              <div class="col-md-2"><button type="button" class="btn btn-success pull-left" onclick="calculomensual()">
                            Calc.
                            </button></div>
                          </div>!-->
                             <!-- <div class="row">
                              <div class="col-md-2">Forma Pago:</div>
                              <div class="col-md-10">
                                <select class="form-control" id='forma_pago' style="width: 100%;">
                                  <option value='0'>CHEQUE</option>
                                  <option value='1'>TRANSFERENCIA</option>
                                  <option value='2'>DEPOSITO</option>
                                  <--?php
                                    foreach ($FormaPago as $k => $v) {
                                      echo '<option value="' . $v->id . '">' . $v->nombre . '</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Institucion:</div>
                              <div class="col-md-10">
                                <input type="text" class="form-control" placeholder="Institución" id='institucion'/>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Autoridad:</div>
                              <div class="col-md-10">
                                <input type="text" class="form-control" placeholder="Autoridad" id='autoridad'/>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Cargo:</div>
                              <div class="col-md-10">
                                <input type="text" class="form-control" placeholder="Cargo" id='cargo'/>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Estado</div>
                              <div class="col-md-10">
                                <select class="form-control" id='estado' style="width: 100%;" onchange="obtenerCiudades()">
                                  <option value='0'>SELECCIONE UNA OPCION</option>
                                  <--?php
                                    foreach ($Estado as $k => $v) {
                                      echo '<option value="' . $v->codigo . '">' . $v->nombre . '</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Ciudad:</div>
                              <div class="col-md-10">
                                <select class="form-control" id='ciudad' onchange="obtenerCiudades()" style="width: 100%;" >
                                  <option value='0'>SELECCIONE UNA OPCION</option>
                                </select>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Municipio:</div>
                              <div class="col-md-10">
                                <select class="form-control" id='municipio' style="width: 100%;" >
                                  <option value='0'>SELECCIONE UNA OPCION</option>
                                </select>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Descripción Institución:</div>
                              <div class="col-md-10">
                                <textarea class="form-control" placeholder="Descripción Institución" id='descripcion_institucion'></textarea>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Beneficiario:</div>
                              <div class="col-md-10">
                                <input type="text" class="form-control" placeholder="Datos del Beneficiario" id='beneficiario'/>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Cedula:</div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Cédula de Identidad" id='cedula_beneficiario'/>
                              </div>
                              <div class="col-md-2">Parentesco:</div>
                              <div class="col-md-4">
                                <select class="form-control" id='parentesco' style="width: 100%;">
                                  <option value='0'>NO POSEE</option>
                                  <option value='1'>HIJO</option>
                                  <option value='2'>ESPOSA</option>
                                  <?php
                                    foreach ($Parentesco as $k => $v) {
                                      echo '<option value="' . $v->id . '">' . $v->nombre . '</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                            </div> -->

                            <!-- <div class="row">
                              <div class="col-md-2">Cedula Autorizado:</div>
                              <div class="col-md-4"><input type="text" class="form-control" placeholder="Cédula de Identidad" id='cedula_autorizado'/></div>
                              <div class="col-md-2">Autorizado:</div>
                              <div class="col-md-4"><input type="text" class="form-control" placeholder="Autorizado" id='autorizado'/></div>
                            </div> -->

                          </div>



                          <div class="box-footer">
                          <div class="col-xs-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Cancelar
                            </button>

                            <button type="button" class="btn btn-success pull-right" data-dismiss="modal" onclick="guardarMedida()">
                            <i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Aceptar
                            </button>


                          </div>

                          </div>
                        </div>

                      </div>
                    </div>
        </section><!-- /.content -->

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
    <script src="<?php echo base_url()?>application/views/js/medidajudicial.js"></script>
  </body>
</html>
