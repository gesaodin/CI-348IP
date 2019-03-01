<?php  

  $partida_id = 0;
  $partida = '';
  $monto = 0;
  $Detalle = $Beneficiario->HistorialDetalleMovimiento['Detalle'];
  $finiquito = $Detalle[9];
  //print_r($finiquito);
  foreach ($finiquito as $k => $v) {
    if($v->codigo == $codigo){
      $monto = $v->monto;
      $f = explode('-', substr($v->fecha_creacion, 0, 10));
      $partida = $v->partida_des;
      $partida_id = $v->partida;
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
   <td style="width: 65%;  border: 0px solid #dddddd; text-align: center; font-size: 10px">    
     REPÚBLICA BOLIVARIANA DE VENEZUELA<BR>
     MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<BR>
     VICEMINISTERIO DE SERVICIOS, PERSONAL Y LOGISTICA<BR>
     DIRECCIÓN GENERAL DE EMPRESAS<BR>
     INSTITUTO DE PREVISIÓN SOCIAL<BR>
     DE LAS FUERZAS ARMADAS<BR>
   </td>
   <td style="width: 35%;  border: 0px solid #dddddd; text-align: right;">
     Sistema PACE<br>
     <?php echo 'Caracas, ' . date('d') . ' de ' . fecha(date('F')) . ' de '. date('Y') ?>

   </td>
 </tr>
 </table><BR>

 <table style="width: 700px;  text-align: justify;  font-size: 15px">
  <tr>
    <td>Nro.</td><td>320.600-<?php echo substr(md5($Beneficiario->cedula . $Beneficiario->fecha_ultima_modificacion), 0,6);?>/01</td>
  </tr> 
  <tr>
    <td>DE:</td><td><b>CNEL. GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL</b></td>
  </tr> 
  <tr>
    <td>PARA:</td><td><b>CNEL. GERENTE DE DE FINANZAS A/C SUB. GERENCIA DE TESORERIA</b></td>    
  </tr> 
  <tr>
    <td>ASUNTO:</td><td><b>SOLICITUD DE FINIQUITO FALLECIDO</b></td>
  </tr> 
  <tr>
    <!--<td>REF.:</td><td><b>P.A.V</b></td>-->
    <td>REF.:</td><td><b>LOSSFAN (LEY NEGRO PRIMERO)</b></td>
  </tr> 
 </table>
 <table style="width: 700px">
  <tr>
   <td style="border: 0px solid #dddddd; text-align: justify; font-size: 16px; line-height: 1.5">
     //&emsp;&emsp;Mediante la presente me dirijo a Ud., en la oportunidad de autorizar al <b><?php echo $Beneficiario->Componente->Grado->nombre; echo $Beneficiario->nombres . ' ' . $Beneficiario->apellidos; ?></b>, titular de la cédula de identidad <b><?php echo $Beneficiario->cedula;?></b> para realizar trámites ante el Banco Venezuela, a fin de obtener el finiquito del monto total de Bs.<b>
     &emsp;&emsp;Tengo el honor de dirigirme a usted, en la oportunidad se estudie la posibilidad de autorizar al

     <?php 
        $monto = $Beneficiario->Calculo['saldo_disponible_aux'];
        if($Beneficiario->Calculo['interes_capitalizado_banco'] > 0){
          $monto += $Beneficiario->Calculo['interes_capitalizado_banco'];   
        }
        echo number_format($monto, 2, ',','.');

     ?>.</b><br>

     <table width="100%"> 
      <tr><td>CODIGO</td><td>CEDULA</td><td>NOMBRE</td><td>MONTO</td></tr>
        
       <?php
          $sum = 0;
          $fila = "";
          foreach ($lst as $c) {
            $fila .= "<tr>";
            $fila .= "<td>" . $c['codigo'] . "</td><td>" . $c['cedula'] . "</td><td>" . $c['nombre'] . "</td><td>" . $c['monto'] . "</td>";
            $fila .= "</tr>";
            $sum = $c['monto'];
          }
          echo $fila;
          
          echo '<tr><td colspan="3" style="text-align: right">TOTAL&nbsp;&nbsp;</td><td>' . number_format($sum, 2, ',','.') . '</td></tr>';
        ?>      
     </table>
     <br>
     &emsp;&emsp;Motiva la presente comunicación, el hecho que el mencionado afiliado pasó a la reserva activa en  fecha <b>
     <?php  
        $fecha_aux = $Beneficiario->fecha_retiro;
        if($fecha_aux != ''){
          $f = explode('-', $fecha_aux);
          $fecha = $f[2] . '/' . $f[1] . '/' . $f[0];  
          echo $fecha;
        }

      ?></b>, y de acuerdo a lo establecido en la LOSSFAN, en sus artículos 56 y 57 y en el Reglamento de Pago de Asignación al Personal 
      Militar, así como también las cláusulas décimo cuarta y décimo sexta del contrato firmado entre el IPSFA y esa 
      Institución Fiduciaría, en fecha 17FEB2009 ante la Notaría Pública Tercera de Caracas, debe salir del sistema de 
      Fideicomiso de la Asignación de Antiguedad.
     <br><br>
     &emsp;&emsp;Sin otro particular al cual hacer referencia, se despide de ustedes, quedando a sus gratas órdenes.
     <br>
     <center>
        Atentamente 
        <br><br><br><b>
        CNEL. EDUARDO JOSE MARTINEZ SALAS<BR>
        GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL<BR></b>
     </center>
     <br>

     Notas:<br>
     <?php echo $Beneficiario->observacion;?>
     <br>Notas:<br>
     <?php echo $Beneficiario->observacion;?>
     <br>
     <?php 
      if ( $Beneficiario->Calculo['monto_recuperar_aux'] > 0){
        echo 'Moto a recuperar a favor del Fondo de Fideicomiso por la cantidad de: ' . $Beneficiario->Calculo['monto_recuperar'] . '<br>';
        echo 'Partida Recuperación: ' . $partida;
      }

     ?><br>
     EMG/<?php echo $Beneficiario->usuario_modificacion;?>
   </td>
   
 </tr>
 </table>

 </center>
</BODY>