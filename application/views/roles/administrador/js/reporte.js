$('#reporte').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);

$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#btnImrimir").focus();
  }
});

function Consultar(){
	
    var t = $('#reporte').DataTable();

    var val = $("#id").val();
    ruta = sUrlP + "consultarBeneficiario/" + val;  

    t.clear().draw();

    $.getJSON(ruta, function(data) {
        var nombre = data.nombres + ' ' + data.apellidos;
        var componente = data.Componente.descripcion;
        var grado = data.Componente.Grado.nombre;
                
        var sBoton = '<div class="btn-group">';
        var sAcciones = '';

        switch (data.estatus_activo) {
            case '201':
                sBoton += '<button type="button" class="btn btn-warning" title="Paralizar" onclick="ventana(\'paralizar\')"><i class="fa fa-lock" ></i></button>';                                
                sBoton += '</button>';
                sBoton += '<button type="button" class="btn btn-danger" title="Retirar" onclick="ventana(\'retirar\')"><i class="fa fa-ban" ></i></button>';                                
                sBoton += '</button>';
                break;
            case '202':
                sBoton += '<button type="button" class="btn btn-primary" title="Activar" onclick="ventana(\'activar\')"><i class="fa fa-rotate-left" ></i></button>';                                
                sBoton += '</button>';
                break;
            case '203':
                
                break;
            case '204':
                break;
            case '205':
                sBoton += '<button type="button" class="btn btn-success" title="Desparalizar" onclick="ventana(\'activar\')"><i class="fa fa-unlock-alt" ></i></button>';                                
                sBoton += '</button>';
                break;
            default:
                break;
        }

        sBoton += sAcciones + '</div>';        



        t.row.add( [
            sBoton,
            data.cedula,
            grado,
            componente,
            nombre,
            data.numero_cuenta,
            data.Calculo['asignacion_antiguedad'],
            data.fecha_ingreso,
            data.estatus_descripcion
        ] ).draw( false );
        //ConsultarHistorialBeneficiario();

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {

        alert('Beneficiario no esta registrado');
    });
}

function ventana(fn){
    
    var boton = '<button type="button" class="btn btn-danger pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;No&nbsp;&nbsp;</button>';
        boton += '<button type="button" class="btn btn-success" onclick="' + fn + '()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si&nbsp;&nbsp;</button>';
    $("#divContinuar").html(boton);
    texto = 'Esta seguro que desea ' + fn + ' este beneficiario<br><br><input type="text" id="txtObservacion" ';
    texto += 'class="form-control" placeholder="Observaciones" >'; 
    $("#txtMensaje").html(texto); 
    $("#logMensaje").modal('show');
    
}

function continuar(){
    $("#logMensaje").modal('hide');
}

function paralizar(){
    var Paralizar = {};
    Paralizar['id'] = $("#id").val();
    Paralizar['motivo'] = $("#txtObservacion").val();
    Paralizar['estatus'] = '205';
    
    var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
    
    $("#divContinuar").html(boton);
    
    $.ajax({
              url: sUrlP + "paralizarDesparalizar",
              type: "POST",
              data: {'data' : JSON.stringify({
                Paralizar: Paralizar
              })},
              success: function (data) {  
               
                $("#txtMensaje").html(data);             
                $("#logMensaje").modal('show');
               
              },
              error: function(data){ 
               
                $("#txtMensaje").html(data); 
                $("#logMensaje").modal('show');
                 
              }
            });
    limpiar();
 
}

function retirar(){
    var Paralizar = {};
    Paralizar['id'] = $("#id").val();
    Paralizar['motivo'] = cargarFechaSlash($("#txtObservacion").val());
    Paralizar['estatus'] = '202';
    
    var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
    
    $("#divContinuar").html(boton);
    
    $.ajax({
              url: sUrlP + "paralizarDesparalizar",
              type: "POST",
              data: {'data' : JSON.stringify({
                Paralizar: Paralizar
              })},
              success: function (data) {  
               
                $("#txtMensaje").html(data);             
                $("#logMensaje").modal('show');
               
              },
              error: function(data){ 
               
                $("#txtMensaje").html(data); 
                $("#logMensaje").modal('show');
                 
              }
            });
    limpiar();
 
}

function cargarFechaSlash(fecha){
    if(fecha != null){
      var f = fecha.split('/');
      return f[2] + '-' + f[1] + '-' + f[0];
    }
}

function activar(){
    var Paralizar = {};
    Paralizar['id'] = $("#id").val();
    Paralizar['motivo'] = '';
    Paralizar['estatus'] = '201';
    
    var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
    
    $("#divContinuar").html(boton);
    
    $.ajax({
              url: sUrlP + "paralizarDesparalizar",
              type: "POST",
              data: {'data' : JSON.stringify({
                Paralizar: Paralizar
              })},
              success: function (data) {  
               
                $("#txtMensaje").html(data);             
                $("#logMensaje").modal('show');
               
              },
              error: function(data){ 
               
                $("#txtMensaje").html(data); 
                $("#logMensaje").modal('show');
                 
              }
            });
    limpiar();
 
}



function limpiar(){
    $("#id").val('');
    var t = $('#reporte').DataTable();
    t.clear().draw();
    


}