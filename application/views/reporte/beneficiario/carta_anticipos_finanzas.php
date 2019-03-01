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

 </table><BR><BR><B>
 MEMORANDUM</B><BR><BR>
 
 <table style="width: 700px;  text-align: justify;  font-size: 15px">
  <tr>
    <td>Nro.</td><td>320.600-<?php echo substr(md5(date('YYYY-MM-DD')), 0,6);?>/01</td>
  </tr> 
  <tr>
    <td>DE:</td><td><b>CNEL. GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL</b></td>
  </tr> 
  <tr>
    <td>PARA:</td><td><b>CNEL. GERENTE DE DE FINANZAS<BR> A/C SUB. GERENCIA DE TESORERIA</b></td>    
  </tr> 
  <tr>
    <td>ASUNTO:</td><td><b>REMISION DE SOLICITUDES DE ADELANTOS.</b></td>
  </tr> 
  <tr>
    <!--<td>REF.:</td><td><b>P.A.V</b></td>-->
    <td>REF.:</td><td><b>LOSSFAN (LEY NEGRO PRIMERO)</b></td>
  </tr> 
 </table>
 <BR><BR>
 <table style="width: 700px">
  <tr>

   <td style="border: 0px solid #dddddd; text-align: justify; font-size: 16px; line-height: 1.5">
     &emsp;&emsp;Tengo el honor de dirigirme a usted en la oportunidad de remitirle
     anexo a la presente <b><?php echo $Numero->to_word(count($Anticipos));?></b> ( <b><?php echo count($Anticipos);?> </b>) solicitudes de adelantos 
     correspondientes a los diferentes componentes,
     para su debido tramite ante las entidades bancarias descritas en la relación anexa, procesados el 
     <?php 
      $f = explode('-', $desde);
      echo $f[2] . '/' . $f[1] . '/' . $f[0];
     ?>.
     <br><br><br>
     &emsp;&emsp;Remisión que hago llegar a usted, para su conocimiento y demas fines.
     <br><br>

     <br>
     <center>
        Atentamente <br>
        <p align="right"><?php echo 'Caracas, ' . date('d') . ' de ' . fecha(date('F')) . ' de '. date('Y') ?> 
        </p>

        <br><br><b>

        CNEL. EDUARDO JOSE MARTINEZ SALAS<BR>
        GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL<BR></b>
     </center>
     <br>
    
     
     EMG/<?php echo $_SESSION['usuario'];?>
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