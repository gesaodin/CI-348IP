function actualizarClave(){

    var val = $("#clave").val();

    if(val != ''){
	    ruta = sUrlP + "actualizarClave/" + val;
	    $.get(ruta, function(data) {
	        var boton = '<button type="button" class="btn btn-success pull-right" onclick="principal()">';
	            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Ok</button>';
	        $("#divContinuar").html(boton);
	        $("#txtMensaje").html(data); 
	        $("#logMensaje").modal('show');
	        $("#controles").hide();
	        $("#clave").val('');

	    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
	        
	    });

    }
}

