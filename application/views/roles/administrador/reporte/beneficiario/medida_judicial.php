<?php

  
  $Medida = $Beneficiario->MedidaJudicial[$id];
  
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
<body>
 <center>
 <table>
 <tr>
   <td style="width: 70%;  border: 0px solid #dddddd;">
    <center>
     REPÚBLICA BOLIVARIANA DE VENEZUELA<BR>
     MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<BR>
     VICEMINISTERIO DE SERVICIOS<BR>
     DIRECCIÓN GENERAL DE EMPRESAS Y SERVICIOS<BR>
     INSTITUTO DE PREVISIÓN SOCIAL<BR>
     DE LA FUERZA ARMADA<BR>
    </center>
   </td>
   <td style="width: 30%;  border: 0px solid #dddddd; text-align: right;">
     Sistema PACE<br>
     <?php echo 'Caracas, ' . date('d') . ' de ' . fecha(date('F')) . ' de '. date('Y') ?>

   </td>
 </tr>
 </table>

 <table>
  <thead>
    <tr>
      <th colspan="7">Datos Básicos</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Cédula</td>
      <td><?php echo $Beneficiario->cedula;?>
      </td>
      <td>Número de cuenta:</td>
      <td colspan="3">
      <?php 
        echo $Beneficiario->numero_cuenta;
      ?>
      </td>

    </tr>
    <tr>
      <td>Nombre Completo</td>
      <td colspan="3"><?php echo $Beneficiario->nombres . ' ' . $Beneficiario->apellidos;?>
      </td>
      <td>Estatus</td>
      <td><?php echo $Beneficiario->estatus_descripcion; ?></td>
    </tr>
    <tr>
      <td>Componente</td>
      <td><?php echo $Beneficiario->Componente->nombre; ?>
      </td>
      <td>Grado</td>
      <td><?php echo $Beneficiario->Componente->Grado->nombre; ?></td>
      <td>Sexo</td>
      <td ><?php echo $Beneficiario->sexo; ?></td>
    </tr>
    <tr>
      <td>Fecha Ingreso</td>
      <td><?php 

          $f = explode('-',$Beneficiario->fecha_ingreso);
          
         echo $f[2] . '-' . $f[1] . '-' . $f[0];
      ?>
      </td>
      <td>Tiempo de Serv.</td>
      <td><?php echo $Beneficiario->tiempo_servicio; ?></td>
      <td>N° Hijos</td>
      <td><?php echo $Beneficiario->numero_hijos; ?></td>
    </tr>
    <tr>
      <td>Últ. Ascenso</td>
      <td><?php 
         $f =  explode('-',$Beneficiario->fecha_ultimo_ascenso);          
         echo $f[2] . '-' . $f[1] . '-' . $f[0];
       ?>
      </td>
      <td>Estatus de N° Ascenso</td>
      <td><?php echo $Beneficiario->no_ascenso; ?></td>
      <td>St. Profesional</td>
      <td><?php echo $Beneficiario->profesionalizacion; ?></td>
    </tr>
    <tr>
     <td>Años Recon.</td>
     <td><?php echo $Beneficiario->ano_reconocido; ?>
     </td>
     <td>Meses Recon.</td>
     <td><?php echo $Beneficiario->mes_reconocido; ?></td>
     <td>Dias Recon.</td>
     <td><?php echo $Beneficiario->dia_reconocido; ?></td>
   </tr>
   

</table><br>

<table>
  <thead>
    <tr>
      <th colspan="4">Datos de la Solicitud</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        N° De Oficio
      </td>
      <td>
        <?php echo $Medida->numero_oficio?>
      </td>    
      <td style="text-align:right">
        Fecha del documento
      </td>
      <td>
        <?php echo $Medida->fecha?>
      </td>
    </tr>

    <tr>
      <td>
        Expediente
      </td>
      <td>
        <?php echo $Medida->numero_expediente?>
      </td>    
      <td style="text-align:right">
        Tipo de Embargo
      </td>
      <td>
        <?php echo $Medida->tipo_nombre?>
      </td>
    </tr>

  </tbody>
</table>
<br>
<table>
  <thead>
    <tr>
      <th colspan="4">Retención</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 140px">
        Monto
      </td>
      <td colspan="3">
        <?php
          if($Medida->porcentaje != 0){
            echo $Medida->porcentaje . '%';
          }elseif ($Medida->monto > 0){
            echo $Medida->monto . ' Bs.';
          }
        ?>
      </td>
    </tr>
    <tr>
      <td style="width: 140px">
        Forma de Pago:
      </td>
      <td colspan="3">
        <?php
          echo $Medida->forma_pago_text;
        ?>
      </td>
    </tr>

  </tbody>
</table>
<br>
<table>
  <thead>
    <tr>
      <th colspan="4">Datos Ente Judicial</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 140px">
        Institución:
      </td>
      <td colspan="3">
        <?php
          echo $Medida->institucion;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Autoridad:
      </td>
      <td colspan="3">
        <?php
          echo $Medida->nombre_autoridad;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Cargo:
      </td>
      <td colspan="3">
        <?php
          echo $Medida->cargo;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Estado:
      </td>
      <td>
        <?php
          echo $Medida->estado;
        ?>
      </td>
      <td>
        Ciudad:
      </td>
      <td>
        <?php
          echo $Medida->ciudad;
        ?>
      </td>
    </tr>
  </tbody>
</table>
<br>
<table>
  <thead>
    <tr>
      <th colspan="4">Datos Beneficiario</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 140px">
        Beneficiario:
      </td>
      <td colspan="3">
        <?php
          echo $Medida->nombre_beneficiario;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Cedula:
      </td>
      <td>
        <?php
          echo $Medida->cedula_beneficiario;
        ?>
      </td>
      <td style="text-align:right">
        Parentesco:
      </td>
      <td >
        <?php
          echo $Medida->parentesco_nombre;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Autorizado:
      </td>
      <td>
        <?php
          echo $Medida->nombre_autorizado;
        ?>
      </td>
      <td style="text-align:right"    >
        Cedula:
      </td>
      <td>
        <?php
          echo $Medida->cedula_autorizado;
        ?>
      </td>
    </tr>
  </tbody>
</table>
<br>



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

</body>
</html>
