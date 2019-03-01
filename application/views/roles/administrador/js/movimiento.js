/**
* Reporte de Movimientos
*/

$('#reporteAnticipo').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);


function cargarFechaSlash(fecha){
    var f = fecha.split('/');
    return f[2] + '-' + f[1] + '-' + f[0];
}


function consultar(){
	var ruta = sUrlP + "lstAnticipoFecha";
	var desde = cargarFechaSlash($("#datepicker").val());
	var hasta = cargarFechaSlash($("#datepicker1").val());
	var componente = $("#componente option:selected").val();

	$.ajax({
          type: "POST",
          //contentType: "application/json",
          dataType: "json",
          data: {'data' : JSON.stringify({
            desde: desde, //Cedula de Identidad
            hasta: hasta, //5 Formato Moneda
            componente: componente, //9 Formato Moneda   
          })},
          url: ruta,
          success: function (data){  
          	
            listar(data);
            


          },
          error: function(data){
            $("#txtMensaje").html(data); 
            var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuarMovimiento()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
            $("#divContinuar").html(boton);

            $("#txtMensaje").html('Err. al procesar el finiquito'); 
            $("#logMensaje").modal('show');

          }
        });

}

function listar(data){
	var t = $('#reporteAnticipo').DataTable();
	var i = 0;
	var total = 0;
    t.clear().draw();
	$.each(data, function ( clv, valores ){
		i++;
		total += Number(valores.monto);
		monto = Number(valores.monto);
		nombre = valores.nombre + ' ' + valores.apellido;
 		t.row.add( [
            i,
            valores.grado,
            nombre,
            valores.cedula_afiliado,
            monto.formatMoney(2, ',', '.')
        ] ).draw( false );
    });
    $("#lblMonto").text(total.formatMoney(2, ',', '.'));
	
}

function Imprimir(){
	var desde = cargarFechaSlash($("#datepicker").val());
	var hasta = cargarFechaSlash($("#datepicker1").val());
	var componente = $("#componente option:selected").val();

  URL = sUrlP + "impirmirAnticiposReportes/" + desde + '/' + hasta + '/' + componente + "/" + $("#componente option:selected").text();
  window.open(URL,"Reporte de Anticipos","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function CartaFinanzas(){
  var desde = cargarFechaSlash($("#datepicker").val());
  var hasta = cargarFechaSlash($("#datepicker1").val());
  var componente = $("#componente option:selected").val();

  URL = sUrlP + "cartaFinanzas/" + desde + '/' + hasta + '/' + componente;
  window.open(URL,"Carta Finanzas","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}


function continuarMovimiento(){
	$("#logMensaje").modal('hide');
}
