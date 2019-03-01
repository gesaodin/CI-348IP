var _ZIP = '';

var _ID = '';

$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#btnImrimir").focus();
  }
});

function Consultar(){
    //if($('#situacion option:selected').val()=="--")return false;
    //if($('#componente option:selected').val()=="--")return false;
    var fde = "";
	var fha = "";
    $('#divreporte').html('');
    var val = $("#id").val();
    _ID = val;

    f = $("#datepicker").val();
    fx = $("#datepicker1").val();
    if (f != ""){
        f = f.split('/');
        fde = f[2] + '-' + f[1] + '-' + f[0];        
        if(fde != ""){        
            fx = fx.split('/');
            if(fx != ""){
                fha = fx[2] + '-' + fx[1] + '-' + fx[0];
            }else {
                fha = fde;
            }
        }
    }
 
    ruta = sUrlP + "consultarBeneficiario/" + val; 
    data = JSON.stringify({
        id:  $("#id").val(),
        nom: $('#nombre').val(),
        sit: $('#situacion option:selected').val(),
        com: $('#componente option:selected').val(),
        gra: $('#grado option:selected').val(),
        fde: fde,
        fha: fha
    });
    
    $('#cargando').show();
  
    if(val == "") ruta = sUrlP + "ConsultarGrupos"; 
    
    $.post(ruta, {data:data}, function(data) {
       
        $('#cargando').hide();
        if (data.cedula != undefined){
            TablaIndividual(data);
        }
        if (data[0].file != undefined){            
            location.href = sUrl + 'tmp/' + data[0].file;  
        }else{

            if(fde != '' || $('#nombre').val() != ''){
                TablaGruposNombreFecha(data);
            }else{     
                TablaGrupos(data);

            }
       
        }
        

     
    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        console.log(jqXHR.responseText);
        $('#cargando').hide();
        alert('Beneficiario no esta registrado');

    });
   
}

function DescargarReporte(){
    location.href = sUrl + 'tmp/' + _ZIP;
}


function TablaIndividual(data){
    tabla = '<table id="reporte" class="table table-bordered table-hover"><thead><tr><th>Acciones</th>';
    tabla += '<th>Cédula</th><th>Grado</th><th>Componente</th><th>Beneficiario</th><th>Cuenta</th>';
    tabla += '<th>Asig. Ant.</th><th>Fecha de Ingreso</th><th>Situación</th></tr></thead></table>';
    $('#divreporte').html(tabla);
    var t = $('#reporte').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    });    
    t.clear().draw();

    var nombre = data.nombres + ' ' + data.apellidos;
    var componente = data.Componente.descripcion;
    var grado = data.Componente.Grado.nombre;            
    t.row.add( [
        HacerBotones(data.estatus_activo),
        data.cedula,
        grado,
        componente,
        nombre,
        data.numero_cuenta,
        data.Calculo['asignacion_antiguedad'],
        data.fecha_ingreso,
        data.estatus_descripcion
    ] ).draw( false );

    vBtn();
}

function HacerBotones(estatus){
    var sBoton = '<div class="btn-group">';
    switch (estatus) {
        case '201':
            sBoton += '<button id="btnParalizar" type="button" class="btn btn-warning" title="Paralizar" onclick="ventana(\'paralizar\')"><i class="fa fa-lock" ></i></button>';                                
            sBoton += '</button>';
            sBoton += '<button  id="btnRetirar" type="button" class="btn btn-danger" title="Retirar" onclick="ventana(\'retirar\')"><i class="fa fa-ban" ></i></button>';                                
            sBoton += '</button>';
            break;
        case '202':
            sBoton += '<button id="btnActivar"  type="button" class="btn btn-primary" title="Activar" onclick="ventana(\'activar\')"><i class="fa fa-rotate-left" ></i></button>';                                
            sBoton += '</button>';
            break;
        case '203':
            
            break;
        case '204':
            break;
        case '205':
            sBoton += '<button id="btnDesParalizar" type="button" class="btn btn-success" title="Desparalizar" onclick="ventana(\'activar\')"><i class="fa fa-unlock-alt" ></i></button>';                                
            sBoton += '</button>';
            break;
        default:
            break;
    }

    return sBoton + '</div>';  

}

function TablaGrupos(data){
    tabla = '<table id="reporte" class="table table-bordered table-hover"><thead><tr>';
    tabla += '<th>Cédula</th><th>Grado</th><th>Componente</th><th style="width:250px">Beneficiario</th>';
    tabla += '<th>T. Serv.</th><th>S. Mensual.</th><th>S. Int</th></tr></thead></table>';
    $('#divreporte').html(tabla);
    var t = $('#reporte').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "searching": true
    });    
    t.clear().draw();
    
    $.each(data, function (c, v){
       t.row.add( [
            v.ced,            
            v.gra,
            v.com, 
            v.nom,
            v.tse,
            v.sme,
            v.sin            
        ] ).draw( false );
    
    });
    

}

function TablaGruposNombreFecha(data){
    tabla = '<table id="reporte" class="table table-bordered table-hover"><thead><tr>';
    tabla += '<th>Cédula</th><th style="width:350px">Beneficiario</th>';
    tabla += '<th>Fecha Ingreso</th></tr></thead></table>';
    $('#divreporte').html(tabla);
    var t = $('#reporte').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "searching": true
    });    
    t.clear().draw();
    
    $.each(data, function (c, v){
       t.row.add( [
            v.ced, 
            v.nom,          
            v.fin
        ] ).draw( false );

    });

}

function cargarGrado(){
    $("#grado").html('');
    $("#grado").append('<option value=99>Todos los grados</option>');

    id = $("#componente option:selected").val();
    ruta = sUrlP + "cargarGradoComponente/" + id;

    $.getJSON(ruta, function(data) {    
        $.each(data, function(d, v){
            var opt = new Option(v.nombre, v.codigo);
            $("#grado").append(opt);
        });
    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontro cédula de beneficiario');
       $("#logMensaje").modal('show');
       limpiar();
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
    Paralizar['id'] = _ID;
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
    Paralizar['id'] =  _ID;
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
    Paralizar['id'] = _ID;
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