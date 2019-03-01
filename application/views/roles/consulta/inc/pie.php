
 
    <?php $this->load->view('inc/mensaje.php');?>


    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!--
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     SlimScroll -->
    <script src="<?php echo base_url()?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url()?>assets/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url()?>assets/dist/js/demo.js"></script> 

    <script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script> 

    <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 


    
 

    
     <!--Date-->
    <!-- Select2 -->
    <script src="<?php echo base_url()?>assets/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url()?>assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="<?php echo base_url()?>assets/moment/moment.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="<?php echo base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?php echo base_url()?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
  <!--FIN DATE-->
  <!-- Page script -->
  <script>

    function principal(){
        $(location).attr('href', sUrlP + "index");
     }
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        $('#fingreso').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });

        $('#fuascenso').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });     

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        }
        );

        //Date picker
        $('#datepicker').datepicker({

          format: 'dd/mm/yyyy',
          autoclose: true
        });
        $('#datepicker1').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });
        /**
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });


        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
        **/
      });
    </script>