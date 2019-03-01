_MOVIMIENTO = {};

$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#btnImprimir").focus();
  }
});

function consultar() {

    var val = $("#id").val();
    $("#lblMedida").text('');
    ruta = sUrlP + "consultarBeneficiario/" + val;
    $.getJSON(ruta, function(data) {
            $("#nombres").val(data.nombres);
            $("#apellidos").val(data.apellidos);
            $("#sexo").val(data.sexo);
            $("#componente").val(data.Componente.nombre);
            $("#grado").val(data.Componente.Grado.nombre);
            $("#fingreso").val(cargarFecha(data.fecha_ingreso));
            //$("#tservicio").val(data.tiempo_servicio);
            // Se cambio para desplegar el tiempo de servicio correcto segun situacion del beneficiario
            if(data.fecha_retiro != null && data.fecha_retiro != '') {
                $("#tservicio").val(data.tiempo_servicio_aux);

            }else{

                $("#tservicio").val(data.tiempo_servicio);
            }
            $("#motivo_paralizado").val(data.motivo_paralizacion);
            $("#nhijos").val(data.numero_hijos);
            $("#fuascenso").val(cargarFecha(data.fecha_ultimo_ascenso));
            $("#noascenso").val(data.no_ascenso);
            $("#profesionalizacion").val(data.profesionalizacion);
            $("#sueldo_base").val(data.sueldo_base_aux);
            $("#sueldo_global").val(data.sueldo_global_aux);
            $("#sueldo_integral").val(data.sueldo_integral_aux);
            $("#arec").val(data.ano_reconocido);
            $("#mrec").val(data.mes_reconocido);
            $("#drec").val(data.dia_reconocido);
            $("#fecha_retiro").val(cargarFecha(data.fecha_retiro));
            $("#fano").val(data.aguinaldos_aux);
            $("#vacaciones").val(data.vacaciones_aux);
            $("#numero_cuenta").val(data.numero_cuenta);
            $("#estatus").val(data.estatus_descripcion);

            $("#P_TRANSPORTE").val(data.prima_transporte_aux);
            $("#P_DESCENDECIA").val(data.prima_descendencia_aux);
            $("#P_ESPECIAL").val(data.prima_especial_aux);
            $("#P_TIEMPOSERVICIO").val(data.prima_tiemposervicio_aux);
            $("#P_NOASCENSO").val(data.prima_noascenso_aux);
            $("#P_PROFESIONALIZACION").val(data.prima_profesionalizacion_aux);

            //$("#asignacion_antiguedad").val(data.Calculo.asignacion_antiguedad);
            // Se cambio para desplegar la asignacion_antiguedad correcta segun situacion del beneficiario
            if(data.fecha_retiro != null && data.fecha_retiro != '') {
                $("#asignacion_antiguedad").val(data.Calculo.asignacion_antiguedad_fin);
            }else{
                $("#asignacion_antiguedad").val(data.Calculo.asignacion_antiguedad);
            }
            $("#capital_banco").val(data.Calculo.capital_banco);
            $("#garantias").val(data.Calculo.garantias);
            $("#dias_adicionales").val(data.Calculo.dias_adicionales);
            $("#total_aportados").val(data.Calculo.total_aportados);
            $("#asignacion_depositada").val(data.Calculo.asignacion_depositada);
            $("#saldo_disponible").val(data.Calculo.saldo_disponible);
            if(data.fecha_retiro != null && data.fecha_retiro != '') {
                $("#diferencia_AA").val(data.Calculo.asignacion_diferencia);
                $("#saldo_disponible").val('0');
            }else{
                $("#diferencia_AA").val(data.Calculo.diferencia_AA);
            }
            //$("#diferencia_AA").val(data.Calculo.diferencia_AA);
            $("#fecha_ultimo_deposito").val(data.Calculo.fecha_ultimo_deposito);
            $("#fecha_ultimo_anticipo").val(data.Calculo.fecha_ultimo_anticipo);
            $("#anticipos").val(data.Calculo.anticipos);
            $("#embargos").val(data.Calculo.total_embargos);
            $("#coserv").val(data.Calculo.comision_servicios); /**se agrego la comision de servicio para mostrarla por la consulta **/

            $("#monto_recuperado").val(data.Calculo.monto_recuperado);
            $.each(data.MedidaJudicialActiva, function (clave, valor){
                $("#lblMedida").text('Beneficiario con Medidas Judiciales');

            });
            
            _MOVIMIENTO = data.HistorialDetalleMovimiento;

            $("#porcentaje_cancelado").val(data.Calculo.porcentaje_cancelado);
            listarHistorialSueldo(data.HistorialSueldo);
            listarHistorialMovimiento();

        }

    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontro cédula de beneficiario');
       $("#logMensaje").modal('show');
       limpiar();
    });

}

