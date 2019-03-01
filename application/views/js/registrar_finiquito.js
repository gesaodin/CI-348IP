/**
* Fallecimiento en acto de servicio o Fuera
*/
var iFamiliares = 0;
var lstFamiliares = {};
var fallecimiento_actoservicio = 0; //Acto de Servicio
var fallecimiento_fueraservicio = 0; //Fuera de Servicio

$( "#id" ).keypress(function( event ) {
  if ( event.which == 13 ) {
    $("#motivo_finiquito").focus();
  }
});

$('#reporteFiniquitos').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);




function consultar() {
    var val = $("#id").val();
    $("#lblMedida").text('');
    ruta = sUrlP + "consultarBeneficiario/" + val;

    iFamiliares = 0;
    //console.log(ruta);
    $.getJSON(ruta, function(data) {

        
        //if(data.fecha_retiro != null && data.fecha_retiro != '' || data.estatus == 205){
        //alert(data.estatus_descripcion);
        if(data.estatus_descripcion != 'Activo'){
            $("#id").val('');
            var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
            $("#divContinuar").html(boton);
                if(data.estatus_descripcion == 'Paralizado'){
                    $("#txtMensaje").html('El Beneficiario que intenta consultar se encuentra paralizado'); 
                }else{ 
                      $("#txtMensaje").html('El Beneficiario que intenta consultar se encuentra retirado, por favor consultarlo por finiquito'); 
                    }
            $("#logMensaje").modal('show');
            $("#controles").hide();
            limpiar();
        }else{
            $("#nombres").val(data.nombres);
            $("#apellidos").val(data.apellidos);
            $("#sexo").val(data.sexo);
            $("#componente").val(data.Componente.nombre);
            $("#grado").val(data.Componente.Grado.nombre);
            $("#fingreso").val(data.fecha_ingreso);
            if(data.fecha_retiro != null && data.fecha_retiro != '') {
                   $("#tservicio").val(data.tiempo_servicio_aux);
            }else{
                    $("#tservicio").val(data.tiempo_servicio);
            }
            $("#nhijos").val(data.numero_hijos);
            $("#fuascenso").val(data.fecha_ultimo_ascenso);
            $("#noascenso").val(data.no_ascenso);
            $("#profesionalizacion").val(data.profesionalizacion);
            $("#arec").val(data.ano_reconocido);
            $("#mrec").val(data.mes_reconocido);    
            $("#drec").val(data.dia_reconocido);
            $("#fecha_retiro").val(data.fecha_retiro);
            $("#fano").val(data.aguinaldos_aux);
            $("#vacaciones").val(data.vacaciones_aux);
            $("#numero_cuenta").val(data.numero_cuenta);
            $("#estatus").val(data.estatus_descripcion);

            
            fallecimiento_actoservicio = data.Calculo.fallecimiento_actoservicio_aux;
            fallecimiento_fueraservicio = data.Calculo.fallecimiento_fueraservicio_aux;
            $("#controles").show();

            $.each(data.MedidaJudicialActiva, function (clave, valor){
                $("#lblMedida").text('Beneficiario con Medidas Judiciales');

            });
        }

    }).done(function(msg) {

    }).fail(function(jqXHR, textStatus) {
        consultarSAMAN();        
    });

}
function consultarSAMAN(){
    var val = $("#id").val();
    ruta = sUrlP + "cargarMilitarSAMAN/" + val;
    $.getJSON(ruta, function(data) {
        if(data.cedula != null){
            var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="insertarSAMAN()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si</button>';
            boton += '<button id="btnContinuar" type="button" class="btn btn-danger" onclick="continuar()">';
            boton += '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;No</button>';

            $("#divContinuar").html(boton);
            $("#txtMensaje").html('El beneficiario que intenta consultar se encontro en SAMAN desdea importarlo a PACE'); 
            $("#logMensaje").modal('show');
            $("#controles").hide();
            $("#btnContinuar").focus();
        }else{
            console.log('No se encontro registro');
        }

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        $("#id").val('');
        var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
        $("#divContinuar").html(boton);
        $("#txtMensaje").html('El Beneficiario que intenta consultar no se encuentra en nuestra base de datos'); 
        $("#logMensaje").modal('show');
        $("#controles").hide();
        $("#btnContinuar").focus();

        limpiar();
        
        
    });
}
function insertarSAMAN(){
    var val = $("#id").val();
    ruta = sUrlP + "cargarMilitarSAMAN/" + val + '/1';
    
    $.getJSON(ruta, function(data) {
        var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="actualizarBeneficiario()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si</button>';

        $("#divContinuar").html(boton);
        $("#txtMensaje").html('Debe actualizar los datos del nuevo beneficiario para poder efectuar los calculos'); 
        $("#logMensaje").modal('show');
        $("#controles").hide();
        $("#btnContinuar").focus();

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        $("#id").val('');
        var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar</button>';
        $("#divContinuar").html(boton);
        $("#txtMensaje").html('No se logro recuperar los datos desde SAMAN o se perdio la conexion con el servidor SAMAN'); 
        $("#logMensaje").modal('show');
        $("#controles").hide();
        $("#btnContinuar").focus();

        limpiar();
        
        
    });
}

