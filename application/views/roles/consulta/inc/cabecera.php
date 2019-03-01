

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>...:: Prestaciones ::...</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.css">
    
    <!-- Font Awesome 
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/select2.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datepicker/datepicker3.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    <script type="text/javascript">
      /**
      * Validar Ubicacion
      * @return ubicacion
      */
      var sUrl = "<?php echo base_url(); ?>";
      var sUrlP = sUrl + 'index.php' + <?php echo "/" . __CONTROLADOR . "/";?>;
      function cerrar(){
        window.history.back();  
      }
      
      Number.prototype.formatMoney = function(c, d, t){
      var n = this, 
          c = isNaN(c = Math.abs(c)) ? 2 : c, 
          d = d == undefined ? "." : d, 
          t = t == undefined ? "," : t, 
          s = n < 0 ? "-" : "", 
          i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
          j = (j = i.length) > 3 ? j % 3 : 0;
         return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
       };

    </script>

  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">