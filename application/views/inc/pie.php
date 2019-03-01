

    <?php $this->load->view('inc/mensaje.php');?>

    <script src="<?php echo base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/fastclick/fastclick.min.js"></script>
    <script src="<?php echo base_url()?>assets/dist/js/app.min.js"></script>
    <script src="<?php echo base_url()?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.select.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.editor.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datatables/buttons.print.min.js"></script>


    <script src="<?php echo base_url()?>assets/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo base_url()?>assets/moment/moment.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/iCheck/icheck.min.js"></script>
  <script>
    let token = "<?php echo $token;?>";
    sessionStorage.setItem('ipsfaToken', token);
    function principal(){
        $(location).attr('href', sUrlP + "index");
     }

    function check(){
      $('.mailbox-messages input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });

    }


    $(function () {
        check();
        $(".select2").select2();
        let estados = [];


        $('#fingreso').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });

        $('#fuascenso').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });

        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("#datemask2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();
        $('#reservation').daterangepicker();
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});
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

        $('#datepicker').datepicker({

          format: 'dd/mm/yyyy',
          autoclose: true
        });
        $('#datepicker1').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });
        $('#datepicker2').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true
        });

        ruta = sUrlP + "ObtenerEstados";
        $.getJSON(ruta, function(data) {
          sessionStorage.setItem('ipsfaEstado', JSON.stringify(data));
        }).done(function(msg) {

        }).fail(function(jqXHR, textStatus) {

        });
      });
    </script>

    <script src="<?php echo base_url()?>application/views/js/gblmenu.js"></script>
