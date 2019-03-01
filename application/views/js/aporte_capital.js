$('#reportearchivos').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);
var _E = false; //Estatus
var _ID = 0; //Id de Instalacion
var _ZIP = ""; //Archivo comprimido
var _DATA = {};


function PrepararIndices(){
	
	var fde = "";
	var fha = "";
    var val = $("#directiva").val();
	verdad = true;
		
	fe = $("#datepicker").val(); //
	

    f = $("#datepicker1").val();
    fx = $("#datepicker2").val();
    if (f != ""){
    	verdad = false;    	
        f = f.split('/');
        fde = f[2] + '-' + f[1] + '-' + f[0];        
        if(fde != ""){        
            fx = fx.split('/');
            if(fx != ""){
                fha = fx[2] + '-' + fx[1] + '-' + fx[0];
            }else {
                $("#txtMensaje").html('Debe seleccionar una fecha limite');
				$("#logMensaje").modal('show');
				return false;
            }
        }else{ //En caso de que no exista fecha desde 
        	if ($('#datepicker1').val() == ""){
				$("#txtMensaje").html('Debe seleccionar una fecha');
				$("#logMensaje").modal('show');
				return false;
			}
	
        }
    }

	if ($('#directiva option:selected').val() == "0"){
		$("#txtMensaje").html('Debe seleccionar una directiva');
		$("#logMensaje").modal('show');
		return false;
	}
	
	
	if (fe == ""){
		$("#txtMensaje").html('Debe seleccionar una fecha');
		$("#logMensaje").modal('show');
		return false;
	}else{
    	fecha = fe.split('/');
    	fe = fecha[2] + '-' + fecha[1] + '-' + fecha[0];
    }



	_DATA = {
		id : val, 
		fe : fe,
		sit: $("#situacion option:selected").val(),
		com: $('#componente option:selected').val(),
	    gra: $('#grado option:selected').val(),
	    fde: fde,
        fha: fha
	};
	boton = CrearBotones();
	$("#divContinuar").html(boton);
    $("#txtMensaje").html('Si ya antes ha generado los indices recientemente no se requiere de generarlos nuevamente. Esta seguro que desea generar los indices, recuerde este proceso puede tardar varios segundos. Por favor espere'); 
    $("#logMensaje").modal('show');
}

function ProcesarIndices(id){

	$("#logMensaje").modal('hide');
	$('#cargando').show();
	sit = $("#situacion option:selected").val();
	$.get(sUrlP + "PrepararIndices/" + id+ "/" + sit).done(function (data){
		$('#obse').val(data.m);
		$('#detalle').show();
		$('#cargando').hide();
		$('#generar').show();
		$('#preparar').hide();

		$("#datepicker").prop('disabled', true);
		$("#datepicker1").prop('disabled', true);
		$("#datepicker2").prop('disabled', true);
		$("#directiva").prop('disabled', true);
		$("#componente").prop('disabled', true);
		$("#grado").prop('disabled', true);
	});

}

function CrearBotones(){
	var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="ProcesarIndices(1)">';
    boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si</button>';
    boton += '<button id="btnContinuar" type="button" class="btn btn-danger" onclick="ProcesarIndices(0)">';
    boton += '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;No</button>';
    return boton;
}

function GenerarAporte(){

	$("#divPendientes").html('<table id="reportearchivos" class="table table-bordered table-hover">\
                        <thead>\
                        <tr>\
                            <th>#</th>\
                            <th style="width: 120px;">Llave del Archivo</th>\
                            <th style="width: 60px;">Registros</th>\
                            <th style="width: 120px;">Fecha</th>\
                            <th>Garantias</th>\
                            <th>Dias Adic.</th>\
                            <th>Asignación A.</th>\
                        </tr>\
                        </thead><tbody></tbody></table>');
	var t = $('#reportearchivos').DataTable();
    t.clear().draw();
	$('#cargando').show();
	
	url = sUrlP + "GenerarCalculoAporteCapital/";
	$.post(url, {data: JSON.stringify(_DATA)}, function (data){
		


		//console.log(data);
		$('#obse').val(data.m);
		$('#generar').hide();
		$('#descargar').show();
		$('#sueldos').show();
		




		_ZIP = data.z;
		
		j = data.json;
		
		var sBoton = '<div class="btn-group">';
        sBoton += '<button id="btnProcesar" type="button" class="btn btn-success pull-right" title="Generar" onclick="Ctxt(\'' + j.c + '\')"><i class="fa fa-database" ></i></button>';                                
        sBoton += '</button>';
	    sBoton + '</div>';  


		
		t.row.add([
				sBoton,
				j.p + ' ' + j.f.substring(0,10) + '...',
				j.l,
				j.t,
				j.g + 'Bs.',
				j.d + 'Bs.',
				j.a + 'Bs.'
			]
		).draw(false);
		
		$('#cargando').hide();
	}).fail(function (err){
		console.log(err);
	});
		

}