function cargarFecha(fecha){
    if(fecha != null){
      var f = fecha.split('-');
      return f[2] + '/' + f[1] + '/' + f[0];
    }
}


function imprimir(){
    var val = $("#id").val();
    URL = sUrlP + "hojavida/" + val;
    window.open(URL,"Hoja de Vida","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function continuar(){
    $("#logMensaje").modal('hide');
    //$("#id").focus();
}

function limpiar(){
    $("#nombres").val('');
    $("#apellidos").val('');
    $("#sexo").val('');
    $("#componente").val('');
    $("#grado").val('');
    $("#fingreso").val('');
    $("#tservicio").val('');
    $("#nhijos").val('');
    $("#fuascenso").val('');
    $("#noascenso").val('');
    $("#profesionalizacion").val('');
    $("#arec").val('');
    $("#mrec").val('');
    $("#drec").val('');
    $("#fecha_retiro").val('');
    $("#fano").val('');
    $("#vacaciones").val('');
    $("#numero_cuenta").val('');
    $("#estatus").val('');
}


function listarHistorialSueldo(_Data){
    $("#dvsueldo").html('<table  id="reporteSueldos" class="table table-striped table-bordered">\
                            <thead>\
                              <tr>\
                                <th style="width:20px">#</th>\
                                <th>FECHA</th>\
                                <th>SUELDO BASE </th>\
                                <th>SUELDO GLOBAL </th>\
                              </tr>\
                            </thead>\
                          </table>');

    var t = $('#reporteSueldos').DataTable({
        "paging":  true,
        "ordering": false,
        "info":     true,
        "searching": false,
        "dom": 'Bfrtip',
        "buttons": [
            'print'
        ],

        "language": { 
            "lengthMenu": "Mostrar _MENU_ registros por pagina", 
            "zeroRecords": "No se encontraron registros", 
            "info": "P&aacutegina _PAGE_ of _PAGES_",
            "sPrint": "Imprimir", 
            "infoEmpty": "No hay registros"
 
        }
    });    
    t.clear().draw();
        
    var i = 0;
    $.each(_Data, function (p,q){
        i++;
        fecha = cargarFecha(q.fecha);
        sueldo_base = Number(q.sueldo_base);
        sueldo_global = Number(q.sueldo_global);

        t.row.add( [
            i,
            fecha,
            sueldo_base.formatMoney(2, ',', '.'),
            sueldo_global.formatMoney(2, ',', '.')
    ] ).draw( false );
    });
}

function listarHistorialMovimiento(tipo){

    $("#dvmovimiento").html('<table  id="reporteMovimientos" class="table table-striped table-bordered">\
                            <thead>\
                              <tr>\
                                <th style="width:20px">#</th>\
                                <th>FECHA</th>\
                                <th>TIPO DE MOVIMIENTO</th>\
                                <th>MONTO</th>\
                                <th>OBSERVACIONES</th>\
                              </tr>\
                            </thead>\
                          </table>')

    var tab = $('#reporteMovimientos').DataTable({
        "paging":  true,        
        "ordering": false,
        "info":     true,
        "searching": false,
        "dom": 'Bfrtip',
        "buttons": [
            'print'
        ]
    });    
    
    tab.clear().draw();
        
    var i = 0;
    $.each(_MOVIMIENTO.Detalle, function (x,y){
        $.each(y, function(p, q){
            i++;
            detalle = q.detalle;
            monto = Number(q.monto);

            fecha = cargarFecha(q.fecha);
            observacion = q.observacion;
            if (tipo != null){
                if(tipo == q.tipo){                    
                     tab.row.add( [
                        i,
                        fecha,
                        detalle,
                        monto.formatMoney(2, ',', '.'),
                        observacion,
                    ] ).draw( false );        
                }
            }else{
                
                 tab.row.add( [
                    i,
                    fecha,
                    detalle,
                    monto.formatMoney(2, ',', '.'),
                    observacion,
                ] ).draw( false );    
            }
            
        });
                
       
    });


  }

  function STM(){
    tipo = $('#tipomovimiento option:selected').val();

    listarHistorialMovimiento(parseInt(tipo));
  }