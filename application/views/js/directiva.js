var t = $('#reportedirectiva').DataTable({
        "paging":   true,
        "ordering": false,
        "info":     false,
        "searching": true
    }
);

function ConsultarID(){
	var id = $("#directiva option:selected").val();
	var f_v = '';
	var f_i = '';
	ruta = sUrlP + "ListarEditarDirectiva/" + id;
    t.clear().draw();    
	$.getJSON(ruta, function (data){
		$.each(data, function (p,q){
			//console.log(q);
			f_v = q.f_vigencia;
			f_i = q.f_inicio;
			monto = Number(q.sueldo_base);
			var sBoton = '<div class="btn-group">';
            sBoton += '<button type="button" class="btn btn-success" title="Imprimir" \
            			onclick="Editar(' + q.id + ',\'' + q.descripcion + '\',' + q.anio + ',' + q.sueldo_base + ',' + q.udad_tributaria + ')"><i class="fa fa-edit" ></i></button>';
       		sBoton += '</div>';
			t.row.add( [
                    sBoton,                     
                    q.descripcion,
                    q.anio,
                    monto.formatMoney(2, ',', '.'),
                    q.udad_tributaria                  
                ] ).draw( false );
				
		});
		$("#f_ini").val(cargarFecha(f_i));
		$("#f_ven").val(cargarFecha(f_v));

	});

	 $('#reportedirectiva').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );
}

function cargarFecha(fecha){
    if(fecha != null){
      var f = fecha.split('-');
      return f[2] + '/' + f[1] + '/' + f[0];
    }
}

function Editar(id, desc, anio, sb, uni){
	$("#DivEditor").modal("show");
	$("#codigo").val(id);
	$("#grado").val(desc);
	$("#anio").val(anio);
	$("#unidad").val(uni);
	$("#sueldo").val(sb);
}

function Actualizar(){
	id = $("#codigo").val();
	desc = $("#grado").val();
	anio = $("#anio").val();
	uni = $("#unidad").val();
	sb = $("#sueldo").val();
	data = JSON.stringify({
		id : id,
		desc: desc,
		an: anio,
		uni: uni,
		sb: sb
	});
	ruta = sUrlP + "ActualizarEditarDirectiva/";
	
	$.post(ruta, {data: data}, function(data){
		console.log(data);
	}).fail(function (data){

	});
}


function Clonar(){
	id = $("#directiva").val();
	nombre = $("#nombre").val();
	observacion = $("#observacion").val();
	motivo = $("#motivo").val();

	fecha_vigencia = $("#datepicker1").val();
	fecha_inicio = $("#datepicker2").val();
	unidad_tributaria = $("#unidad_tributaria").val();
	porcentaje = $("#porcentaje").val();

	data = JSON.stringify({
		id : id,
		nombre: nombre,
		observacion: observacion,
		numero: motivo,		
		fecha_inicio: fecha_inicio,
		fecha_vigencia: fecha_vigencia,
		unidad_tributaria: unidad_tributaria,
		porcentaje: porcentaje
	});
	ruta = sUrlP + "ClonarDirectiva/";
	
	$.post(ruta, {data: data}, function(data){
		Redirigir();
	}).fail(function (data){
		console.log("Error de Consulta");
	});
}

function EliminarShow(){

	if($("#directiva").val() == "0"){
		$("#txtMensaje").html('Debe seleccionar una directiva');
		var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar&nbsp;&nbsp;</button>';
        $("#divContinuar").html(boton);
    	$("#logMensaje").modal('show');
		return false;
	}
	$("#txtMensaje").html('Esta seguro que desea Eliminar la Directiva');    
	var boton = '<button type="button" class="btn btn-danger pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;No&nbsp;&nbsp;</button>';
        boton += '<button type="button" class="btn btn-success" onclick="Eliminar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si&nbsp;&nbsp;</button>';
	$("#divContinuar").html(boton);
	$("#logMensaje").modal('show');
}

function Eliminar(){

	$("#logMensaje").modal('hide');
	data = JSON.stringify({
		id : $("#directiva").val()
	});
	ruta = sUrlP + "EliminarDirectiva";
	
	$.post(ruta, {data: data}, function(data){
		Redirigir();
	}).fail(function (data){
		console.log(data);
	});
}


function Cacelar(){
	$("#DivEditor").modal("hide");
	$("#DivClone").modal("hide");
}

function ClonarShow(){
	$("#DivClone").modal("show");
}

function Redirigir(){
	URL = sUrlP + "directiva/";
    $(location).attr('href', URL);
}

function continuar(){
	$("#logMensaje").modal('hide');
}