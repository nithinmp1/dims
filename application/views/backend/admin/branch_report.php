<?php
    $this->load->view('backend/admin/branch_report1',['from' => $from, 'to' => $to]);
?>
<br>
<br>
<footer class="main"></footer>

<div class="row" >
    <form action="<?=base_url('index.php?admin/branch_report')?>" method="POST">
    <div class="col-md-6">
        <?php $this->load->view('backend/admin/branch_form'); ?>
    </div>
    <div class="col-md-4">
        <div class="col-sm-5">
            <input type="text" class="form-control datepicker" name="fromDate" id="fromDate" value="" data-start-view="2">

        </div>
        <div class="col-sm-5">
            <input type="text" class="form-control datepicker" name="toDate" id="toDate" value="" data-start-view="2">

        </div>
    </div>
    <div class="col-md-2">
        <input type="submit" name="branch_report" value="Apply">
    </div>
    </form>
</div>

<footer class="main"></footer>

<div class="row" >
    <div class="col-md-6">
        <?php $this->load->view('backend/admin/branch_staff'); ?>
    </div>
    <div class="col-md-6">
        <?php $this->load->view('backend/admin/branch_student'); ?>
    </div>
</div>

<div class="row" >
    <div class="col-md-6">
        <?php $this->load->view('backend/admin/branch_customer'); ?>
    </div>
    <div class="col-md-6">
        <?php $this->load->view('backend/admin/reward_masters',['branch_id'=>isset($_POST['branch_id'])?$_POST['branch_id']:1]); ?>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
        <?php $this->load->view('backend/admin/branch_task'); ?>
    </div>
</div>
<div class="row" >
    <div class="col-md-4">
        <?php $this->load->view('backend/admin/branch_task_chart'); ?>
    </div>
    <div class="col-md-4">
        <?php $this->load->view('backend/admin/branch_profit_chart'); ?>
    </div>
    <div class="col-md-4">
        <?php $this->load->view('backend/admin/branch_expense_chart'); ?>
    </div>
</div>
<div class="row" >
    
</div>











<script type="text/javascript">
    $("#branch_id").change(function (event) {
        filter();
    });

    $("#fromDate").change(function (event) {
        filter();
    });

    $("#toDate").change(function (event) {
        filter();
    });

    function filter() {
        var branch_id = $("#branch_id").val();
        var fromDate = $("#fromDate").val();
        var toDate = $("#toDate").val();
        $.post( "<?php echo base_url(); ?>index.php?admin/branchReport", { 'branch_id': branch_id, 'fromDate': fromDate, 'toDate': toDate })
          .done(function( data ) {
            // alert( "Data Loaded: " + data );
          });
    }
</script>