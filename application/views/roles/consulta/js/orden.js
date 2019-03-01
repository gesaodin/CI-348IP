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
 	  console.log(data);
        $("#cedula").val(data.cedula);
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#componente").val(data.Componente.nombre);
        $("#grado").val(data.Componente.Grado.nombre);
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
        if(valor.estatus == 101){
           	sBoton += '<button type="button" class="btn btn-success" title="Ejecutar" onclick="ejecutar(\'' + valor.id + '\')"><i class="fa fa-cogs" ></i></button>';      
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
	$.each(HistorialOrdenPagos, function (clave, valor){
		if(id == valor.id){
	        var monto = Number(valor.monto);
	        $("#oid").val(valor.id);
	        $("#fecha").val(valor.fecha);
	        $("#monto").val(valor.monto);
            $("#motivo").val(valor.motivo);
	        $("#emisor").val(valor.emisor);
	        $("#revision").val(valor.revision);
	        $("#autoriza").val(valor.autoriza);
    	}
    });
	$("#frmOrden").modal('show');
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

function ejecutarAnticipo(){
	ruta = sUrlP + "ejecutarAnticipo";
    i_d = $("#cedula").val(); //
    t_an = $("#monto").val(); //Monto Por Deuda
    t_e = 0;
    m_d = 0; //Monto Por Deuda
    a_i = 0; //Ajuste PorInteres
    t_b = 0; //Total en Banco
    t_bx = 0; //Total en Banco
    a_a = 0; //Diferencia Asignación Antiguedad
    a_ax = 0; //Diferencia Asignación Antiguedad
    p_p = 1; //Partida Presupuestaria
    m_f = 31; //Motivo de Finiquito
    m_ft = $("#motivo").val(); //motivo_finiquito

    m_asaf = 0; //motivo_finiquito   

    o_b = $("#oid").val(); //Observaciones -> CODIGO ID POSTGRES ORDEN DE PAGO
    f_r = $("#fecha").val(); //Fecha Retiro
    
    m_r = 0; //Monto a Recuperar
    m_rx = 0; //Monto a Recuperar

    emi = $("#emisor").val();
    rev = $("#revision").val();
    aut = $("#autoriza").val();

    $.ajax({
      type: "POST",
      //contentType: "application/json",
      //dataType: "json",
      data: {'data' : JSON.stringify({
        i_d: i_d, //Cedula de Identidad
        t_an : t_an, //5 Anticipos
        t_b: t_b, //9 Formato Moneda
        t_bx: t_bx, //9 Fomato Cientifico
        a_i: a_i, //10
        a_a: a_a, //14 Formato Moneda       
        a_ax: a_ax, //14 Fomato Cientifico
        m_d: m_d, //15
        m_r: m_r, //16
        m_rx: m_rx, //16 Fomato Cientifico
        o_b: o_b,
        f_r: f_r,
        p_p: p_p,
        m_f: m_f,
        m_ft: m_ft,
        m_asaf: m_asaf,
        emi: emi,
        rev: rev,
        aut: aut
              
      })},
      url: ruta,
      success: function (data) {  
        //console.log(data);      
        //alert(data);
        //$("#txtMensaje").html(data);
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
    URL = sUrlP + "ordenpago";
    $(location).attr('href', URL);;
}