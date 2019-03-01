<?php  

  /**
  foreach ($Beneficiario->HistorialOrdenPagos as $c => $v) {
    if($v->id == $codigo){
      $finalidad = $v->motivo;
      $monto = $v->monto;
    }  
    
  }
  **/


  $monto = 0;



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
    border: 1px solid #dddddd;
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
 </table>
  <b>
   <BR>
    REPORTE DE ANTICIPOS<br>
    PERIODO: <?php echo $desde . ' - ' . $hasta;?><br>
    COMPONENTE: <?php 
    $com = explode('%20', $Componente);
    if(count($com) > 1){ 
      echo $com[0] . ' ' . $com[1];
    }else{
      echo $Componente;
    }

    ?><br><br>
  </b>
 <table >
  <thead>
    <tr>
     <th>Nro.</th>
     <th>GRADOS</th>
     <th>NOMBRES Y APELLIDOS</th>
     <th>CEDULA</th>
     <th>MONTO</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $fila = '';
      $i = 0;
      foreach ($Anticipos as $k => $v) {
        $nombre = $v->nombre . ' ' . $v->apellido;
        $i++;
        $fila .= '<tr><td>' . $i . '</td><td>' . $v->grado . '</td><td>' . $nombre;
        $fila .= '</td><td>' . $v->cedula_afiliado . '</td><td style="text-align:right">' .  number_format($v->monto, 2, ',','.') . '</td></tr>';  
        $monto += $v->monto;

      }
      echo $fila;
    ?>
 
    
    <tr>
      <td colspan="4">TOTAL</td>
      <td style="text-align:right"><?php echo number_format($monto, 2, ',','.')?></td>
    </tr>
   </tbody>
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