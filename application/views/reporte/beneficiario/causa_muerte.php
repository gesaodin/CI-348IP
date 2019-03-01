<?php  

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
.ctd td{
    border: 1px solid #000000;
    text-align: left;
    padding: 8px;
}

.ctd table {
    font-family: arial, sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 800px;
}

.ctd th {
    border: 1px solid #000000;
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
 <br>
 CANCELACIÓN "ASIGNACIÓN CAUSA MUERTE".<BR>
 ESTATUTO ORGANICO DEL IPSFA CÓDIGO 86<BR><BR>

 <table style="width: 700px;  text-align: justify;  font-size: 15px">

  
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
     &emsp;&emsp;Cancelar a los familiares a través de la nomina de pensiones la Asignación Causa Muerte generada por el 
     fallecimiento del militar en referencia.
     familiares:
     <br><br>

     <table class="ctd">
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
          $sum = 0;
          foreach ($lst as $c => $v) {
            
            if($v['cmue'] > 0){
              echo '<tr><td>' . $v['codigo'] . '</td><td>' . strtoupper($v['nombre']) . '</td><td>' . $v['cedula'] . '</td><td  style="text-align: right">' . 
              number_format($v['cmue'], 2, ',','.') . '</td></tr>';
              $sum += $v['cmue'];
            }
            
          }
          echo '<tr><td colspan="3" style="text-align: right">TOTAL&nbsp;&nbsp;</td><td  style="text-align: right">' . number_format($sum, 2, ',','.') . '</td></tr>';
        ?>
       </tbody>
     </table>
     <br><br><br>
     <table>
       <tr>
         <td><hr></td>
         <td><hr></td>
         <td><hr></td>
         <td><hr></td>
       </tr>
       <tr>
         <td>ELABORADO</td>
         <td>JEFE DPTO.</td>
         <td>GERENTE DE B y S.S.</td>
         <td>TRANSCRITO</td>
       </tr>
     </table>
     
     <br>

     Notas:<br>
     El monto a cancelar debe ser cargado al código de la partida presupuestaria 4.07.01.01.99.06 del proyecto 
     98555, unidad ejecutora 3206 PACE, acción especifica 98555-1
     <br><br>
     EMG/<?php echo $Beneficiario->usuario_modificacion;?>
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