function actualizarBeneficiario(){
    var val = $("#id").val();
    URL = sUrlP + "actualizar/" + val;
    $(location).attr('href', URL);
}

function limpiar(){
    $("#nombres").val('');
    $("#apellidos").val('');
    $("#sexo").val('');
    $("#componente").val('');
    $("#grado").val('');
    $("#fingreso").val('');
    $("#tservicio").val('');
    $("#nhijos").val('');
    $("#fuascenso").val('');
    $("#noascenso").val('');
    $("#profesionalizacion").val('');
    $("#arec").val('');
    $("#mrec").val('');    
    $("#drec").val('');
    $("#fecha_retiro").val('');
    $("#fano").val('');
    $("#vacaciones").val('');
    $("#numero_cuenta").val('');
    $("#estatus").val('');
}

/**
*   Permite Realizar Carga Familiar
*   Segun sea el caso > 8 y menor que 11 en la 
*   tabla motivo (id)
*   @return html
*/
function seleccionarMotivo(){
    var motivo = $("#motivo_finiquito option:selected").val();

    if(motivo > 8 && motivo < 11){

        $("#monto_asignacion").val(fallecimiento_actoservicio);
        $("#monto_asignacion_aux").val(fallecimiento_actoservicio);
        
        if(motivo == 9 ) {
            $("#monto_asignacion").val(fallecimiento_fueraservicio);
            $("#monto_asignacion_aux").val(fallecimiento_fueraservicio);

        }else{
            
            $("#asignacion_causa").val('36,00');
            $("#asignacion_causa_aux").val('36.00');
        }

        
        var val = $("#id").val();
        ruta = sUrlP + "obtenerFamiliares/" + val;    
        $.getJSON(ruta, function(data) {    
            sBoton = '<center><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;Agregar Familiar</button>';
            sTable = sBoton + '<br>';
            sTable += '<TABLE id="dbFamiliares" class="display compact table table-striped table-bordered" width="100%" cellspacing="0">';
            sTable += '<THEAD><TR>';
            sTable += '<TH>#</TH>';
            sTable += '<TH>Cedula</TH>';
            sTable += '<TH>Nombre</TH>';
            sTable += '<TH>Parentesco</TH>';
            sTable += '<TH>DIST. C.B</TH>';
            sTable += '<TH>Capital Banco</TH>';
            sTable += '<TH>Monto Dif. A.A.</TH>';
            sTable += '<TH>DIST. M.</TH>';
            sTable += '<TH>M. Act. Serv.</TH>';
            //sTable += '<TH>Dist.C.M</TH>';
            sTable += '<TH>C.M</TH>';
            //sTable += '<TH>OPCIONES</TH>';
            sTable += '</TR></THEAD>';
            sCuerpo = '<TBODY>';
            $.each(data, function ( clv, valores ){

                iFamiliares++;
                sCuerpo += '<TR>';
                sCuerpo += '<TH><label id="lblPosicion' + iFamiliares + '">' + iFamiliares + '</label></TH>';
                sCuerpo += '<TH><label id="lblCedula' + iFamiliares + '">' + valores.cedula + '</label></TH>';
                sCuerpo += '<TD><label id="lblNombre' + iFamiliares + '">' + valores.nombre + '</label></TD>';
                sCuerpo += '<TD><label id="lblParentesco' + iFamiliares + '">' + valores.parentesco + '</label></TD>';
                //Input
                sCuerpo += '<TD><div class="input-group"><input class="form-control" style="width:50px" type="text" id="txtAA' + iFamiliares + '">';
                sCuerpo += '<span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="CalcularAA(' + iFamiliares + ')">';
                sCuerpo += '<i class="fa fa-calculator"></i></button></span> </div></TD>';
                //
                sCuerpo += '<TD style="text-align: right"><label id="lblCapital_aux' + iFamiliares + '">0.00</label><label style="display:none" id="lblCapital' + iFamiliares + '">0.00</label></TD>';
                //Input
                
                sCuerpo += '<TD style="text-align: right"><label id="lblMonto_aux' + iFamiliares + '">0.00</label><label style="display:none" id="lblMonto' + iFamiliares + '">0.00</label></TD>';
                //Input
                sCuerpo += '<TD><div class="input-group"><input class="form-control" style="width:50px" type="text" id="txtM' + iFamiliares + '">';
                sCuerpo += '<span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="CalcularM(' + iFamiliares + ')">';
                sCuerpo += '<i class="fa fa-calculator"></i></button></span> </div></TD>';

                sCuerpo += '<TD style="text-align: right"><label id="lblMAct_aux' + iFamiliares + '">0.00</label><label style="display:none" id="lblMAct' + iFamiliares + '">0.00</label></TD>';
                //Input
                /**
                sCuerpo += '<TD><div class="input-group"><input class="form-control" style="width:50px" type="text" id="txtDist' + iFamiliares + '">';
                sCuerpo += '<span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="CalcularDist(' + iFamiliares + ')">';
                sCuerpo += '<i class="fa fa-calculator"></i></button></span> </div></TD>';
                **/
                //
                sCuerpo += '<TD style="text-align: right"><label id="lblCm_aux' + iFamiliares + '">0.00</label><label style="display:none"  id="lblCm' + iFamiliares + '">0.00</label></TD>';
                //sCuerpo += '<TD>:-X</TD>';
                sCuerpo += '</TR>';
            });
            sTable += sCuerpo + '</TBODY>' + '</TABLE></center>';
            $("#tblFamiliares").html(sTable);
            $('#dbFamiliares').DataTable({
                "paging":   false,
                "ordering": false,
                "info":     false,
                "searching": false
                }
            );
            
        }

        ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
            console.log(jqXHR);
        });
    }else{
        iFamiliares = 0;
        $("#tblFamiliares").html('');
    }


}

