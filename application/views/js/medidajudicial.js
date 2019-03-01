var MedidaJudicial = {};

MedidaJudicial['cedula'] = 0;
$("#btnMedida").hide();
$('#reporteMedida').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);

$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#btnMedida").focus();
  }
});

function ShowNuevaMedida(){
    limpiarMedida();
    if($("#id").val() != "" ){
        $("#codigomedida").val("0");
        $("#myModal").modal('show');
    }

}

function consultar() {
    var val = $("#id").val();
    ruta = sUrlP + "consultarBeneficiarioJudicial/" + val;
    $.getJSON(ruta, function(data) {
        if(data.fecha_retiro != null && data.fecha_retiro != '') {
            $("#btnMedida").hide();
        }else{
            $("#btnMedida").show();
        }

        MedidaJudicial['cedula'] = data.cedula;
        $("#lblNombre").text(' Nombres: ' + data.nombres + ' ' + data.apellidos + ' C.I: ' + data.cedula );
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#sexo").val(data.sexo);
        $("#componente").val(data.Componente.nombre);
        $("#grado").val(data.Componente.Grado.nombre);
        $("#fingreso").val(data.fecha_ingreso);
        $("#tservicio").val(data.tiempo_servicio);
        $("#nhijos").val(data.numero_hijos);
        $("#fuascenso").val(data.fecha_ultimo_ascenso);
        $("#noascenso").val(data.no_ascenso);
        $("#profesionalizacion").val(data.profesionalizacion);
        $("#arec").val(data.ano_reconocido);
        $("#mrec").val(data.mes_reconocido);
        $("#drec").val(data.dia_reconocido);
        $("#fano").val(data.aguinaldos_aux);
        $("#vacaciones").val(data.vacaciones_aux);
        $("#estatus").val(data.estatus_descripcion);
        listar(data.MedidaJudicial);
    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        $("#id").val('');
        var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
        $("#divContinuar").html(boton);
        $("#txtMensaje").html('El Beneficiario que intenta consultar no se encuentra en nuestra base de datos');
        $("#logMensaje").modal('show');
        $("#controles").hide();
        $("#btnContinuar").focus();
    });
}

function listar(data){
    var t = $('#reporteMedida').DataTable();
    t.clear().draw();
    $.each(data, function (clave, valor){
        var monto = Number(valor.monto);
        var sBoton = '<div class="btn-group">';
        var sAcciones = '';
        sBoton += '<button type="button" class="btn btn-success" title="Ver Detalles" onclick="ConsultarMedidaEjecutada(\'' + valor.id + '\')" ><i class="fa fa-search" ></i></button>';
        switch (valor.estatus){
            case '220':
                idbtn = 'btnAsignacion';
                if(valor.tipo_nombre == 'INTERESES')idbtn = 'btnIntereses';
                sBoton += '<button id="' + idbtn +'" onclick="SuspenderMedidaEjecutada(\'' + valor.id + '\')" type="button" class="btn btn-warning" title="Inactivar"><i class="fa fa-mail-reply-all" ></i></button>';
                //sBoton += '<button type="button" class="btn btn-info" title="Ejecutar"><i class="fa fa-cogs" ></i></button>';
                sBoton += '<button type="button" class="btn btn-info" title="Imprimir" onclick="imprimir(\'' + valor.id + '\')"><i class="fa fa-print" ></i></button>';
                break;
            case '221':
                break;21
            case '222':
                break;
            case '223':
                //sBoton += '<button type="button" class="btn btn-danger" title="Suspender"><i class="fa fa-cogs" ></i></button>';
                sBoton += '<button type="button" class="btn btn-info" title="Imprimir" onclick="MedidaEjecutada(\'' + valor.cedula + '\', \'' + valor.ultima_observacion + '\',\'' + valor.id + '\')"><i class="fa fa-print" ></i></button>';
                break;
            default:
                break;
        }

        sBoton += '</div>';

        t.row.add( [
            sBoton,
            valor.tipo_nombre,
            valor.estatus_nombre,
            valor.fecha,
            valor.numero_oficio,
            valor.numero_expediente,
            valor.cedula_beneficiario,
            valor.nombre_beneficiario,
            valor.estado,
            valor.mensualidades
          ] ).draw( false );

    });
    vBtn();
}

function continuar(){
    $("#logMensaje").modal('hide');
}


