/**
* Cargar menus del sistema
*
*

*/


let _INTERFAZ = '';
let _PRV = {};
let _ACT = false;



 class Estado{
     constructor() {

     }
     Crear(Json) {
         if (sessionStorage.getItem('ipsfaEstado') == undefined ){
             sessionStorage.setItem('ipsfaEstado', JSON.stringify(Json));
         }
     }
     ObtenerCodigo(estados){
       var cadena = "";
       let estado = JSON.parse(sessionStorage.getItem('ipsfaEstado'));
       estado.forEach(v => {
           if (v.codigo == estados){
              cadena = v.nombre;
           }
       });
       return cadena;
     }

     ObtenerEstados(){
         let estado = JSON.parse(sessionStorage.getItem('ipsfaEstado'));

         $("#cmbmestado").html('<option value="S" selected="selected"></option>');
         $("#cmbestadof").html('<option value="S" selected="selected"></option>');
         $.each(estado, function (c, v){
             $("#cmbmestado").append('<option value="' + v.codigo + '">' + v.nombre + '</option>');
             $("#cmbestadof").append('<option value="' + v.codigo + '">' + v.nombre + '</option>');
         });

     }
     ObtenerCiudadMunicipio(estado, nombre){
         var sciudad = 'cmbmciudad';
         var smunicipio = 'cmbmmunicipio';
         if ( nombre != undefined){
             sciudad = 'cmbciudadf';
             smunicipio = 'cmbmunicipiof';
         }
         var cm = JSON.parse(sessionStorage.getItem('ipsfaEstado')); //CiudadMunicipio
         $.each(cm, function(c, v){
             if (v.codigo == estado){

                 let ciudad = v.ciudad;
                 let municipio = v.municipio;
                 $("#" + sciudad).html('<option value="S" selected="selected"></option>');
                 $("#" + smunicipio).html('<option value="S" selected="selected"></option>');
                 $.each(ciudad, function (c,v){
                     $("#" + sciudad).append('<option value="' + v.nombre + '">' + v.nombre + '</option>');
                 });
                 $.each(municipio, function (c,v){
                     $("#" + smunicipio).append('<option value="' + v.nombre + '">' + v.nombre + '</option>');
                 });
             }
         });
     }
     ObtenerParroquia(estado, municipio, nombre){
         var sparroquia = 'cmbmparroquia';
         if ( nombre != undefined){
             sparroquia = 'cmbparroquiaf';
         }
         var cm = JSON.parse(sessionStorage.getItem('ipsfaEstado')); //CiudadMunicipio
         $.each(cm, function(c, v){
             if (v.codigo == estado){
                 var mun = v.municipio;
                 $.each(mun, function (c,v){
                     if(v.nombre == municipio){
                         $("#" + sparroquia).html('<option value="S"></option>');
                         $.each(v.parroquia, function(cl, vl){
                             $("#" + sparroquia).append('<option value="' + vl + '">' + vl + '</option>');
                         });
                     }
                 });
             }
         });
     }
 }

var Estados = new Estado();


$(function () {
 s = window.location.pathname;
 a = s.split("/");
 _INTERFAZ = a[a.length-1];

 init();

});

function init(){
	// var url = sUrlP + 'obtenerMenu';
	// menu = '';
	// var clase = '';
	// $.post(url).done(function (data){
	// 	$("#navegacion-menu").html('<li class="header">NAVEGACIÓN PRINCIPAL</li>');
	// 	$.each(data, function (x,y){
	// 		menu = '<li class="treeview"><a href="#">';
	//         textomenu = '<span>' + x + '</span><i class="fa fa-angle-left pull-right"></i></a><ul class="treeview-menu">';
	// 		var submenu = '';
	// 		$.each(y, function(cla, val){
	// 			submenu = '';
	// 			clase = '<i class="' + val.clase + '"></i>';
	// 			if (val.priv_!=null && val.url == _INTERFAZ) {
	// 				_PRV = val.priv_;
	// 				cBtn(_PRV);
	// 			}
	//
	//             $.each(y, function(c, v){
	// 				submenu += '<li><a href="' + sUrlP + v.url + '"><i class="' + v.clase_ + '"></i> ' + v.desc + '</a></li>';
	// 			});
	//
	// 		});
	//
	// 		 menu += clase + textomenu + submenu +'</ul></li>';
	// 		 $("#navegacion-menu").append(menu);
	// 	});
  //
	//
	//
	// });

}


function cBtn(_DATA){

	$.each(_DATA, function(p, q){

		if (q.tipo == "btn" && q.visi == 1){
			$("#divBotones").append('<button type="button" class="btn btn-success"\
                onclick="' + q.func + '()" id=\'' + q.cod + '\'><i class="' + q.clas + '">\
                </i>&nbsp;&nbsp;' + q.nomb + '</button>');
         }
         if(q.tipo == "tbl_"){
         	_ACT = true;
         }
	})
}


function vBtn(){

	$.each(_PRV, function(p, q){

		if (q.tipo == "tbl_" && q.visi == "0"){
			$("#" + q.cod).hide();
		}
		if (q.tipo == "div" && q.visi == "1"){
			$("#" + q.cod).show();
		}
	});
}

function show(_ID){
	$("#myModal").modal('show');
}