function DescargarAportes(){
	location.href = sUrl + 'tmp/' + _ZIP;
}

function DescargarTxt(file, tipo){
	location.href = sUrl + 'tmp/' + file + '/' + file + '.zip';
	
	var boton = '<button type="button" class="btn btn-warning pull-right" onclick="RegistarTxt(\'' + file + '\',' + tipo + ')">';
        boton += '<i class="fa fa-superscript"></i>&nbsp;&nbsp;Ejecutar&nbsp;&nbsp;</button>';
        boton += '<button type="button" class="btn btn-danger" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Cancelar&nbsp;&nbsp;</button>';
    $("#divContinuar").html(boton);
    texto = '¿Desea ejecutar los calculos y registrarlos en la base de datos para luego depositarlos?'; 
    $("#txtMensaje").html(texto); 
    $("#logMensaje").modal('show');
}


function continuar(){
    $("#logMensaje").modal('hide');
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
       $("#txtMensaje").html('No se encontr...');
       $("#logMensaje").modal('show');
       limpiar();
    });
}




function ventana(id, tipo){
    var boton = '<button type="button" class="btn btn-success" onclick="DescargarTxt(\'' + id + '\',' + tipo + ')">';
        boton += '<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Continuar&nbsp;&nbsp;</button>';
    $("#divContinuar").html(boton);
    texto = 'Descargar Archivo de Aporte'; 
    $("#txtMensaje").html(texto); 
    $("#logMensaje").modal('show');
}



function Ctxt(id){
	$("#llave").val(id);
	$("#myModal").modal('show');
}


function CGTxt(id){
	var m = parseInt($("#motivo option:selected").val());
	var id = $("#llave").val();
	if(m != "-"){
		var dato = {
			tipo: m,
			porc: $("#porc").val()
		}
		url = sUrlP + "LoteGarantiaDiasAdicionales/" + id;
		$.post(url, {data: JSON.stringify(dato)}, function (data){
			console.log(data);		
			ventana(data.a, m);
		}).fail(function (err){
			console.log(err);
		});
	}else{
		alert("debe seleccionar un motivo");
	}
}

function RegistarTxt(id, tipo){

	$("#divContinuar").html(''); 
    $("#txtMensaje").html('Por favor espere mientras procesamos los archivos...');

	var dato = {
		id: id,
		tipo: tipo
	}
	console.log(tipo);
	
	url = sUrlP + "CrearTxtMovimientos/" + id;
	$.post(url, {data: JSON.stringify(dato)}, function (data){
		console.log(data);
		urlf = sUrl + 'tmp/' + data.a + '/' + data.aper;
		urlt = sUrl + 'tmp/' + data.a + '/' + data.apor;
		var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Continuar&nbsp;&nbsp;</button>';
	    $("#divContinuar").html(boton);
	    texto = '<a href="' + urlf + '" target="top" class="btn btn-app"><span class="badge bg-green">' + data.caper + '</span><i class="fa fa-edit"></i> Apertura </a>'; 
	    texto += '<a href="' + urlt + '"  target="top" class="btn btn-app"><span class="badge bg-green">' + data.capro + '</span><i class="fa fa-barcode"></i> Aporte </a>'; 
	    $("#txtMensaje").html(texto);
	    	
	}).fail(function (err){
		console.log(err);
	});


}

function GenerarSueldos(){
	
}