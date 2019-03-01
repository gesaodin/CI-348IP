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
        $("#numero_cuenta").val(data.numero_cuenta);
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
    console.log(data);
    $.each(data, function (clave, valor){
        var monto = Number(valor.monto);
        var sBoton = '<div class="btn-group">';
        var sAcciones = '';        
        sBoton += '<button type="button" class="btn btn-success" title="Ver Detalles"><i class="fa fa-search" ></i></button>'; 
        switch (valor.estatus){
            case '220':
                sBoton += '<button type="button" class="btn btn-warning" title="Inactivar"><i class="fa fa-mail-reply-all" ></i></button>';
                //sBoton += '<button type="button" class="btn btn-info" title="Ejecutar"><i class="fa fa-cogs" ></i></button>'; 
                sBoton += '<button type="button" class="btn btn-info" title="Imprimir" onclick="imprimir(\'' + valor.id + '\')"><i class="fa fa-print" ></i></button>'; 
                break;
            case '221':
                break;
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
            valor.estado
        ] ).draw( false );
        
    });
}

function continuar(){
    $("#logMensaje").modal('hide');
}


function imprimir(id){
    var val = $("#id").val();
    URL = sUrlP + "medida_judicial/" + val +  '/' + id;
    window.open(URL,"Hoja de Vida","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
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

    $.getJSON(ruta, function(data) {
        $.each(data, function(d, v){            
            var opt = new Option(v.nombre, v.id);
            $("#ciudad").append(opt);
            i = v.id;
        });
        obtenerMunicipiosID(i);

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontraron ciudades'); 
       $("#logMensaje").modal('show');
    });
}

function obtenerMunicipios(){
    id = $("#ciudad option:selected").val();
    obtenerMunicipiosID(id);
}

function obtenerMunicipiosID(id){
    ruta = sUrlP + "obtenerMunicipios/" + id;
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
    MedidaJudicial['salario'] = $("#salario").val();
    MedidaJudicial['ut'] = $("#ut").val();
    MedidaJudicial['monto'] = $("#monto_total").val();
    MedidaJudicial['forma_pago'] = $("#forma_pago option:selected").val();
    MedidaJudicial['institucion'] = $("#institucion").val();
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

    cargar();
    
    $("#myModal").modal('hide');
    $.ajax({
              url: sUrlP + "crearMedidaJudicial",
              type: "POST",
              data: {'data' : JSON.stringify({
                MedidaJudicial: MedidaJudicial      
              })},
              success: function (data) { 
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
}

function cargarFechaSlash(fecha){
    if(fecha != null){
      var f = fecha.split('/');
      return f[2] + '-' + f[1] + '-' + f[0];
    }
}

function recargar(){
    URL = sUrlP + "medidajudicial";
    $(location).attr('href', URL);
}