function imprimir(id){
    var val = $("#id").val();
    URL = sUrlP + "medida_judicial/" + val +  '/' + id;
    window.open(URL,"Hoja de Vida","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function SuspenderMedidaEjecutada(id){
    var boton = '<button type="button" class="btn btn-danger pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;No</button>';
        boton += '<button type="button" class="btn btn-success" onclick="Suspender(\'' + id + '\')">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si</button>';
    var msj = '¿Está seguro que desea suspender está medida?';
    $("#divContinuar").html(boton);
    $("#txtMensaje").html(msj);
    $("#logMensaje").modal('show');
    $("#controles").hide();
}

function Suspender(id){
    URL = sUrlP + "SuspenderMedidaJudicial/" + id;
    $.get(URL, function (data){
        var boton = '<button type="button" class="btn btn-danger pull-right" onclick="recargar()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
        $("#divContinuar").html(boton);
        $("#txtMensaje").html(data);
        $("#logMensaje").modal('show');
        $("#controles").hide();

    }).done(function (data){

    });
}

function ConsultarMedidaEjecutada(id){
    var ced = $("#id").val(); //Cedula
    ruta = sUrlP + "ConsultarMedidaEjecutada";

    $("#myModal").modal("show");
    $.post(ruta, {ced:ced, id:id}, function (data){
       console.log(data);
       $.each(data, function(p,q){
            $("#codigomedida").val(id);
            $("#numero_oficio").val(q.numero_oficio);
            $("#numero_expediente").val(q.numero_expediente);

            $("#tipo").val(q.tipo);
            $("#datepicker").val(cargarFecha(q.fecha));
            $("#observacion").val(q.descripcion_embargo);

            $("#porcentaje").val(q.porcentaje);
            $("#salario").val(q.salario);
            $("#salarioaux").val(q.salario);
            $("#ut").val(q.unidad_tributaria);
            $("#monto_total").val(q.monto);
            $("#monto_totalaux").val(q.monto);
            $("#mensualidades").val(q.mensualidades);
            $("#forma_pago").val(q.forma_pago);
            $("#institucion").val(q.institucion);
            $("#tipodecuenta").val(q.tipodecuenta);
            $("#numerocuenta").val(q.numerocuenta);
            $("#autoridad").val(q.nombre_autoridad);
            $("#cargo").val(q.cargo);
            $("#estado").val(q.estado_id);

            obtenerCiudades();
            $("#ciudad option:selected").val(q.ciudad);
            $("#municipio option:selected").val(q.municipio);
            $("#descripcion_institucion").val(q.descripcion_institucion);

            $("#beneficiario").val(q.nombre_beneficiario);
            $("#cedula_beneficiario").val( q.numero_beneficiario);
            $("#parentesco").val(q.parentesco);

            $("#cedula_autorizado").val(q.cedula_autorizado);
            $("#autorizado").val(q.nombre_autorizado);

       });

    }).fail(function(data){
        console.log('Error');
    });


}


function continuar(){
    $("#logMensaje").modal('hide');
}


function MedidaEjecutada(ced,  cod, id){
    URL = sUrlP + "medidaejecutada/" + ced + '/' + id + '/' + cod;
    window.open(URL,"Medida Ejecutada","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function obtenerCiudades(){
    var i = 0;
    id = $("#estado option:selected").val();
    ruta = sUrlP + "obtenerCiudades/" + id;
    $("#ciudad option").remove();
    $("#municipio option").remove();
    console.log(ruta);
    $.getJSON(ruta, function(data) {
        $.each(data, function(d, v){
            var opt = new Option(v.nombre, v.id);
            $("#ciudad").append(opt);
            i = v.id;
        });
        obtenerMunicipios();

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontraron ciudades');
       $("#logMensaje").modal('show');
    });
}

function obtenerMunicipios(){
    id = $("#estado option:selected").val();
    obtenerMunicipiosID(id);
}

function obtenerMunicipiosID(id){
    ruta = sUrlP + "obtenerMunicipios/" + id;
    console.log(ruta);
    $("#municipio option").remove();
    $.getJSON(ruta, function(data) {

        $.each(data, function(d, v){
            var opt = new Option(v.nombre, v.id);
            $("#municipio").append(opt);
        });
    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontraron municipios');
       $("#logMensaje").modal('show');
    });
}


function cargar(){
    MedidaJudicial['numero_oficio'] = $("#numero_oficio").val();
    MedidaJudicial['numero_expediente'] = $("#numero_expediente").val();

    MedidaJudicial['tipo'] = $("#tipo").val();
    MedidaJudicial['fecha'] = cargarFechaSlash($("#datepicker").val());
    MedidaJudicial['observacion'] = $("#observacion").val();

    MedidaJudicial['porcentaje'] = $("#porcentaje").val();
    convertirSalario();
    MedidaJudicial['salario'] = $("#salarioaux").val();
    MedidaJudicial['mensualidades'] = $("#mensualidades").val();
    MedidaJudicial['ut'] = $("#ut").val();
    //convertirMonto();
    //MedidaJudicial['monto'] = $("#monto_totalaux").val();
    MedidaJudicial['monto'] = $("#monto_total").val();
    if($("#forma_pago option:selected").val() == null || $("#forma_pago option:selected").val() == '0'){
      MedidaJudicial['forma_pago'] = 1;
    }else{
       MedidaJudicial['forma_pago'] = $("#forma_pago option:selected").val();
    }
    MedidaJudicial['institucion'] = $("#institucion").val();
    MedidaJudicial['tipodecuenta'] = $("#tipodecuenta").val();
    MedidaJudicial['numerocuenta'] = $("#numerocuenta").val();
    MedidaJudicial['autoridad'] = $("#autoridad").val();
    MedidaJudicial['cargo'] = $("#cargo").val();


    MedidaJudicial['estado'] = $("#estado option:selected").val();
    MedidaJudicial['ciudad'] = $("#ciudad option:selected").val();
    MedidaJudicial['municipio'] = $("#municipio option:selected").val();
    MedidaJudicial['descripcion_institucion'] = $("#descripcion_institucion").val();

    MedidaJudicial['nombre_beneficiario'] = $("#beneficiario").val();
    MedidaJudicial['cedula_beneficiario'] = $("#cedula_beneficiario").val();
    MedidaJudicial['parentesco'] = $("#parentesco option:selected").val();

    MedidaJudicial['cedula_autorizado'] = $("#cedula_autorizado").val();
    MedidaJudicial['nombre_autorizado'] = $("#autorizado").val();

}
function guardarMedida(){
    if($("#numero_oficio").val() != "" || $("#forma_pago option:selected").val() != '0'){

        cargar();
        id = "";
        if($("#codigomedida").val() != "0"){
            id = "/" + $("#codigomedida").val();
        }
        url = sUrlP + "crearMedidaJudicial" + id;
        //console.log(url);
        $("#myModal").modal('hide');
        $.ajax({
              url: url,
              type: "POST",
              data: {'data' : JSON.stringify({
                MedidaJudicial: MedidaJudicial
              })},
              success: function (data) {
                //console.log(data);
                var boton = '<button type="button" class="btn btn-success pull-right" onclick="recargar()">';
                    boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
                $("#divContinuar").html(boton);
                $("#txtMensaje").html(data);
                $("#logMensaje").modal('show');

              },
              error: function(data){
                $("#txtMensaje").html('Ocurrio un error en la conexion');
                $("#logMensaje").modal('show');

              }
        });
    }else{
        $("#myModal").modal('hide');
    }
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

function convertirSalario(){
  var convertir = $("#salario").val();
  valor = convertir.replace(",",".");

  $("#salarioaux").val(valor);
}

/*function convertirMonto(){
  var conversion = $("#monto").val();
  resultado = conversion.replace(",",".");

  $("#monto_totalaux").val(resultado);
}*/


function recargar(){
    URL = sUrlP + "medidajudicial";
    $(location).attr('href', URL);
}

function limpiarMedida(){
    $("#codigomedida").val("");
    $("#numero_oficio").val("");
    $("#numero_expediente").val("");

    $("#tipo").val("");
    $("#datepicker").val("");
    $("#observacion").val("");

    $("#porcentaje").val("");
    $("#salario").val("");
    $("#mensualidades").val("");
    $("#ut").val("");
    $("#monto_total").val("");
    $("#forma_pago").val("");
    $("#institucion").val("");
    $("#autoridad").val("");
    $("#cargo").val("");

    $("#estado").val(0);
    $("#municipio").val("");
    $("#descripcion_institucion").val("");
    $("#beneficiario").val("");
    $("#cedula_beneficiario").val("");
    $("#parentesco").val("0");
    $("#cedula_autorizado").val("");
    $("#autorizado").val("");
}

function calculomensual(){
    if($("#salarioaux").val() != "0" && $("#mensualidades").val() != "0")
        $("#monto_total").val($("#salarioaux").val() * $("#mensualidades").val());

    else{
        $("#monto_total").val(0);
    }
}
