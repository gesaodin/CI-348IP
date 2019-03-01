<?php  
  
  //print_r($Beneficiario->MedidaJudicial);
  $monto =0;
  $n_expediente = 0;
  $n_oficio = 0;
  $fecha = '';

  if(count ($Beneficiario->MedidaJudicial) > 0){
    $mj = $Beneficiario->MedidaJudicial;
    foreach ($mj as $key => $v) {
      if($v->ultima_observacion == $codigo){
        $monto = $v->monto;
        $n_expediente = $v->numero_expediente;
        $n_oficio = $v->numero_oficio;
        $fecha = $v->fecha;
      }
      
    }
  }

  function fecha($fecha = ''){
    $mes = 'Enero';
    switch ($fecha) {
      case 'January':
        $mes="Enero";
        break;
      case 'February':
        $mes="Febrero";
        break;
      case 'March':
        $mes="Marzo";
        break;
      case 'April':
        $mes="Abril";
        break;
      case 'May':
        $mes="Mayo";
        break;
      case 'June':
        $mes="Junio";
        break;
      case 'July':
        $mes="Julio";
        break;
      case 'August':
        $mes="Agosto";
        break;
      case 'September':
        $mes="Septiembre";
        break;
      case 'October':
        $mes="Octubre";
        break;
      case 'November':
        $mes="Noviembre";
        break;
      case 'December':
        $mes="Diciembre";
        break;
      default:
        # code...
        break;
    }
    return $mes;
    
  }


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Formulario</title>
 <style>
table {
    font-family: arial, sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 800px;
}

td{
    border: 0px solid #dddddd;
    text-align: left;
    padding: 8px;
}
th {
    border: 1px solid #dddddd;
    text-align: left;
    background-color: #dddddd; 
    padding: 8px;
}

/*tr:nth-child(even) {
    background-color: #dddddd;
}*/
</style>
</head>
<BODY>
 <center>
 <table style="width: 700px">
 <tr>
   <td style="width: 100%;  border: 0px solid #dddddd; text-align: center; font-size: 10px">    
     REPÚBLICA BOLIVARIANA DE VENEZUELA<BR>
     MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<BR>
     VICEMINISTERIO DE SERVICIOS, PERSONAL Y LOGISTICA<BR>
     DIRECCIÓN GENERAL DE EMPRESAS<BR>
     INSTITUTO DE PREVISIÓN SOCIAL<BR>
     DE LAS FUERZAS ARMADAS<BR>
   </td>
   
 </tr>
 </table>

 <table style="width: 700px;  text-align: justify;  font-size: 15px">
  <tr>
    <td>Nro.</td><td>320.600-<?php echo substr(md5($Beneficiario->cedula . $Beneficiario->fecha_ultima_modificacion), 0,6);?>/02</td>
  </tr> 
  <tr>
    <td>DE:</td><td><b>CNEL. GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL</b></td>
  </tr> 
  <tr>
    <td>PARA:</td><td><b>CNEL. GERENTE DE DE FINANZAS </b></td>    
  </tr> 
  <tr>
    <td>ASUNTO:</td><td><b>SOLICITUD DE ELABORACIÓN DE CHEQUE</b></td>
  </tr> 
  <tr>
    <!--<td>REF:</td><td>P.A.V<b></b></td>-->
    <td>REF.:</td><td><b>LOSSFAN (LEY NEGRO PRIMERO)</b></td>
  </tr> 
  
  <tr>
    <td valign="TOP">AFILIADO:</td><td><b><?php 
      echo $Beneficiario->Componente->Grado->nombre . ' ' . $Beneficiario->Componente->descripcion . ' ' . 
      $Beneficiario->nombres . ' ' . $Beneficiario->apellidos . '<br> CEDULA DE IDENTIDAD: ' . $Beneficiario->cedula; ?></b></td>
  </tr>
 
 </table><br>
 <table style="width: 700px">
  <tr>
   <td style="border: 0px solid #dddddd; text-align: justify; font-size: 16px; line-height: 1.5">
   
     <!--&emsp;&emsp;Mediante la presente comunicación me dirijo a Ud., en la oportunidad de solicitar de su valiosa colaboración -->
     &emsp;&emsp;Tengo el honor de dirigirme a usted, en la oportunidad se estudie la posibilidad de solicitar de su valiosa colaboración
     en sentido de elaborar un cheque por la cantidad de Bs. <?php echo  number_format($monto, 2, ',','.');?>.
     <br><br>
     <textarea style="width: 100%; height: 60px"></textarea>
     
     <br>
     &emsp;&emsp;Dicha solicitud se realiza con el fin de dar cumplimiento a la medida de embargo correspondiente al Expediente N° 
     <?php echo $n_expediente;?>, y notificada a través del oficio N° <?php echo $n_oficio;?>, de fecha <?php echo $fecha;?>.
     <br><br>
     &emsp;&emsp;Solicitud que le hago llegar, para su conocimiento y demas fines consiguientes.<br>
    
     <center><br>
        Atentamente 
        <br><br><b>
        CNEL. EDUARDO JOSE MARTINEZ SALAS<BR>
        </b>
     </center>

     Notas:<br>
      <textarea style="width: 100%; height: 60px"></textarea>
     <br>

     OCR/<?php echo $Beneficiario->usuario_modificacion;?>
   </td>
   
 </tr>
 </table>

 </center>

  <br><br>
  <center>
    <button onclick="imprimir()" id="btnPrint">Imprimir Reporte</button>
  </center>

  <script language="Javascript">
    function imprimir(){
        document.getElementById('btnPrint').style.display = 'none';
        window.print();
        window.close();
    }
  </script>
</BODY>
</HTML>