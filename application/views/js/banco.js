$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {    
    $("#numero_cuenta").focus();
  }
});

function consultar() {

    var val = $("#id").val();
    ruta = sUrlP + "consultarBeneficiario/" + val;
    $.getJSON(ruta, function(data) {
            $("#nombres").val(data.nombres);
            $("#apellidos").val(data.apellidos);
            
            $("#componente").val(data.Componente.nombre);
            $("#grado").val(data.Componente.Grado.nombre);
            console.log(data);

            var numero_cuenta = $("#numero_cuenta").val(data.numero_cuenta.substring(4, data.numero_cuenta.length));
            
                              
        }

    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
       $("#txtMensaje").html('No se encontro cédula de beneficiario'); 
       $("#logMensaje").modal('show');
       limpiar();
    });

}


function continuar(){
    $("#logMensaje").modal('hide');
}


function limpiar(){

    $("#grado").val('');   
    $("#componente").val('');
    $("#nombres").val('');
    $("#apellidos").val('');

    $("#numero_cuenta").val('');

}


function actualizar(){
    var Persona = {};
    var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
    $("#divContinuar").html(boton);

   

    if($("#id").val() == '' ){
        $("#txtMensaje").html('Debe ingresar una cédula de identidad');
        $("#logMensaje").modal('show');
        
    }else{
        Persona['cedula'] = $("#id").val();
        Persona['numero_cuenta'] = $("#codigo_cuenta").val() + $("#numero_cuenta").val();
        
        $.ajax({
              url: sUrlP + "actualizarCuenta",
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
                console.log(data);
                $("#txtMensaje").html(data); 
                $("#logMensaje").modal('show');
                $("#id").val('');

              }
            });
        limpiar();
    }
}