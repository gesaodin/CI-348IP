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
   <td style="width: 100%;  border: 0px solid #dddddd; text-align: center; font-size: 10px">    
     REPÚBLICA BOLIVARIANA DE VENEZUELA<BR>
     MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<BR>
     VICEMINISTERIO DE SERVICIOS, PERSONAL Y LOGISTICA<BR>
     DIRECCIÓN GENERAL DE EMPRESAS<BR>
     INSTITUTO DE PREVISIÓN SOCIAL<BR>
     DE LAS FUERZAS ARMADAS<BR>
   </td>
   
 </tr>
 </table><BR>

 <table style="width: 700px;  text-align: justify;  font-size: 15px">
  <tr>
    <td>Nro.</td><td>320.600-<?php echo substr(md5($Beneficiario->cedula . $Beneficiario->fecha_ultima_modificacion), 0,6);?>/01</td>
  </tr> 
  <tr>
    <td >DE:</td><td><b>CNEL. GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL</b></td>
  </tr> 
  <tr>
    <td>PARA:</td><td><b>CNEL. GERENTE DE DE FINANZAS A/C SUB. GERENCIA DE TESORERIA</b></td>    
  </tr> 
  <tr>
    <td>ASUNTO:</td><td><b>SOLICITUD DE FINIQUITO</b></td>
  </tr> 
  
  <tr>
    <td valign="TOP">AFILIADO:</td><td><b><?php 
      echo $Beneficiario->Componente->Grado->nombre . ' ' . $Beneficiario->Componente->descripcion . ' ' . 
      $Beneficiario->nombres . ' ' . $Beneficiario->apellidos . '<br> CEDULA DE IDENTIDAD: ' . $Beneficiario->cedula; ?></b></td>
  </tr>
  <tr>
    <td valign="TOP">FALLECIMIENTO:</td><td><b><?php 
      echo $Beneficiario->fecha_retiro; ?></b></td>
  </tr>
 </table>
 <table style="width: 700px">
  <tr>
   <td style="border: 0px solid #dddddd; text-align: justify; font-size: 16px; line-height: 1.5">
     &emsp;&emsp;Mediante la presente comunicación me dirijo a Ud., en la oportunidad de solicitar su valiosa colaboración a objeto 
     gire sus instruciones con la finalidad sea realizado el pago de la Asignación de Antiguedad generada por el fallecimiento del afiliado 
     en referencia quien de acuerdo a lo previsto en el artículo 57 de la LOSSFANB y los artículos 822 al 832 del Código Civil Venezolano
     <br><br>

     <table>
       <thead>
          <tr>
            <th>COD</th>
            <th>APELLIDOS Y NOMBRES DE LOS BENEFICIARIOS</th>
            <th>CEDULA</th>
            <th>MONTO BS.</th>
          </tr>
       </thead>
       <tbody>
        <?php
          foreach ($lst as $c => $v) {

            echo '<tr style="font-size:14px;"><td>' . $v['codigo'] . '</td><td>' . strtoupper($v['nombre']) . '</td><td>' . $v['cedula'] . '</td><td>' . 
            number_format($v['monto'], 2, ',','.') . '</td></tr>';
          }
        ?>
       </tbody>
     </table>
     <br>
     &emsp;&emsp;Solicitud que le hago llegar, para su conocimiento y demas fines consiguientes.<br>

     <p align="right">
       Caracas,&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
     </p>
     <center>
        Atentamente 
        <br><br><br><br><br><b>
        CNEL. EDUARDO JOSE MARTINEZ SALAS<BR></b>
     </center>
     <br>

     Notas:<br>
     <?php echo $Beneficiario->observacion;?>
     <br>
     <?php 
      if ( $Beneficiario->Calculo['monto_recuperar_aux'] > 0){
        echo 'Moto a recuperar a favor del Fondo de Fideicomiso por la cantidad de: ' . $Beneficiario->Calculo['monto_recuperar'] . '<br>';
        echo 'Partida Recuperación: ' . $partida;
      }

     ?><br>
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