function CalcularAA(id){

    var suma = 0;
    var calcCapital = parseFloat($("#total_banco_calc").val());
    var calcDiferencia = parseFloat($("#asignacion_diferencia_aux").val()); 
    var calcMontoCM = parseFloat($("#asignacion_causa_aux").val()); 
    
    for (var i = 1; i <= iFamiliares; i++) {
        if($("#txtAA" + i).val() != ""){
            var por = parseFloat($("#txtAA" + i).val());      
            suma += por;    
        }
    }

    if(suma <= 100){
        var porcentaje = Number($("#txtAA" + id).val());
        var resultadoCapital = (calcCapital * porcentaje) / 100;
        var resultadoDiferencia = (calcDiferencia * porcentaje) / 100;
        var resultadoMontoAsignacion = (Number(calcMontoCM) * Number(porcentaje)) / 100;

        //------------
        numero = resultadoCapital;
        $("#lblCapital_aux" + id).text(numero.formatMoney(2, ',', '.'));
        $("#lblCapital" + id).text(parseFloat(resultadoCapital).toFixed(2));

        //------------
        numero = resultadoDiferencia;
        $("#lblMonto_aux" + id).text(numero.formatMoney(2, ',', '.'));
        $("#lblMonto" + id).text(parseFloat(resultadoDiferencia).toFixed(2));

        
        //------------
        numero = resultadoMontoAsignacion;
        $("#lblCm_aux" + id).text(numero.formatMoney(2, ',', '.'));
        $("#lblCm" + id).text(parseFloat(resultadoMontoAsignacion).toFixed(2));   

    }else{
        alert('Distribución del porcentaje no puede ser mayor al 100%');
    }
        
}






function CalcularM(id){
    var suma = 0;
    var calcMontoAsignacion = parseFloat($("#monto_asignacion_aux").val());        
    for (var i = 1; i <= iFamiliares; i++) {
        if($("#txtM" + i).val() != ""){
            var por = parseFloat($("#txtM" + i).val());      
            suma += por;    
        }
    }
    if(suma <= 100){
        var porcentaje = $("#txtM" + id).val();
        var resultadoMontoAsignacion = (calcMontoAsignacion * porcentaje) / 100;
        //------------
        numero = resultadoMontoAsignacion;
        $("#lblMAct_aux" + id).text(numero.formatMoney(2, ',', '.'));
        $("#lblMAct" + id).text(parseFloat(resultadoMontoAsignacion).toFixed(2));    
    }else{
        alert('Distribución del porcentaje no puede ser mayor al 100%');
    }
        
}









