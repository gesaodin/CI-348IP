

var Persona = {};

$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#btnActualizar").focus();
  }
});

$('#fingreso').datepicker({
  format: 'dd/mm/yyyy',
  autoclose: true
});

$('#fuascenso').datepicker({
  format: 'dd/mm/yyyy',
  autoclose: true
});


function consultar() {
    limpiar();
    var val = $("#id").val();
    ruta = sUrlP + "consultarBeneficiario/" + val;
    $.getJSON(ruta, function(data) {
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        cargarSexo(data.sexo);



        $("#componente").val(data.Componente.nombre);
        cargarGrado(data.Componente.Grado.id, data.Componente.Grado.nombre, data.Componente.id);

        $('#fingreso').val(cargarFecha(data.fecha_ingreso));
        $("#tservicio").val(data.tiempo_servicio);
        $("#nhijos").val(data.numero_hijos);
        $('#fuascenso').val(cargarFecha(data.fecha_ultimo_ascenso));


        $("#noascenso").val(data.no_ascenso);
        $("#profesionalizacion").val(data.profesionalizacion);
        $("#sueldo_base").val(data.sueldo_base_aux);
        $("#sueldo_global").val(data.sueldo_global_aux);
        $("#sueldo_integral").val(data.sueldo_integral_aux);
        $("#arec").val(data.ano_reconocido);
        $("#mrec").val(data.mes_reconocido);
        $("#drec").val(data.dia_reconocido);
        $("#fecha_retiro").val(data.fecha_retiro);
        $("#fano").val(data.aguinaldos_aux);
        $("#vacaciones").val(data.vacaciones_aux);
        $("#numero_cuenta").val(data.numero_cuenta);
        $("#estatus").val(data.estatus_descripcion);

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
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

function cargarFechaSlash(fecha){
    if(fecha != null){
      var f = fecha.split('/');
      return f[2] + '-' + f[1] + '-' + f[0];
    }
}


function cargarSexo(sex){
    if (sex == '' || sex == null){
        var opt = new Option('SELECCIONE', '');
        $("#sexo").append(opt);
        opt.setAttribute("selected","selected");
        var opt = new Option('MASCULINO', 'M');
        $("#sexo").append(opt);
        var opt = new Option('FEMENINO', 'F');
        $("#sexo").append(opt);
    }else if(sex == 'F'){
        var opt = new Option('MASCULINO', 'M');
        $("#sexo").append(opt);
        var opt = new Option('FEMENINO', 'F');
        $("#sexo").append(opt);
        opt.setAttribute("selected","selected");
    }else{
        var opt = new Option('MASCULINO', 'M');
        $("#sexo").append(opt);
        opt.setAttribute("selected","selected");
        var opt = new Option('FEMENINO', 'F');
        $("#sexo").append(opt);
    }

}


function cargarGrado(cod, nom, id){


    ruta = sUrlP + "cargarGradoComponente/" + id;

    $.getJSON(ruta, function(data) {

        $.each(data, function(d, v){
            var opt = new Option(v.nombre, v.id);
            $("#grado").append(opt);
            if(v.id == cod) opt.setAttribute("selected","selected");
        });


    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontro cédula de beneficiario');
       $("#logMensaje").modal('show');
       limpiar();
    });
}





function limpiar(){

    $("#sexo option").remove();
    $("#grado option").remove();
    $("#nombres").val('');
    $("#apellidos").val('');
    $("#componente").val('');
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

function cargarBeneficiario(){

    Persona['cedula'] = $("#id").val();

    Persona['sexo'] = $("#sexo option:selected").val();
    Persona['grado'] = $("#grado option:selected").val();
    Persona['nombres'] = $("#nombres").val();
    Persona['apellidos'] = $("#apellidos").val();
    Persona['componente'] = $("#componente").val();
    Persona['fingreso'] = cargarFechaSlash($("#fingreso").val());
    Persona['tservicio'] = $("#tservicio").val();
    Persona['nhijos'] = $("#nhijos").val();
    Persona['fuascenso'] = cargarFechaSlash($("#fuascenso").val());
    Persona['noascenso'] = $("#noascenso").val();
    Persona['profesionalizacion'] = $("#profesionalizacion").val();
    Persona['arec'] = $("#arec").val();
    Persona['mrec'] = $("#mrec").val();
    Persona['drec'] = $("#drec").val();
    Persona['fecha_retiro'] = $("#fecha_retiro").val();
    Persona['fano'] = $("#fano").val();
    Persona['vacaciones'] = $("#vacaciones").val();
    Persona['numero_cuenta'] = $("#numero_cuenta").val();
    Persona['estatus'] = $("#estatus").val();
}

function actualizar(){
    var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
    $("#divContinuar").html(boton);


    if($("#id").val() == '' ){
        $("#txtMensaje").html('Debe ingresar una cédula de identidad');
        $("#logMensaje").modal('show');

    }else{
        cargarBeneficiario();

        $.ajax({
              url: sUrlP + "actualizarBeneficiario",
              type: "POST",
              data: {'data' : JSON.stringify({
                Persona: Persona
              })},
              success: function (data) {
                $("#txtMensaje").html(data);
                $("#logMensaje").modal('show');
                $("#id").val('');

              },
              error: function(data){
                $("#txtMensaje").html(data);
                $("#logMensaje").modal('show');

              }
            });
        limpiar();
    }
}



function continuar(){
    $("#logMensaje").modal('hide');
}
