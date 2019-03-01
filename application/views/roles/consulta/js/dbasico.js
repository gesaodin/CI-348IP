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
            $("#saldo_disponible").val(data.Calculo.saldo_disponible);
            if(data.fecha_retiro != null && data.fecha_retiro != '') {
                $("#diferencia_AA").val(data.Calculo.asignacion_diferencia);
            }else{
                $("#diferencia_AA").val(data.Calculo.diferencia_AA);
            }
            //$("#diferencia_AA").val(data.Calculo.diferencia_AA);
            $("#fecha_ultimo_deposito").val(data.Calculo.fecha_ultimo_deposito);
            $("#fecha_ultimo_anticipo").val(data.Calculo.fecha_ultimo_anticipo);
            $("#anticipos").val(data.Calculo.anticipos);
            $("#embargos").val(data.Calculo.embargos);
            $("#coserv").val(data.Calculo.comision_servicios); /**se agrego la comision de servicio para mostrarla por la consulta **/

            $.each(data.MedidaJudicialActiva, function (clave, valor){
                $("#lblMedida").text('Beneficiario con Medidas Judiciales');

            });
            $("#porcentaje_cancelado").val(data.Calculo.porcentaje_cancelado);
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