function registrarFamiliar(){
    var t = $('#dbFamiliares').DataTable();
    var cedula = $('#fcedula').val();
    var nombre = $('#fnombres').val();
    var parentesco = $('#fparentesco').val();

    iFamiliares++;

    sCajaAA = '<div class="input-group"><input class="form-control" style="width:50px" type="text" id="txtAA' + iFamiliares + '"  onblur="CalcularAA(' + iFamiliares + ')">';
    sCajaAA += '<span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="CalcularAA(' + iFamiliares + ')">';
    sCajaAA += '<i class="fa fa-calculator"></i></button></span> </div>';


    sDistM = '<div class="input-group"><input class="form-control" style="width:50px" type="text" id="txtM' + iFamiliares + '" onblur="CalcularM(' + iFamiliares + ')">';
    sDistM += '<span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="CalcularM(' + iFamiliares + ')">';
    sDistM += '<i class="fa fa-calculator"></i></button></span> </div>';


    sDist = '<div class="input-group"><input class="form-control" style="width:50px" type="text" id="txtDist' + iFamiliares + '">';
    sDist += '<span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="CalcularDist(' + iFamiliares + ')">';
    sDist += '<i class="fa fa-calculator"></i></button></span> </div>';


    t.row.add( [
            '<label id="lblPosicion' + iFamiliares + '">' + iFamiliares + '</label>',
            '<label id="lblCedula' + iFamiliares + '">' + cedula + '</label>',
            '<label id="lblNombre' + iFamiliares + '">' + nombre + '</label>',
            '<label id="lblParentesco' + iFamiliares + '">' + parentesco + '</label>',
            sCajaAA,
            '<p style="text-align:right"><label id="lblCapital_aux' + iFamiliares + '">0.00</label><label style="display:none" id="lblCapital' + iFamiliares + '">0.00</label></p>',
            '<p style="text-align:right"><label id="lblMonto_aux' + iFamiliares + '">0.00</label><label style="display:none" id="lblMonto' + iFamiliares + '">0.00</label></p>',
            sDistM,
            '<p style="text-align:right"><label id="lblMAct_aux' + iFamiliares + '">0.00</label><label style="display:none" id="lblMAct' + iFamiliares + '">0.00</label></p>',
            //sDist,
            '<label id="lblCm' + iFamiliares + '">0.00</label>'

        ] ).draw( false );
         
}

function consultarBeneficiarioFecha(){

    var val = $("#id").val();
    var fecha = $("#datepicker").val();
    var elem = fecha.split('/');
    dia = elem[0];
    mes = elem[1];
    ano = elem[2];
    var fech = ano + '-' + mes + '-' + dia;    
    ruta = sUrlP + "consultarBeneficiario/" + val  + "/" + fech;
    console.log(ruta);

    $.getJSON(ruta, function(data) {    
        $("#tservicio").val(data.tiempo_servicio_aux);
        var porcentaje = 0;
        var monto = 0;
        if(data.MedidaJudicialActiva[1] != null){
            porcentaje = Number(data.MedidaJudicialActiva[1].porcentaje);        
            monto = Number(data.MedidaJudicialActiva[1].monto);
        }
            
        embargos = monto + Number(data.Calculo.asignacion_antiguedad_fin_aux*porcentaje /100);

        $("#directiva").val(data.Componente.Grado.Directiva.nombre);    
        //$("#asignacion_antiguedad").val(data.Calculo.asignacion_antiguedad);
        $("#asignacion_antiguedad_fin").val(data.Calculo.asignacion_antiguedad_fin); //se cambio con la AA de la rutina AsignacionFiniquito
        $("#asignacion_antiguedad_fin_aux").val(data.Calculo.asignacion_antiguedad_fin_aux);
        $("#asignacion_antiguedad_aux").val(data.Calculo.asignacion_antiguedad_aux);
        
        $("#anticipos").val(data.Calculo.anticipos);
        $("#embargos").val(embargos.formatMoney(2, ',', '.'));
        $("#embargos_aux").val(parseFloat(embargos).toFixed(2));
        $("#asignacion_depositada").val(data.Calculo.capital_banco);
        $("#monto_recuperar").val(data.Calculo.monto_recuperar);
        $("#asignacion_diferencia").val(data.Calculo.asignacion_diferencia);
        $("#asignacion_diferencia_aux").val(data.Calculo.asignacion_diferencia_aux);

        $("#dias_adicionales").val(data.Calculo.dias_adicionales);
        $("#garantias").val(data.Calculo.garantias);


        $("#comision_servicios").val(data.Calculo.comision_servicios);
        $("#monto_recuperado").val(data.Calculo.monto_recuperado);
        
        $("#divMontoAsignacion").show();
        var total_banco = Number(data.Calculo.saldo_disponible_fini_aux); //+ Number(data.Calculo.monto_recuperado);
        $("#total_banco").val(data.Calculo.saldo_disponible_fini);
        $("#total_banco_calc").val(total_banco);
        $("#total_banco_aux").val(total_banco);
        $("#monto_recuperar_aux").val(data.Calculo.monto_recuperar_aux);

        fallecimiento_actoservicio = data.Calculo.fallecimiento_actoservicio_aux;
        fallecimiento_fueraservicio = data.Calculo.fallecimiento_fueraservicio_aux;
        var motivo = $("#motivo_finiquito option:selected").val();

        if(motivo > 8 && motivo < 11){
            fa = Number(fallecimiento_actoservicio); 
            $("#monto_asignacion").val(fa.formatMoney(2, ',', '.'));
            $("#monto_asignacion_aux").val(fallecimiento_actoservicio);
            
            if(motivo == 9 ) {
                ma = Number(fallecimiento_fueraservicio);
                $("#monto_asignacion").val(ma.formatMoney(2, ',', '.'));
                $("#monto_asignacion_aux").val(fallecimiento_fueraservicio);

            }else{
                
                $("#asignacion_causa").val('36,00');
                $("#asignacion_causa_aux").val('36.00');
            }
        }


        CalcularDeuda();
    }
    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        console.log(jqXHR);
    });

}



