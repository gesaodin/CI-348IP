var HistorialOrdenPagos = {};

$('#reporteOrdenes').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);



$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#btnConsultar").focus();
  }
});


function consultar() {
    var val = $("#id").val();
    ruta = sUrlP + "consultarBeneficiario/" + val;
    $.getJSON(ruta, function(data) {
        
        $("#id_aux").val(data.cedula);
        HistorialOrdenPagos = data.HistorialOrdenPagos;    	
        listar();

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        $("#id").val('');
        var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
        $("#divContinuar").html(boton);
        $("#txtMensaje").html('El Beneficiario que intenta consultar no se encuentra en nuestra base de datos'); 
        $("#logMensaje").modal('show');
        $("#controles").hide();
    });

}

function listar(){
    var t = $('#reporteOrdenes').DataTable();
    t.clear().draw();
    $.each(HistorialOrdenPagos, function (clave, valor){
        var monto = Number(valor.monto);
        nombre = valor.nombre + ' ' + valor.apellido;        
        var sBoton = '<div class="btn-group">';
        if(valor.estatus == 100 && valor.ultima_observacion != ''){
           	if(valor.movimiento == 0 )sBoton += '<button type="button" class="btn btn-danger" title="Reversar" onclick="ejecutar(\'' + valor.ultima_observacion + '\')"><i class="fa fa-random" ></i></button>';      
	        sBoton += '</div>';   	  

	        t.row.add( [
	            sBoton,
	            valor.cedula_beneficiario,
	            nombre,	         
	            valor.fecha,
	            monto.formatMoney(2, ',', '.'),
	            valor.motivo	            
	        ] ).draw( false );
    	}
    });
}

function ejecutar(id){
	
	var boton = '<button type="button" class="btn btn-danger pull-right" onclick="continuar()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;No</button>';
            boton += '<button type="button" class="btn btn-success" onclick="continuarReverso(\'' + id + '\')">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si</button>';
        $("#divContinuar").html(boton);        
        $("#txtMensaje").html('Está seguro que desea efectuar el reverso'); 
        $("#logMensaje").modal('show');
}

function estatus(cod){
    var texto = '';
    switch (cod){
        case '100': 
            texto = 'EJECUTADA';
            break;
        case '101': 
            texto = 'PENDIENTE';
            break;
        case '102': 
            texto = 'RECHAZADA';
            break;
        case '103': 
            texto = 'REVERSADA';
            break;
    }
    return texto;
}

function continuar(){
    $("#logMensaje").modal('hide');
}

function continuarReverso(id){
	ruta = sUrlP + "reversarAnticipo";
    cedula = $("#id_aux").val();
    $.ajax({
      type: "POST",
      data: {'data' : JSON.stringify({
        certificado: id, //Cedula de Identidad       
        cedula: cedula,
        estatus: 103              
      })},
      url: ruta,
      success: function (data) {  
        $("#txtMensaje").html(data); 
        var boton = '<button type="button" class="btn btn-success pull-right" onclick="recargar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar Anticipo</button>';
        $("#divContinuar").html(boton);
        $("#logMensaje").modal('show');

      },
      error: function(data){ 
        var boton = '<button type="button" class="btn btn-success pull-right" onclick="recargar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar Anticipo</button>';
        $("#divContinuar").html(boton);

        $("#txtMensaje").html('Err. al procesar el finiquito'); 
        $("#logMensaje").modal('show');

      }
    });
}

function recargar(){
    URL = sUrlP + "ordenpagoejecutada";
    $(location).attr('href', URL);;
}