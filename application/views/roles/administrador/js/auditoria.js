/**
* Auditorias
*/

$('#reporteAuditoria').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    }
);

$('#reporteAuditoriaDetalle').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
	}
);

function Consultar(){
    var t = $('#reporteAuditoria').DataTable();

    var val = $("#id").val();
    ruta = sUrlP + "consultarBeneficiario/" + val;  

    t.clear().draw();

    $.getJSON(ruta, function(data) {
        var nombre = data.nombres + ' ' + data.apellidos;
        var componente = data.Componente.descripcion;
        var grado = data.Componente.Grado.nombre;
        
        t.row.add( [
            nombre,
            componente,
            grado,
            data.fecha_ingreso,
            data.no_ascenso,
            data.numero_hijos,
            data.fecha_ultimo_ascenso,
            data.ano_reconocido,
            data.mes_reconocido,
            data.dia_reconocido,
            '',
            data.usuario_creador,
            data.fecha_creacion,
            data.usuario_modificacion,
            data.fecha_ultima_modificacion,
        ] ).draw( false );
        ConsultarHistorialBeneficiario();

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {

        alert('Beneficiario no esta registrado');
    });
}

function ConsultarHistorialBeneficiario(){
    var t = $('#reporteAuditoriaDetalle').DataTable();

    var val = $("#id").val();
    ruta = sUrlP + "consultarHistorialBeneficiario/" + val;  

    t.clear().draw();

    $.getJSON(ruta, function(data) {
        $.each(data, function ( clv, valores ){            

            var nombre = valores.nombres + ' ' + valores.apellidos;
            var componente = valores.Componente.descripcion;
            var grado = valores.Componente.Grado.nombre;            
            t.row.add( [
                nombre,
                componente,
                grado,
                valores.fecha_ingreso,
                valores.no_ascenso,
                valores.numero_hijos,
                valores.fecha_ultimo_ascenso,
                valores.ano_reconocido,
                valores.mes_reconocido,
                valores.dia_reconocido,
                '',
                valores.usuario_creador,
                valores.fecha_creacion,
                valores.usuario_modificacion,
                valores.fecha_ultima_modificacion,
            ] ).draw( false );
        });

    }).done(function(msg) {}).fail(function(jqXHR, textStatus) {
        alert('Beneficiario no posee historico cargado');
    });
}