function CalcularDeuda(){
    var totalBanco = Number($("#total_banco_aux").val());
    var intereses = Number($("#intereses").val());
    var deuda = Number($("#deuda").val());
    
    if(intereses != ''){
        var resta = totalBanco - deuda + intereses;
        var resultado = parseFloat(resta).toFixed(2);
        $("#total_banco_calc").val(resultado);
        numero = resta;
        $("#total_banco").val(numero.formatMoney(2, ',', '.'));
        
    }else{
        var resta = totalBanco - deuda;
        var resultado = parseFloat(resta).toFixed(2);
        $("#total_banco_calc").val(resultado);
        numero = resta;
        $("#total_banco").val(numero.formatMoney(2, ',', '.'));
    }   
}



function seleccionarPartida(){
    var val = $("#partida option:selected").val();
    ruta = sUrlP + "obtenerPartidaPresupuestaria/" + val;    
    $.getJSON(ruta, function(data) {    
        $("#proyecto").val(data.proyecto);
        $("#codigo_unidad_ejecutora").val(data.codigo_unidad_ejecutora);
    }

    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function imprimir(){
    var val = $("#id").val();
    URL = sUrlP + "hojavida/" + val;
    window.open(URL,"Hoja de Vida","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}


function cargarPersona(){
    var val = $("#fcedula").val();
    ruta = sUrlP + "cargarPersona/" + val;    
    $.getJSON(ruta, function(data) {
        $("#fnombres").val(data.nombre);
        $("#fparentesco").val(data.parentesco);
    }

    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function AsignarCeroASFS(){
    monto = $("#monto_asignacion").val();
    $("#monto_asignacion_aux").val(monto);
}

function consultarFiniquitos(){
   var t = $('#reporteFiniquitos').DataTable();

    var val = $("#cedulaB").val();
    ruta = sUrlP + "consultarFiniquitos/" + val;  

    t.clear().draw();

    $.getJSON(ruta, function(data) {
        console.log(data);
        var cedula = data.cedula;
        var nombre = data.nombres + ' ' + data.apellidos;
        var componente = data.Componente.descripcion;
        var grado = data.Componente.Grado.nombre;
        var tiempo_servicio = data.tiempo_servicio_aux;
        
        var arr = data.HistorialDetalleMovimiento;
       
        if(Array.isArray(arr) == false){
            if (arr[9] == null){
                guia = arr[14]; //GUIA DE ACCION    
            }else{
                guia = arr[9]; //CONTROL DE GUIA
            }

            $.each(guia, function ( clv, valores ){    
                console.log(valores.partida);
                var fecha_creacion = valores.fecha_creacion;
                var fecha_contable = valores.fecha_contable;
                var monto = Number(valores.monto);
                var codigo = valores.codigo;
                var observaciones = valores.observacion;
                var estatus = valores.tipo_texto;
                var partida = valores.partida;
                var motivo = valores.motivo;
                var sAcciones = '';
                var sBoton = '<div class="btn-group">';
                
                if(estatus != 'Reverso') {
                    
                    if(fecha_creacion > '2016-11-01')sBoton += '<button type="button" id="btnReversar" class="btn btn-danger" title="Reversar" onclick="Reversar(\'' + cedula + '\',\'' + codigo + '\')"><i class="fa fa-random"></i></button>';
                
                    
                    sBoton += '<button type="button" class="btn btn-info" title="Imprimir"><i class="fa fa-print" ></i></button>';                
                    sBoton += '<button aria-expanded="false" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">';
                    sBoton += '<span class="caret"></span>';
                    sBoton += '<span class="sr-only">Toggle Dropdown</span>';
                    sBoton += '</button>';

                    sAcciones = '<ul class="dropdown-menu" role="menu">';
                    sAcciones += '<li><a href="#!" target="_top" onclick="HojaVida(\'' + cedula + '\',\'' + codigo + '\')">Hoja de Vida (PRINT)</a></li>';
                    sAcciones +='<li class="divider"></li>';

                    //sAcciones += '<li><a href="#!" target="_top" onclick="MedidaEjecutada(\'' + cedula + '\',\'' + codigo + '\')">Medida Ejecutada </a></li>'; 
                    switch (partida){
                        case '1':
                            
                            sAcciones += '<li><a href="#!" target="_top" onclick="ConsultoriaJuridica(\'' + cedula + '\',\'' + codigo + '\')">Consultoria Juridica</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="CartaBancoFallecido(\'' + cedula + '\',\'' + codigo + '\')">Carta Banco</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="AFAS(\'' + cedula + '\',\'' + codigo + '\',\'' + motivo + '\')">Asignacion FS/AS</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="CausaMuerte(\'' + cedula + '\',\'' + codigo + '\')">Causa Muerte</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="DiferenciaAntiguedad(\'' + cedula + '\',\'' + codigo + '\')">Diferencia de Antiguedad</a></li>';
                            break;
                        case '2':
                            sAcciones += '<li><a href="#!" target="_top" onclick="ConsultoriaJuridica(\'' + cedula + '\',\'' + codigo + '\')">Consultoria Juridica</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="CartaBancoFallecido(\'' + cedula + '\',\'' + codigo + '\')">Carta Banco</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="AFAS(\'' + cedula + '\',\'' + codigo + '\',\'' + motivo + '\')">Asignacion FS/AS</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="CausaMuerte(\'' + cedula + '\',\'' + codigo + '\')">Causa Muerte</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="DiferenciaAntiguedad(\'' + cedula + '\',\'' + codigo + '\')">Diferencia de Antiguedad</a></li>';
                            break;
                        case '3':
                            sAcciones += '<li><a href="#!" target="_top" onclick="ConsultoriaJuridica(\'' + cedula + '\',\'' + codigo + '\')">Consultoria Juridica</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="CartaBancoFallecido(\'' + cedula + '\',\'' + codigo + '\')">Carta Banco</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="AFAS(\'' + cedula + '\',\'' + codigo + '\',\'' + motivo + '\')">Asignacion FS/AS</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="CausaMuerte(\'' + cedula + '\',\'' + codigo + '\')">Causa Muerte</a></li>';
                            sAcciones += '<li><a href="#!" target="_top" onclick="DiferenciaAntiguedad(\'' + cedula + '\',\'' + codigo + '\')">Diferencia de Antiguedad</a></li>'; 
                            break;
                        case '4':
                            sAcciones += '<li><a href="#!" target="_top" onclick="CartaBanco(\'' + cedula + '\',\'' + codigo + '\')">Carta Banco </a></li>'; 
                            break;
                        case '5':
                             sAcciones += '<li><a href="#!" target="_top" onclick="CartaBanco(\'' + cedula + '\',\'' + codigo + '\')">Carta Banco </a></li>';
                        default:
                            break;
                    }

                    
                    sAcciones += '</ul>';
                }

                

                


                sBoton += sAcciones;
                // 
                sBoton += '</div>';
                $("#lblCedula").text(cedula);
                $("#lblBeneficiario").text(nombre);
                t.row.add( [
                    sBoton,
                    fecha_creacion,
                    //cedula,
                    //nombre,
                    componente,
                    grado,
                    tiempo_servicio,
                    monto.formatMoney(2, ',', '.'),
                    fecha_contable,
                    observaciones,
                    estatus
                ] ).draw( false );
                

            });
            if(_ACT != true)t.column(0).visible(false);
            vBtn();


        }else{
            alert('Beneficiario no posee finiquito');
        }
    }

    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        alert('Beneficiario no esta registrado');
    });


}


function abrirModal(){
    $("#ModalImprimir").modal('show');
}

function HojaVida(id, cod){    
    URL = sUrlP + "hojavida/" + id  + '/' + cod;
    window.open(URL,"Hoja de Vida","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function CartaBanco(id, cod){    
    if(cod == 'null'){
        var boton = '<button id="btnContinuar" type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si</button>';

        $("#divContinuar").html(boton);
        $("#txtMensaje").html('Esta carta procede del sistema anterior, consultar en informatica'); 
        $("#logMensaje").modal('show');
    }else{
        URL = sUrlP + "cartaBanco/" + id + '/' + cod;
        window.open(URL,"Carta Banco","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
    }
}

function MedidaEjecutada(id, cod){    
    URL = sUrlP + "medidaejecutada/" + id + '/' + cod;
    window.open(URL,"Medida Ejecutada","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}


function CartaBancoFallecido(id, cod){    
    URL = sUrlP + "cartaBancoFallecidoM/" + id + '/' + cod;
    window.open(URL,"Carta Banco","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function CausaMuerte(id, cod){    
    URL = sUrlP + "CausaMuerte/" + id + '/' + cod;
    window.open(URL,"Carta Banco","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}

function AFAS(id, cod, motivo){    
    URL = sUrlP + "asignacionFAS/" + id + '/' + cod + '/' + motivo;
    window.open(URL,"Carta Banco","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}


function ConsultoriaJuridica(id, cod){    
    URL = sUrlP + "ConsultoriaJuridica/" + id + '/' + cod;
    window.open(URL,"Carta Banco","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}


function DiferenciaAntiguedad(id, cod){    
    URL = sUrlP + "DiferenciaAntiguedad/" + id + '/' + cod;
    window.open(URL,"Carta Banco","toolbar=0,location=1,menubar=0,scrollbars=1,resizable=1,width=900,height=800")
}



function GuargarFiniquito(){ 
    ruta = sUrlP + "guardarFiniquito";
    i_d = $("#id").val(); //
    m_d = $("#deuda").val(); //Monto Por Deuda
    a_i = $("#intereses").val(); //Ajuste PorInteres
    //t_an = $("#asignacion_antiguedad_aux").val(); //A.A Generada
    t_an = ""; //A.A Generada
    t_b = $("#total_banco").val(); //Total en Banco
    t_e = $("#embargos_aux").val(); //Total de los embargos
    t_bx = $("#total_banco_calc").val(); //Total en Banco
    a_a = $("#asignacion_diferencia").val(); //Diferencia Asignación Antiguedad
    a_ax = $("#asignacion_diferencia_aux").val(); //Diferencia Asignación Antiguedad
    p_p = $("#partida option:selected").val(); //Partida Presupuestaria
    m_f = $("#motivo_finiquito option:selected").val(); //Motivo de Finiquito
    m_ft = $("#motivo_finiquito option:selected").text(); //motivo_finiquito

    m_asaf = $("#monto_asignacion_aux").val(); //motivo_finiquito   

    o_b = $("#o_b").val(); //Observaciones
    f_r = $("#datepicker").val(); //Fecha Retiro
    
    m_r = $("#monto_recuperar").val(); //Monto a Recuperar
    m_rx = $("#monto_recuperar_aux").val(); //Monto a Recuperar
    if(iFamiliares > 0){
        if (Leer() == false){
            $("#logMensaje").modal('show');
            return false;
        }
    }
    data =  JSON.stringify({
        i_d: i_d, //Cedula de Identidad
        t_an: t_an, //5 Formato Moneda
        t_b: t_b, //9 Formato Moneda
        t_e: t_e, //9 Formato de Embargo
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
        fami: lstFamiliares      
    });
    if(p_p != 0){

        $.ajax({
          type: "POST",
          //contentType: "application/json",
          //dataType: "json",
          data: {'data' :data},
          url: ruta,
          success: function (data) {  
            //alert(data);
            //$("#txtMensaje").html(data);
            $("#txtMensaje").html(data); 
            var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuarFiniquito()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar Finiquito</button>';
            $("#divContinuar").html(boton);
            $("#logMensaje").modal('show');

          },
          error: function(data){
            //$("#txtMensaje").html(data); 
            var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuarFiniquito()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar Finiquito</button>';
            $("#divContinuar").html(boton);

            $("#txtMensaje").html('Err. al procesar el finiquito'); 
            $("#logMensaje").modal('show');

          }
        });
    }else{
       
        var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar Finiquito</button>';
        $("#divContinuar").html(boton);
        $("#txtMensaje").html('Debe seleccionar una partida presupuestaria'); 
        $("#logMensaje").modal('show');

    }

    return true;
}


function Leer(){
    var boton = '<button type="button" class="btn btn-success pull-right" onclick="continuar()">';
        boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Continuar Finiquito</button>';
        $("#divContinuar").html(boton);
    // CAPITAL EN BANCO
    var suma = 0;
    for (var i = 1; i <= iFamiliares; i++) {
        if($("#txtAA" + i).val() != ""){
            var por = parseFloat($("#txtAA" + i).val());      
            suma += por;    
        }
    }
    if(suma != 100){         
        $("#txtMensaje").html('Verifique los porcentajes de Capital en Banco sumen un 100% para poder continuar');         
        return false;
    }   
    
    // MONTO DE ASIGNACION CAUSA O MUERTE
    suma = 0;
    for (var i = 1; i <= iFamiliares; i++) {
        if($("#txtM" + i).val() != ""){
            var por = parseFloat($("#txtM" + i).val());      
            suma += por;    
        }
    }
    if(suma != 100){         
        $("#txtMensaje").html('Verifique que los porcentajes de la Asig. Muerte AS/FS sumen un 100% para poder continuar ');         
        return false;
    }    
    




    for (var i = 1; i <= iFamiliares; i++) {
        var capital_banco = parseFloat($("#lblCapital" + i).text());
        var diferenciaAA = parseFloat($("#lblMonto_aux" + i).text());
        var montoAS = parseFloat($("#lblMAct_aux" + i).text());
        var mc = parseFloat($("#lblMAct" + i).text());

        if (capital_banco > 0 || diferenciaAA > 0 || montoAS  > 0){
            pcb = $("#txtAA" + i).val() == ''? 0: $("#txtAA" + i).val();
            pac = $("#txtM" + i).val() == ''?0:$("#txtM" + i).val();
            lstFamiliares[i] = {
                ced: $("#lblCedula" + i).text(),
                nom: $("#lblNombre" + i).text(),
                pcb: parseFloat(pcb),
                cab: parseFloat($("#lblCapital" + i).text()),
                maa: parseFloat($("#lblMonto" + i).text()),
                cmu: parseFloat($("#lblCm" + i).text()),
                pac: parseFloat(pac), 
                mcm: parseFloat($("#lblMAct" + i).text())
            }    
        }

    }

    //console.log(lstFamiliares);
    return true;
}


function continuarFiniquito(){
    URL = sUrlP + "finiquitos";
    $(location).attr('href', URL);
}

function continuar(){
    $("#logMensaje").modal('hide');
    //$("#id").focus();
}

function asignarCausa(){
    $("#asignacion_causa_aux").val($("#asignacion_causa").val());
}

function Reversar(ced, cod){
    $("#txtMensaje").html('Esta seguro que desea realizar el reverso del finiquito'); 
    
    var boton = '<button type="button" class="btn btn-danger pull-right" onclick="continuar()">';
            boton += '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;No&nbsp;&nbsp;</button>';
            boton += '<button type="button" class="btn btn-success" onclick="EjecutarReverso(\'' + ced + '\',\'' + cod + '\')">';
            boton += '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Si&nbsp;&nbsp;</button>';
    $("#divContinuar").html(boton);
    $("#logMensaje").modal('show');
}

function EjecutarReverso(ced, cod){
    var t = $('#reporteFiniquitos').DataTable();
    $("#logMensaje").modal('hide');
    
    ruta = sUrlP + "reversarFiniquito/" + ced + "/" + cod; 
    $.get(ruta, function(data) { 
        console.log(data);
        URL = sUrlP + "finiquitos";
        //$(location).attr('href', URL);
        
    }

    ).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        console.log(jqXHR);
    });

    
}

function UrlDire(){
    $(location).attr('href', 'registrarFiniquito');
}