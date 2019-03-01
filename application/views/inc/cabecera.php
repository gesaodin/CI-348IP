<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>...:: Pensiones ::...</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables/select.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables/editor.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/select2.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datepicker/datepicker3.css">
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
    <!-- <header class="header" style="background-color:#3c8dbc">
        <div class="row">
            <div class="col-md-3 hidden-xs"><img src='/SSSIFANB/images/ng.png' class="img-responsive" alt="Responsive image"
                                                 style='float: left;'></div>
            <div class="col-md-6 hidden-xs">
                <center><img src='/SSSIFANB/images/rv.png' class="img-responsive" alt="Responsive image" style="margin-top:6px">
                </center>
            </div>
            <div class="col-md-3 hidden-xs"><img src='/SSSIFANB/images/lg.png' class="img-responsive" alt="Responsive image"
                                                 style="float:right;"></div>
        </div>
    </header> -->
